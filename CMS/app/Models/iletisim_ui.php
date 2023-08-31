<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class iletisim_ui extends Model
{
    use HasFactory;
    protected $table ='iletisim_form';
    public $timestamps = false;
    protected $primaryKey = 'id';


    protected $fillable=['id','title','description','contact_form'];
    public function form_name()
    {
        return $this->belongsTo(iletisimForm::class, 'contact_form');
    }
}
