<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section_Setting extends Model
{
    use HasFactory;
    
    
    protected $table ='section_setting';
    public $timestamps = false;
    protected $primaryKey = 'setting_id';

    protected $fillable=['setting_id','section_id','setting_name','setting_value'];
}
