<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalCited extends Model
{
    use HasFactory;

    protected $fillable = [
        'proposal_id',
        'journal_title',//Refereed Journal Orig Published
        'publication',
        'publisher',//Title of New Publication(Original Research was Cited)
        'authors',
        'year_published',
        'link',
        'vol_no',
        'pages',
        'file_1',
        'file_2',
        'file_3',
        'file_4',
        'status',
        'remarks',
        
    ];

    public function proposal()
{
    return $this->belongsTo(Proposal::class);
}
}
