<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Research extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'type',
        'leader',
        'leader_id',
        'status',
       // 'iscreated_suc',
        'is_internally_funded',
        'date_published',
        'date_presented',
        'date_patented',
        'is_utilized',
        'is_patented',
        'is_published',
        'is_presented',
        'date_utilized',
        'date_completed',
        'year_completed',
        'year_published',
        'year_presented',
        'year_patented',
        'year_utilized',
        'year_book_cited',
        'year_journal_cited',
        'discipline_covered',
        'deliverables',
        'program_component',
        'funding_agency',
        'contract_from',
        'contract_to',
        'budget',
        'university_research_agenda',
        'completed_file',
        'partner_contract_file',
        'college',
        'remarks',
        'is_editable',
        'location_from',
        'location_to',
        'station', 
        'funded_on',
        'budget_bsu',
        'is_book_cited',
        'is_journal_cited'
        
    ];
    
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function requirements() {
        return $this->hasOne(SucRequirements::class);
    }
    
    public function members()
    {
        return $this->hasMany(ProposalMembers::class);
    }
    
    public function storePaperPublished() {
        return $this->hasMany(PaperPublished::class);
    }
    
    public function storeBookCited() {
        return $this->hasMany(BookCited::class);
    }
    
    public function storeJournalCited() {
        return $this->hasMany(JournalCited::class);
    }
    
    public function storeUtilized() {
        return $this->hasMany(Utilized::class);
    }
    public function storePaperPresented() {
        return $this->hasMany(PaperPresented::class);
    }
    public function storePatented() {
        return $this->hasMany(Patented::class);
    }
    public function contains($a,$s){
        if($a == $s){
            return true;
        }
        else{
            return false;
        }
    }
}
