<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marka extends Model
{
    use HasFactory;
    protected $table ='markalar';
    public $timestamps = false;
    protected $primaryKey = 'Id';


    protected $fillable=['Id','MarkaName','MarkaLogo'];

    

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($markalar) {
            // Veritabanından silme işlemi gerçekleşmeden önce eklenen klasörden de silme işlemini yapmak için bu event'i kullanabiliriz.
            $filePath = public_path($markalar->MarkaLogo); // Eğer logolar public klasöründe saklanıyorsa.

            // Eğer dosya varsa silme işlemini yaparız
            if (file_exists($filePath)) {
            unlink($filePath);
            }
        });
    }
}
