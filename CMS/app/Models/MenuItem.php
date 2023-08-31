<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;
    protected $table ='menuitem';
    public $timestamps = false;
    protected $primaryKey = 'ItemId';

    protected $fillable=['ItemId','MenuId','ItemAdı','ItemLink','ItemSırası','link_open'];

    public function ustMenu()
    {
        return $this->belongsTo(Menu::class, 'MenuId');
    }
}
