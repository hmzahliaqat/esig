<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class sharedDocuments extends Model
{
    protected $fillable = [
        'document_id',
        'user_id',
        'employee_id',
        'access_hash',
        'status',
        'signed_at',
        'valid_for',
        'file_path',
        'pdf_path'
    ];


    public function document()
    {
        return $this->belongsTo(Document::class);
    }


    /**
     * Get the signed versions of this shared document
     */
    public function signedDocuments()
    {
        return $this->hasMany(SignedDocuments::class);
    }

    /**
     * Get the share URL
     */
    public function getShareUrlAttribute(): string
    {
        return route('documents.shared', ['hash' => $this->access_hash]);
    }

    public function isExpired()
    {
        return Carbon::parse($this->created_at)
            ->addMinutes((int) $this->valid_for)
            ->isPast();
    }
}
