<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Footer_Setting extends Model
{
    use HasFactory;
    
    protected $table ='footer_settings';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable=['id','icon_color','text_color','footer_background_color','menu_group','footer_logo'];
}
