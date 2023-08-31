<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modul extends Model
{
    use HasFactory;

    protected $table ='modul';
    public $timestamps = false;
    protected $primaryKey = 'modul_id';

    protected $fillable=['modul_id','name','content','pleace_holder'];

}
