<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patented extends Model
{
    use HasFactory;
    protected $fillable = [
        'proposal_id',
        'patent_no',
        'date_issue',
        'utilization',
        'product_name',
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
