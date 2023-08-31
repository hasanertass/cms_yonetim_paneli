<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePageContent extends Model
{
    use HasFactory;
    protected $table ='home-page-content';
    public $timestamps = false;
    protected $primaryKey = 'id';
    
    protected $fillable=['id','image','title','description','buton-link','otherpageimage','status'];
}
