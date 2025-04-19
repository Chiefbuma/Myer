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
    protected $primaryKey = 'chronic_id'; // Specify the primary key column

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
        'deleted_at', // Include for mass assignment if needed
    ];

    protected $casts = [
        'refill_date' => 'date',
        'annual_check_up' => 'date',
        'specialist_review' => 'date',
        'last_visit' => 'date',
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
