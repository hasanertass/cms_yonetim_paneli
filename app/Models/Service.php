<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table ='services';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable=['id','title','short_description','long_description','small_image','large_image','icon','status','home_page_status','meta_title','meta_description','meta_keywords'];
}
