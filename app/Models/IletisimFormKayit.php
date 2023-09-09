<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IletisimFormKayit extends Model
{
    use HasFactory;
    protected $table ='iletisimformkayit';
    public $timestamps = false;
    protected $primaryKey = 'id';
    
    protected $fillable=['id','form_id','column1','column2','column3','column4','column5','column6','column7','column8','column9','column10','column11','column12','status'];

    public function formkayit()
    {
        return $this->belongsTo(IletisimForm::class, 'form_id');
    }
}
