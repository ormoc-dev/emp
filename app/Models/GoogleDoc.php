<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleDoc extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_name',
        'google_docs_link'
    ];
}
