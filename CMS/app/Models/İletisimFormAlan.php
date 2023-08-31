<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class İletisimFormAlan extends Model
{
    use HasFactory;
            
    protected $table ='contactFormAlan';
    public $timestamps = false;
    protected $primaryKey = 'AlanId';


    protected $fillable=['AlanId','FormId','AlanName','PleaceHolder','AlanType','AlanSırası'];

    public function Form()
    {
        return $this->belongsTo(iletisimForm::class, 'FormId');
    }
    public function scopeOrderByAlan($query)
    {
        return $query->orderBy('AlanSırası', 'asc');
    }
}
