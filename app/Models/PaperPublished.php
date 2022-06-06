<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaperPublished extends Model
{
    use HasFactory;
    protected $fillable = [
        'proposal_id',
        'journal_title',
        'publication',
        'publication_title',
        'publisher',
        'year_accepted',
        'year_published',
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
