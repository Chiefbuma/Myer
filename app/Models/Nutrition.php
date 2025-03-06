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
    ];

    protected $casts = [
        'last_visit' => 'date',
        'next_review' => 'date',
        'visit_date' => 'date',
        'revenue' => 'double',
    ];

    // User.php (or the relevant model)
    public function scheme()
    {
        return $this->belongsTo(Scheme::class, 'scheme_id');
    }
}
