<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IletisimForm extends Model
{
    use HasFactory;
            
    protected $table ='contactform';
    public $timestamps = false;
    protected $primaryKey = 'FormId';


    protected $fillable=['FormId','FormName','form_description','sayfa_id'];

    public function formAlanları()
    {
        return $this->hasMany(iletisimFormAlan::class, 'FormId');
    }
    public function formkayit()
    {
        return $this->hasMany(IletişimFormKayit::class, 'form_id');
    }
    public function sayfa()
    {
        return $this->belongsTo(Page::class, 'sayfa_id');
    }
    public function iletisim_ui()
    {
        return $this->hasMany(iletisim_ui::class, 'contact_form');
    }
}
