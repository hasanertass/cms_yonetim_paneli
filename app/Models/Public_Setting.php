<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Public_Setting extends Model
{
    use HasFactory;
    
    protected $table ='public_settings';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable=['id','fav_icon','section_title_color'];
}
