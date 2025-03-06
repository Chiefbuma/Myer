<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $table = 'branch'; // Ensure the table name is correct
    protected $primaryKey = 'branch_id'; // Specify the primary key column

    protected $fillable = [
        'branch_name',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true; // Ensure timestamps are managed automatically
}
