<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenüList extends Model
{
    use HasFactory;
    protected $table ='menü_list';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable=['id','anasayfa_menü','footer_menü'];
    public function menüList()
    {
        return $this->belongsTo(Menu_Alan::class, 'anasayfa_menü');
    }
    public function menüList2()
    {
        return $this->belongsTo(Menu_Alan::class, 'footer_menü');
    }
}
