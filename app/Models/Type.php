<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = ['brand_id', 'name'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function vechiles()
    {
        return $this->hasMany(Vechile::class);
    }

    public function productionyears()
    {
        return $this->hasMany(Productionyear::class);
    }

    public function colors()
    {
        return $this->hasMany(Color::class);
    }

}
