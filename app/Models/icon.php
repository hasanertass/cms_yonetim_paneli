<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class icon extends Model
{
    use HasFactory;
    protected $table ='icons';
    public $timestamps = false;
    protected $primaryKey = 'id';


    protected $fillable=['id','icon'];

}
