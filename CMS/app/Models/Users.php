<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Kullanıcı modeli Authenticatable'dan türetildi
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Authenticatable // Authenticatable arabirimini uygulandı
{
    use HasFactory;
    protected $table ='users';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable=['id','name','lastname','email','username','password','remember_token','address','city','county'];
}