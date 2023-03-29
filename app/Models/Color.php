<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected $fillable = ['type_id', 'name'];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function vechile()
    {
        return $this->hasMany(Vechile::class);
    }
}
