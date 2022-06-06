<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookCited extends Model
{
    use HasFactory;

    protected $fillable = [
        'proposal_id',
        'book_title',
        'isbn',
        'publisher',
        'authors',
        'link',
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
