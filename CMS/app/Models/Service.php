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


    protected $fillable=['id','title','description','icon'];
    public function icon_class()
    {
        return $this->belongsTo(icon::class, 'icon');
    }
}
