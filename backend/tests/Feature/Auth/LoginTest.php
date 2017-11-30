<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Auth\UserService;
use App\User;

class LoginTokenTest extends TestCase
{

    private $email = 'adm1@tests.com';
    private $user;


    /** tests login by token */
    public function testLogin()
    {
        // do login
        $response = $this->post('/api/login', ['email' => $this->email, 'password' => '12345678']);
        $response->assertStatus(200);
        $json = $response->json();

        // uses token to access login data
        $headers = ['HTTP_Authorization' => 'Bearer ' . $json['token']];
        $response = $this->withHeaders($headers)
        ->get('/api/login');
        $response->assertStatus(200);
    }


    /** tests login by actingAs */
    public function testActingAs()
    {
        $this->actingAs($this->user, 'api');
        $response = $this->get('/api/login');
        $response->assertStatus(200);
    }


    public function testRoles()
    {
        // config roles
        $roles = [
            ['name' => 'profiles', 'write_access' => true ],
            ['name' => 'reports']
        ];
        $this->user->roles()->createMany($roles);

        // tests returned roles
        $this->actingAs($this->user, 'api');
        $response = $this->get('/api/login');
        $response->assertStatus(200);
        $response->assertJson([
            'email' => $this->email,
            'roles' => $roles
        ]);
    }


    public function setUp() {
        parent::setUp();
        $this->clear();
        $service = new UserService();
        $this->user = $service->createUser(null, ['name' => 'adm1', 'email' => $this->email, 'password' => '']);
        $service->resetPassword(null, $this->email);
        $this->disableExceptionHandling();
    }

    private function clear() {
        $user = \App\User::where('email', $this->email)->first();
        $user->roles()->each(function ($role) {
            $role->delete();
        });
        $user->delete();
    }

}
