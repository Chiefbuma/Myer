<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    use HasFactory;

    protected $table = 'diagnosis'; // Explicitly set the table name

    protected $fillable = [


        'diagnosis_name',

    ];

    protected $primaryKey = 'diagnosis_id'; // Set the primary key

    public $incrementing = true; // If diagnosis_id is not auto-incrementing

    public $timestamps = true; // Enable created_at and updated_at timestamps
}
