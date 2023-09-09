<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SSS extends Model
{
    use HasFactory;
    protected $table ='sss';
    public $timestamps = false;
    protected $primaryKey = 'Id';

    protected $fillable=['Id','sayfa_id','Soru','Cevap','Sira','Durum'];

    public function soruSayfa()
    {
        return $this->belongsTo(Page::class, 'sayfa_id');
    }
}
