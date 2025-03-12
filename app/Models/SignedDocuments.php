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
}
