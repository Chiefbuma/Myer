<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patient'; // Ensure this matches your table name

    protected $primaryKey = 'patient_id';

    protected $fillable = [
        'patient_id',
        'firstname',
        'lastname',
        'dob',
        'gender',
        'age',
        'location',
        'phone_no',
        'email',
        'patient_no',
        'diagnosis',
        'patient_status',
        'cohort_id', // Ensure this is in the fillable array
        'branch_id',
        'diagnosis_id',
        'scheme_id',
        'route_id',
    ];

    protected $casts = [
        'dob' => 'date',
    ];

    public function cohort()
    {
        return $this->belongsTo(Cohort::class, 'cohort_id', 'cohort_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'branch_id');
    }

    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class, 'diagnosis_id', 'diagnosis_id');
    }



    // Patient.php (Model)
    public function scheme()
    {
        return $this->belongsTo(Scheme::class, 'scheme_id', 'scheme_id');
    }

    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id', 'route_id');
    }
}
