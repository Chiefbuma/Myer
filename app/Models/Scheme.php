<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scheme extends Model
{
    use HasFactory;

    protected $table = 'scheme'; // Ensure the table name is correct
    protected $primaryKey = 'scheme_id'; // Specify the primary key column

    protected $fillable = [
        'scheme_name',    // The name of the scheme
        'payment_method', // The payment method for the scheme
        'created_at',     // Timestamp for when the record was created
        'updated_at',     // Timestamp for when the record was last updated
        'deleted_at', // Include for mass assignment if needed
    ];

    protected $casts = [
        'deleted_at' => 'datetime', // Cast deleted_at as datetime
    ];

    public $timestamps = true; // Ensure timestamps are managed automatically

    // Scheme.php
    public function chronic()
    {
        return $this->hasMany(Chronic::class);
    }

    public function nutrition()
    {
        return $this->hasMany(Nutrition::class);
    }

    public function Physiotherapy()
    {
        return $this->hasMany(Physiotherapy::class);
    }
}
