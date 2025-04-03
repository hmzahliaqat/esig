<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentField extends Model
{
    protected $fillable = [
        'document_id',
        'type',
        'position_x',
        'position_y',
        'page',
        'width',
        'height',
        'value',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
