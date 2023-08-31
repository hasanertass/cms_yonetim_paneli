<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu_Alan extends Model
{
    use HasFactory;
    protected $table ='menu_alan';
    public $timestamps = false;
    protected $primaryKey = 'alan_id';

    protected $fillable=['alan_id','alan_name'];
    public function menu()
    {
        return $this->hasMany(Menu::class, 'alan_id');
    }
    public function menüList()
    {
        return $this->hasMany(MenüList::class, 'anasayfa_menü');
    }
    public function menüList2()
    {
        return $this->hasMany(MenüList::class, 'footer_menü');
    }
}
