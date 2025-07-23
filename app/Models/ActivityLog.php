<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'description',
    ];

    /**
     * Relasi ke user yang melakukan aktivitas.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
