<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Head_Setting extends Model
{
    use HasFactory;
    
    protected $table ='head_settings';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable=['id','icon_color','text_color','head_background_color','menu_group','head_logo'];
}
