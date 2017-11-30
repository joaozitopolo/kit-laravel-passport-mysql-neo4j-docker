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


    /** testa login por token */
    public function testLogin()
    {
        // efetua login
        $response = $this->post('/api/login', ['email' => $this->email, 'password' => '12345678']);
        $response->assertStatus(200);
        $json = $response->json();

        // utiliza token para acessar dados do login
        $headers = ['HTTP_Authorization' => 'Bearer ' . $json['token']];
        $response = $this->withHeaders($headers)
        ->get('/api/login');
        $response->assertStatus(200);
    }


    /** testa login por actingAs */
    public function testActingAs()
    {
        $this->actingAs($this->user, 'api');
        $response = $this->get('/api/login');
        $response->assertStatus(200);
    }


    public function testRoles()
    {
        // configura roles
        $roles = [
            ['name' => 'profiles', 'write_access' => true ],
            ['name' => 'reports']
        ];
        $this->user->roles()->createMany($roles);

        // teste retorno json
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
