<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cohort extends Model
{
    use HasFactory;

    protected $table = 'cohort';

    protected $primaryKey = 'cohort_id';

    protected $fillable = [

        'cohort_name',
        'team_lead',
        'deleted_at', // Include for mass assignment if needed

    ];

    protected $casts = [
        'deleted_at' => 'datetime', // Cast deleted_at as datetime
    ];



    public $incrementing = true; // If cohort_id is not auto-incrementing

    public $timestamps = true; // Enable created_at and updated_at timestamps


}
