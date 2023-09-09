<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table ='menu';
    public $timestamps = false;
    protected $primaryKey = 'MenuId';

    protected $fillable=['MenuId','alan_id','MenuAdı','MenuSırası','MenuLink','link_open'];

    public function scopeOrderByMenuSırası($query)
    {
        return $query->whereIn('alan_id', function ($query) {
            $query->select('alan_id')
                  ->from('menu')
                  ->groupBy('alan_id');
        })
        ->orderBy('alan_id')
        ->orderBy('MenuSırası', 'asc');
    }
    public function altMenuler()
    {
        return $this->hasMany(MenuItem::class, 'MenuId');
    }
    public function menuAlan()
    {
        return $this->belongsTo(Menu_Alan::class, 'alan_id');
    }
}
