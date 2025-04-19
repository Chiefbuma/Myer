<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    use HasFactory;

    protected $table = 'procedures'; // Ensure the table name is correct
    protected $primaryKey = 'procedure_id'; // Specify the primary key column

    protected $fillable = [
        'procedure_name', // The name of the procedure
        'created_at',     // Timestamp for when the record was created
        'updated_at',     // Timestamp for when the record was last updated
        'deleted_at', // Include for mass assignment if needed
    ];

    protected $casts = [
        'deleted_at' => 'datetime', // Cast deleted_at as datetime
    ];

    public $timestamps = true; // Ensure timestamps are managed automatically

    // Relationship to Scheme
    public function chronic()
    {
        return $this->belongsTo(Chronic::class, 'procedure_id');
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
