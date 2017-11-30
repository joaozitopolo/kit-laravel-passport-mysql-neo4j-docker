<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name', 'write_access'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
