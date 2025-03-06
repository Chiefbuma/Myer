<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

// Import the related models
use App\Models\Scheme;
use App\Models\Procedure;
use App\Models\Specialist;

class Chronic extends Model
{
    use HasFactory;

    protected $table = 'chronic';

    protected $fillable = [
        'procedure_id',
        'speciality_id',
        'refill_date',
        'compliance',
        'exercise',
        'clinical_goals',
        'nutrition_follow_up',
        'psychosocial',
        'annual_check_up',
        'specialist_review',
        'vitals_monitoring',
        'revenue',
        'vital_signs_monitor',
        'patient_id',
        'scheme_id',
        'last_visit',
    ];

    protected $casts = [
        'refill_date' => 'date',
        'annual_check_up' => 'date',
        'specialist_review' => 'date',
        'last_visit' => 'date',
        'revenue' => 'decimal:2',
    ];

    public function scheme()
    {
        return $this->belongsTo(Scheme::class, 'scheme_id', 'scheme_id');
    }
    // Relationship to Procedure
    public function procedures()
    {
        return $this->belongsTo(Procedure::class, 'procedure_id');
    }

    // Relationship to Specialist
    public function specialist()
    {
        return $this->belongsTo(Specialist::class, 'specialist_id');
    }
}
