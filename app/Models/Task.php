<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table='tasks';
    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'datetime:Y-m-d', // This will convert to Carbon instance
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // A Task belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
