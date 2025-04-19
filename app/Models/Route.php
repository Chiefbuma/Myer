<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Route extends Model
{
    use HasFactory;

    protected $table = 'route';

    protected $primaryKey = 'route_id';

    protected $fillable = [
        'route_name',
        'latitude',
        'longitude',
        'deleted_at', // Include for mass assignment if needed

    ];

    protected $casts = [
        'deleted_at' => 'datetime', // Cast deleted_at as Carbon instance
    ];

    //protected $casts = [
    //'latitude' => 'decimal:9,6',
    //'longitude' => 'decimal:9,6',


    // ];


    public $incrementing = true; // If cohort_id is not auto-incrementing
}
