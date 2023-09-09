<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modul_Setting extends Model
{
    use HasFactory;

    
    protected $table ='modul_setting';
    public $timestamps = false;
    protected $primaryKey = 'setting_id';

    protected $fillable=['setting_id','modul_id','setting_name','setting_name2'];
}
