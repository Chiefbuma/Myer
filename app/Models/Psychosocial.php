<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

// Import the related models
use App\Models\Scheme;

class Psychosocial extends Model
{
    use HasFactory;

    protected $table = 'psychosocial';

    protected $primaryKey = 'id'; // Specify the primary key column

    protected $fillable = [
        'patient_id',
        'last_visit',
        'next_review',
        'educational_level',
        'career_business',
        'marital_status',
        'relationship_status',
        'primary_relationship_status',
        'ability_to_enjoy_leisure_activities',
        'spirituality',
        'level_of_self_esteem',
        'sex_life',
        'ability_to_cope_recover_disappointments',
        'rate_of_personal_development_growth',
        'achievement_of_balance_in_life',
        'social_support_system',
        'substance_use',
        'substance_used',
        'assessment_remarks',
        'revenue',
        'scheme_id',
        'visit_date',
    ];

    protected $casts = [
        'last_visit' => 'date',
        'next_review' => 'date',
        'visit_date' => 'date',
        'revenue' => 'int',
    ];

    // User.php (or the relevant model)
    public function scheme()
    {
        return $this->belongsTo(Scheme::class, 'scheme_id');
    }
}
