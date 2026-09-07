<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminLog extends Model
{
    use HasFactory;

    protected $fillable = ['admin_id', 'action', 'description'];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}