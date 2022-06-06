<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utilized extends Model
{
    use HasFactory;
    protected $fillable = [
        'proposal_id',
        'file_1',
        'file_2',
        'file_3',
        'status',
        'remarks',
    ];
    
}
