<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user1()
    {
        return $this->hasOne(User::class, 'user1_id');
    }
    public function user2()
    {
        return $this->hasOne(User::class, 'user2_id');
    }
}
