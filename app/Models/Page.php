<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
            
    protected $table ='pages';
    public $timestamps = false;
    protected $primaryKey = 'sayfa_id';


    protected $fillable=['sayfa_id','title','meta_title','meta_description','meta_keywords','slug','AnaSayfa','yayin_durumu'];
    public function section()
    {
        return $this->hasMany(Section::class, 'sayfa_id');
    }
    public function soru()
    {
        return $this->hasMany(SSS::class, 'sayfa_id');
    }
    public function sayfa()
    {
        return $this->hasMany(IletisimForm::class, 'sayfa_id');
    }
}
