<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicationUse extends Model
{
    use HasFactory;

    protected $table = 'medication_use';

    protected $primaryKey = 'medication_use_id';

    protected $fillable = [
        'days_supplied',
        'no_pills_dispensed',
        'frequency',
        'medication_id',
        'patient_id',
        'visit_date',
        'deleted_at', // Include for mass assignment if needed
    ];

    protected $casts = [
        'visit_date' => 'date',
        'deleted_at' => 'datetime', // Cast deleted_at as datetime
    ];

    // Define the relationship to the Medication model
    public function medication()
    {
        return $this->belongsTo(Medication::class, 'medication_id', 'medication_id');
    }
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
