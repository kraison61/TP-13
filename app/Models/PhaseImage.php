<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PhaseImage extends Model
{
    protected $fillable = [
        'project_phase_id',
        'image_path',
        'description',
    ];

    public function projectPhase(): BelongsTo
    {
        return $this->belongsTo(ProjectPhase::class);
    }
}
