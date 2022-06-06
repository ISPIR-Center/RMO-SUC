<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaperPresented extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'proposal_id',
        'paper_title',
        'presenters',
        'paper_title_2',
        'venue',
        'date',
        'organizer',
        'conference_type',
        'file_1',
        'file_2',
        'file_3',
        'status',
        'remarks',
        
    ];
    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}
