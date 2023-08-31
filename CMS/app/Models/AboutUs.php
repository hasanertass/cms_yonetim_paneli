<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;

    protected $table ='aboutus';
    public $timestamps = false;
    protected $primaryKey = 'id';
    
    protected $fillable=['id','baslik','aciklama1','aciklama2','görsel','görsel2','prop1','prop2','prop3','prop4','prop5','prop6','prop7','prop8','durum'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($about) {
            // Veritabanından silme işlemi gerçekleşmeden önce eklenen klasörden de silme işlemini yapmak için bu event'i kullanabiliriz.
            $filePath = public_path($about->görsel); // Eğer logolar public klasöründe saklanıyorsa.
            $filePath2 = public_path($about->görsel2); 
            // Eğer dosya varsa silme işlemini yaparız
            if (file_exists($filePath)) {
            unlink($filePath);
            }
            if ($about->görsel2&&file_exists($filePath2)) {
                unlink($filePath2);
            }
        });
    }
}
