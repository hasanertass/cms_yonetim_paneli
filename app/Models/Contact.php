<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
                
    protected $table ='contact';
    public $timestamps = false;
    protected $primaryKey = 'Id';
    
    protected $fillable=['Id','SirketAdi','Adres','Adres2','Mail','Mail2','Telefon','Telefon2','work','Harita','KullanımDurumu'];
}
