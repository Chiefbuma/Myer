<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialist extends Model
{
    use HasFactory;

    protected $table = 'specialist'; // Ensure the table name is correct
    protected $primaryKey = 'specialist_id'; // Specify the primary key column

    protected $fillable = [
        'specialist_name', // The name of the specialist
        'specialty',       // The specialty of the specialist
        'created_at',      // Timestamp for when the record was created
        'updated_at',      // Timestamp for when the record was last updated
    ];

    public $timestamps = true; // Ensure timestamps are managed automatically


    // Relationship to Scheme
    public function chronic()
    {
        return $this->hasMany(Chronic::class, 'specialist_id');
    }
}
