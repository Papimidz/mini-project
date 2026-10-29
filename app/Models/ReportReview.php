<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportReview extends Model
{
    protected $fillable = [
        'fire_report_id',
        'reviewer_id',
        'note',
    ];

    public function fireReport(): BelongsTo
    {
        return $this->belongsTo(FireReport::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
