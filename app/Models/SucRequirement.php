<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SucRequirement extends Model
{
    use HasFactory;
    protected $fillable = [
        'research_id',
        'suc_completed_file',
        'suc_contract_file',
        'suc_contract_name',
        'suc_contract_from',
        'suc_contract_to',
    ];

    public function proposal(){
        $this->belongsTo(Research::class);
    }
}
