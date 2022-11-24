<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class CustomerInfo extends Model
{
    use HasFactory;

    protected $table = 'customer_infos';
    protected $fillable = [
        'name', 'email', 'phone_number'
    ];
}
