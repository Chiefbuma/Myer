<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'branch';
    protected $primaryKey = 'branch_id';

    protected $fillable = [
        'branch_name',
        'created_at',
        'updated_at',
        'deleted_at', // Include for mass assignment if needed
    ];

    protected $casts = [
        'deleted_at' => 'datetime', // Cast deleted_at as Carbon instance
    ];

    public $timestamps = true;

    public function users()
    {
        return $this->hasMany(User::class, 'branch_id', 'branch_id');
    }

    /**
     * Get the users relationship including soft deleted ones
     */
    public function usersWithTrashed()
    {
        return $this->hasMany(User::class, 'branch_id', 'branch_id')->withTrashed();
    }

    /**
     * Get only trashed users
     */
    public function trashedUsers()
    {
        return $this->hasMany(User::class, 'branch_id', 'branch_id')->onlyTrashed();
    }
}
