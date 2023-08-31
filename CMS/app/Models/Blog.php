<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $table ='blog';
    public $timestamps = false;
    protected $primaryKey = 'id';
    
    protected $fillable=['id','title','short_description','long_description','date','small_image','large_image','link'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($blog) {
            // Veritabanından silme işlemi gerçekleşmeden önce eklenen klasörden de silme işlemini yapmak için bu event'i kullanabiliriz.
            $filePath = public_path($blog->small_image); // Eğer logolar public klasöründe saklanıyorsa.
            $filePath2 = public_path($blog->large_image);
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
