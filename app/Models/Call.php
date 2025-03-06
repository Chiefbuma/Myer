<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    use HasFactory;

    protected $table = 'calls';

    protected $primaryKey = 'Call_id'; // Specify the primary key column

    protected $fillable = [
        'patient_id',
        'call_results',
        'call_date',
    ];

    protected $casts = [
        'call_date' => 'datetime',
    ];

    // Call.php
    public function callResult()
    {
        return $this->belongsTo(CallResult::class, 'Call_results_id', 'Call_results_id');
    }
}
