<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $table ='section';
    public $timestamps = false;
    protected $primaryKey = 'section_id';


    protected $fillable=['section_id','sayfa_id','section_name','content','section_row','data_piece','section_status'];
    public function contents()
    {
        return $this->hasMany(Contents::class, 'section_id');
    }
    public function Page()
    {
        return $this->belongsTo(Page::class, 'sayfa_id');
    }
}
