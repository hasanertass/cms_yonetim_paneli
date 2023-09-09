<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $table ='news';
    public $timestamps = false;
    protected $primaryKey = 'id';
    
    protected $fillable=['id','baslik','kisa_aciklama','aciklama','tarih','görsel','görsel2','link','status','home_page_status','meta_title','meta_description','meta_keywords'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($news) {
            // Veritabanından silme işlemi gerçekleşmeden önce eklenen klasörden de silme işlemini yapmak için bu event'i kullanabiliriz.
            $filePath = public_path($news->görsel); // Eğer logolar public klasöründe saklanıyorsa.
            $filePath2 = public_path($news->görsel2);
            // Eğer dosya varsa silme işlemini yaparız
            if (file_exists($filePath)) {
            unlink($filePath);
            }
            if (file_exists($filePath2)) {
                unlink($filePath2);
                }
        });
    }
}
