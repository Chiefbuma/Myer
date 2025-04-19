<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

// Import the related models
use App\Models\Scheme;

class Physiotherapy extends Model
{
    use HasFactory;

    protected $table = 'physiotherapy';

    protected $fillable = [
        'patient_id',
        'scheme_id',
        'visit_date',
        'pain_level',
        'mobility_score',
        'range_of_motion',
        'strength',
        'balance',
        'walking_ability',
        'posture_assessment',
        'exercise_type',
        'frequency_per_week',
        'duration_per_session',
        'intensity',
        'pain_level_before_exercise',
        'pain_level_after_exercise',
        'fatigue_level_before_exercise',
        'fatigue_level_after_exercise',
        'post_exercise_recovery_time',
        'functional_independence',
        'joint_swelling',
        'muscle_spasms',
        'progress',
        'treatment',
        'challenges',
        'adjustments_made',
        'calcium_levels',
        'phosphorous_levels',
        'vit_d_levels',
        'cholesterol_levels',
        'iron_levels',
        'heart_rate',
        'blood_pressure_systolic',
        'blood_pressure_diastolic',
        'oxygen_saturation',
        'hydration_level',
        'sleep_quality',
        'stress_level',
        'medication_usage',
        'therapist_notes',
        'revenue',
        'deleted_at', // Include for mass assignment if needed
    ];

    protected $casts = [
        'visit_date' => 'date',
        'revenue' => 'decimal:2',
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
