<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vechile extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'type_id',
        'productionyear_id',
        'color_id',
        'police_num',
        'chassis_num',
        'expiry_date_stnk'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function productionyear()
    {
        return $this->belongsTo(Productionyear::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

}
