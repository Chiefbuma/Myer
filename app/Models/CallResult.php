<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallResult extends Model
{
    use HasFactory;

    protected $table = 'call_results'; // Ensure the table name is correct
    protected $primaryKey = 'Call_results_id'; // Specify the primary key column

    protected $fillable = [
        'Call_result', // The main column for call result data
        'created_at',
        'updated_at',
        'deleted_at', // Include for mass assignment if needed
    ];

    protected $casts = [

        'deleted_at' => 'datetime', // Cast deleted_at as datetime
    ];

    public $timestamps = true; // Ensure timestamps are managed automatically


    // CallResult.php
    public function calls()
    {
        return $this->hasMany(Call::class, 'Call_results_id', 'Call_results_id');
    }
}
