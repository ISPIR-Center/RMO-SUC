<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchMember extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'proposal_id',
        'fullname',
        'employee_no',
        'college',
        'email',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
