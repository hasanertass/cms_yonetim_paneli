<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    use HasFactory;
        
    protected $table ='logo';
    public $timestamps = false;
    protected $primaryKey = 'Id';


    protected $fillable=['Id','Name','Alt_text','FilePath'];

    public function getFullFilePathAttribute()
    {
        return asset('storage/' . $this->FilePath);
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($logo) {
            // Veritabanından silme işlemi gerçekleşmeden önce eklenen klasörden de silme işlemini yapmak için bu event'i kullanabiliriz.
            $filePath = public_path($logo->FilePath); // Eğer logolar public klasöründe saklanıyorsa.

            // Eğer dosya varsa silme işlemini yaparız
            if (file_exists($filePath)) {
            unlink($filePath);
            }
        });
    }

}
