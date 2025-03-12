<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sharedDocuments extends Model
{
    protected $fillable = [
        'document_id',
        'access_hash',
        'status',
        'signed_at',
        'valid_for'
    ];


    public function document(){
        return $this->belongsTo(Document::class);
    }



}
