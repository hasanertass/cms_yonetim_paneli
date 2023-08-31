<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class E_Bülten extends Model
{
    use HasFactory;
    protected $table ='e-bulten';
    public $timestamps = false;
    protected $primaryKey = 'id';


    protected $fillable=['id','mail'];
}
