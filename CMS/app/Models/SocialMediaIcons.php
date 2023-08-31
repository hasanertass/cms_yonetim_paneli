<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMediaIcons extends Model
{
    use HasFactory;
            
    protected $table ='SocialMediaIcons';
    public $timestamps = false;
    protected $primaryKey = 'Id';


    protected $fillable=['Id','Name','Icon','Link'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($icon) {
            // Veritabanından silme işlemi gerçekleşmeden önce eklenen klasörden de silme işlemini yapmak için bu event'i kullanabiliriz.
            $Icon = public_path($icon->Icon); // Eğer logolar public klasöründe saklanıyorsa.

            // Eğer dosya varsa silme işlemini yaparız
            if (file_exists($Icon)) {
                unlink($Icon);
            }
        });
    }
}
