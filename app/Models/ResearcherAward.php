<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearcherAward extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'researcher_id',
        'year'
    ];
}
