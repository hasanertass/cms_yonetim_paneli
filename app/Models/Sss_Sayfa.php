<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sss_Sayfa extends Model
{
    use HasFactory;
    protected $table ='sss_sayfa';
    public $timestamps = false;
    protected $primaryKey = 'sayfa_id';

    protected $fillable=['sayfa_id','sayfa_name'];

    public function soru()
    {
        return $this->hasMany(SSS::class, 'sayfa_id');
    }
}
