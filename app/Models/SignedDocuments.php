<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SignedDocuments extends Model
{
    protected $fillable = [
        'user_id',
        'employee_id',
        'shared_document_id',
        'file_path',
        'pdf_path',
        'page_count',
        'file_type'
    ];

     /**
     * Get the user who owns this document
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the shared document this signed document belongs to
     */
    public function sharedDocument()
    {
        return $this->belongsTo(sharedDocuments::class);
    }

    /**
     * Get the file URL
     */
    public function getFileUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }



}
