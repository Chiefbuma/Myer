<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    use HasFactory;

    protected $table = 'medication';



    protected $fillable = [
        'medication_id',
        'item_name',
        'composition',
        'brand',
        'formulation',
        'category',
        'created_at',
        'updated_at',
        'deleted_at', // Include for mass assignment if needed
    ];

    protected $casts = [
        'deleted_at' => 'datetime', // Cast deleted_at as datetime
    ];

    protected $primaryKey = 'medication_id';

    public $incrementing = true;

    public $timestamps = true;

    // Define the relationship to the MedicationUse model
    public function medicationUses()
    {
        return $this->hasMany(MedicationUse::class, 'medication_id', 'medication_id');
    }
}
