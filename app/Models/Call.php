<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    use HasFactory;

    protected $table = 'calls';

    protected $primaryKey = 'call_id'; // Specify the primary key column

    protected $fillable = [
        'patient_id',
        'call_results',
        'call_date',
        'deleted_at', // Include for mass assignment if needed
    ];

    protected $casts = [
        'call_date' => 'datetime',
        'deleted_at' => 'datetime', // Cast deleted_at as datetime
    ];

    // Call.php
    public function callResult()
    {
        return $this->belongsTo(CallResult::class, 'Call_results_id', 'Call_results_id');
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
