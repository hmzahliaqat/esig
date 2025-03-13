<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;

class Document extends Model
{
    protected $fillable = [
        'title',
        'file_path',
        'pdf_path',
        'page_count',
        'file_type',
        'user_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sharedDocuments()
    {
        return $this->hasMany(sharedDocuments::class);
    }


    public function getFileUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }

    public function getPdfUrlAttribute(): string
    {
        if (strpos($this->pdf_path, 'documents') === 0) {
            return asset('storage/' . $this->pdf_path);
        }

        return asset('storage/' . $this->file_path);
    }



    public function isAuthorized($user_id)
    {
        return $user_id == Auth::id();
    }
}
