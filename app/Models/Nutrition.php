<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

// Import the related models
use App\Models\Scheme;

class Nutrition extends Model
{
    use HasFactory;

    protected $table = 'nutrition';
    protected $primaryKey = 'nutrition_id';

    public $incrementing = true; // Only if nutrition_id is not auto-incrementing


    protected $fillable = [
        'scheme_id',
        'patient_id',
        'last_visit',
        'next_review',
        'muscle_mass',
        'bone_mass',
        'weight',
        'BMI',
        'subcutaneous_fat',
        'visceral_fat',
        'weight_remarks',
        'physical_activity',
        'meal_plan_set_up',
        'nutrition_adherence',
        'nutrition_assessment_remarks',
        'revenue',
        'visit_date',
        'deleted_at', // Include for mass assignment if needed
    ];

    protected $casts = [
        'last_visit' => 'date',
        'next_review' => 'date',
        'visit_date' => 'date',
        'revenue' => 'double',
        'deleted_at' => 'datetime', // Cast deleted_at as datetime
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function scheme()
    {
        return $this->belongsTo(Scheme::class, 'scheme_id');
    }

    public function procedure()
    {
        return $this->belongsTo(Procedure::class, 'procedure_id');
    }

    public function speciality()
    {
        return $this->belongsTo(Specialist::class, 'speciality_id');
    }
}
