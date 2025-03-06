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
    ];

    protected $casts = [
        'visit_date' => 'date',
    ];

    // Define the relationship to the Medication model
    public function medication()
    {
        return $this->belongsTo(Medication::class, 'medication_id', 'medication_id');
    }
}
