<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faculty;
use App\Models\Research;
use App\Models\User;
use App\Models\ResearchMember;
use App\Models\Deliverable;
use App\Models\DisciplineCovered;
use App\Models\SucRequirement;
use App\Models\PaperPublished;
use App\Models\BookCited;
use App\Models\JournalCited;
use App\Models\Patented;
use App\Models\Utilized;
use App\Models\PaperPresented;
use App\Models\SummarySheet;
use App\Models\Report;
use App\Models\ResearcherAward;
use Illuminate\Support\Facades\File;
use DB;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;


class RMOController extends Controller
{
        ################################################## A P P R O V E D T A B ############################################################
        public function rbpDashboard(){
            $user = auth()->user();
            $search = request()->query('search');
            if ($search) {
                $proposals = Research::where('title', 'LIKE', '%' . ($search) . '%')
                                        ->where(['status' => 'APPROVED'])
                                        ->where(['deliverables' => 'Research Based Paper'])
                                        ->orWhere('date_completed', 'LIKE', "%{$search}%")
                                        ->orderBy('created_at', 'desc')
                                        ->paginate(5);
            }
            else {
            $proposals = Research::where(['deliverables' => 'Research Based Paper'])
                                 ->where(['status' => 'APPROVED'])
                                 ->orderBy('created_at', 'desc')       
                                 ->paginate(5);
            }
            return view('rmo.rbp.rbp_dashboard', [
                'user' => $user,
                'proposals' => $proposals,
                'search' => $search,
                'active' => "rmorbp",
            ]);
        }
    
        public function createRBP(){
            $user = auth()->user();
           
            $research_discipline_covered = DB::table('discipline_covereds')->select('name')
                                            ->get();
            
            $leader = User::where('is_active','1')
                            ->where('type', 'Faculty')
                       //     ->select('fullname')
                            ->get();
            return view('rmo.rbp.create', [
                'user' => $user,
                'active' => "rmopending",
                'research_discipline_covered' => $research_discipline_covered,
                'leader' => $leader
            ]);
        }
    
        public function storeRBP(Request $request, Research $research){
           
            $user = auth()->user();
            
          //dd($request);
            $this->validate($request, [
                'title' => 'required|max:255|unique:research,title',
                'type' => 'required', 
                'university_research_agenda' => 'required|max:255',
                'research_discipline_covered' => 'required|max:255',
                'budget' => 'required',
                'research_program_component' => 'required|max:255',
                'research_date_completed' => 'required|date',
                'fileInputCF' => 'required',
                'fileInputPCF' => 'required',
                'research_funding_agency' => 'required',
                'contract_from' => 'required',
                'contract_to' => 'required',
            ]);

            $CF = date('Y-m-h') . $request->fileInputCF->getClientOriginalName() . 'new';
            $request->fileInputCF->move(public_path('requirements'), $CF);
            
            $PCF = date('Y-m-h') . $request->fileInputPCF->getClientOriginalName() . 'new';
            $request->fileInputPCF->move(public_path('requirements'), $PCF);
            $year_completed =  date('Y',strtotime($request->research_date_completed));                                 
            $leadername = User::where('id',$request->leader)
                            ->first();
           
            $research->create([
                'user_id' => $user->id,
                'title' => $request->title,
                'type' => $request->type,
                'leader' => $leadername->fullname,
                'leader_id' => $request->leader,
                'status' => 'APPROVED',
                'deliverables' => 'Research Based Paper',
                'year_completed' => $year_completed,
                'date_completed' => $request->research_date_completed,
                'discipline_covered' => $request->research_discipline_covered,
                'program_component' => $request->research_program_component,
                'funding_agency' => $request->research_funding_agency,
                'contract_from' => $request->contract_from,
                'contract_to' => $request->contract_to,
                'budget' => $request->budget,
                'completed_file' =>$CF,
                'partner_contract_file' => $PCF,
                'university_research_agenda' => $request->university_research_agenda,
                'college' => $leadername->college,
                'location_from' => 'RMO',
                'location_to' => 'RMO',
                'station' => '4'
            ]);
            $latest = Research::latest()->first();
         //  dd($leadername->id);
          return redirect('/rmo/rbp/'.$latest->id.'/add-members/'.$leadername->id);
          //  return back()->with('alert', 'Faculty added successfully.');
            }
    
            public function viewResearchAddMembers($researchid,$leaderid) {
             
                $search = request()->query('search');
                $proposal = Research::where('id', $researchid)->first();
           
                $user = auth()->user();
                $proposalMember = ResearchMember::where('proposal_id', $proposal->id)->get();
                $added = ResearchMember::where('proposal_id', $proposal->id)->get();
               // dd($researchid);
                if($search) {
                    $faculties = User::where('fullname', 'LIKE', "%{$search}%")
                                        ->orWhere('email', 'LIKE', "%{$search}%")
                                        ->orWhere('employee_no', 'LIKE', "%{$search}%")
                                        ->where('type', ['Faculty'])
                                        ->where('id','<>',$leaderid)
                                        ->paginate(5);
                                        
                    $faculties->count();
                    
                    return view('rmo.rbp.add_member', [
                        'user' => $user,
                        'added' => $added,
                        'search' => $search,
                        'faculties' => $faculties,
                        'researchid' => $researchid,
                        'proposalMember' => $proposalMember,
                        'proposal' => $proposal,
                        'active' => "rmopending",
                        'leaderid' => $leaderid
                    ]);
                    dd($researchid);   
                } else {
        
                    $faculties = User::where('type', ['Faculty'])
                                        ->paginate(5);
                 
                    return view('rmo.rbp.add_member', [
                        'user' => $user,
                        'added' => $added,
                        'active' => "rmopending",
                        'search' => $search,
                        'faculties' => $faculties,
                        'proposal' => $proposal,
                        'researchid' => $researchid,
                        'proposalMember' => $proposalMember,
                        'leaderid' => $leaderid
                    ]);
                }
            }
        
            public function addMember( Research $proposal, ResearchMember $pm, User $faculty,Request $request,$leaderid) { 
            
               $leader = Research::where('leader_id', $leaderid)
                                    ->where('id', $proposal->id)
                                    ->first();
                $existing = ResearchMember::where('user_id', $faculty->id)
                                            ->where('proposal_id', $proposal->id)
                                            ->first();
                if($existing == true){
                    return back()->with('alert', ' This faculty is already added.');
                }
                if($leader == true){
                    return back()->with('alert', ' This faculty is the leader of the proposal.');
                }
            
                $pm->create([
                    'fullname' => $request->fullname,
                    'user_id' => $leaderid,
                    'proposal_id' => $proposal->id,
                    'employee_no' => $request->employee_no,
                    'email' => $request->email,
                    'college' => $request->college,
                ]);
                return back()->with('success', ' Member Added.');
            }
        
            public function deleteResearchMember($proposal, $member){
    
                ResearchMember::where('proposal_id', $proposal)
                                ->where('user_id', $member)->delete();
                return back()->with('delete', ' Member Removed');
            }
    
            public function uploadFile($id)     
            {
                $proposal = Research::where('id', $id)
                            ->first();
              //  dd($proposal);
                $user = auth()->user();
                $cfile = DB::table('research')->select('completed_file')
                            ->first();
                $pcfile = DB::table('research')->select('partner_contract_file')
                            ->first();
             //   dd($proposal);
               // dd($pcfile);
                return view('rmo.rbp.upload_file',[
                    'user' => $user,
                    'active' => "rmorbp",
                    'proposal' => $proposal
                ]);
            }
    
            public function storeFile( $id,Request $request,SucRequirements $req)
            {
            
            $this->validate($request, [
                'fileInputCF' => 'required',
                'fileInputPCF' => 'required',
                'suc_contract_name' => 'required',
                'contractfrom' => 'required',
                'contractto' => 'required',
            ]);  
            
            $CF = date('Y-m-h') . $request->fileInputCF->getClientOriginalName() . 'new';
            $request->fileInputCF->move(public_path('requirements'), $CF);
           
            $PCF = date('Y-m-h') . $request->fileInputPCF->getClientOriginalName() . 'new';
            $request->fileInputPCF->move(public_path('requirements'), $PCF);
    
               $req->create([
                'proposal_id' => $id,
                'suc_completed_file' => $CF,
                'suc_contract_file' => $PCF,
                'suc_contract_name' => $request->suc_contract_name,
                'suc_contract_from' => $request->contractfrom,
                'suc_contract_to' => $request->contractto
            ]);
            return redirect()->route('college-pending');
            }
    
            public function viewResearch($id)
            {
                $members = DB::table('research_members')->select('fullname')
                            ->where('proposal_id',$id)->get();
                $user = auth()->user();
                $paperpublisheds = PaperPublished::where('proposal_id', $id)
                                ->where('status','PENDING')->get();
                $bookciteds = BookCited::where('proposal_id',$id)
                                 ->where('status',['PENDING','APPROVED'])->get();
                $journalciteds = JournalCited::where('proposal_id',$id)
                                 ->where('status',['PENDING','APPROVED'])->get();
                $proposal = Research::where('id',$id)->first();
                $paperpresenteds = PaperPresented::where('proposal_id',$id)
                                 ->where('status','PENDING')->get();
                $utilizeds = Utilized::where('proposal_id',$id)
                                  ->where('status',['PENDING','APPROVED'])->get();
                $patenteds = Patented::where('proposal_id', $id)
                                 ->where('status',['PENDING','APPROVED'])->get();
                $req = SucRequirement::where('research_id',$id)->first();
              
                return view('rmo.rbp.view_rbp',[
                    'proposal' => $proposal,
                    'user' => $user,
                    'members' => $members,
                    'paperpublisheds' => $paperpublisheds,
                    'bookciteds' => $bookciteds,
                    'journalciteds' => $journalciteds,
                    'paperpresenteds' =>$paperpresenteds,
                    'utilizeds' => $utilizeds,
                    'patenteds' => $patenteds,
                    'req' => $req,
                    'active' => "rmorbp",
    
    
                ]);
                
            }
    
        ##################################### P E N D I N G T A B ############################################################ 
        public function pendingDashboard(){
            $user = auth()->user();
            $search = request()->query('search');
            if ($search) {
                $proposals = Research::where('title', 'LIKE', '%' . ($search) . '%')
                                        ->where(['status' => 'PENDING'])
                                        ->where(['location_from' => 'Chancellor'])
                                        ->where(['location_to' => 'RMO'])
                                        ->orderBy('created_at', 'desc')
                                        ->paginate(5);
            }
            else {
            $proposals = Research::where(['status' => 'PENDING'])
                                 ->where(['location_from' => 'Chancellor'])
                                 ->where(['location_to' => 'RMO'])
                                 ->orderBy('created_at', 'desc')       
                                 ->paginate(5);
            }
            return view('rmo.pending_dashboard', [
                'user' => $user,
                'proposals' => $proposals,
                'active' => "rmopending",
                'search' => $search
            ]);
           } 
        public function editResearch(Research $proposals, $id){
            $deliverables = DB::table('deliverables')->select('name')
                            ->get();
            $faculties = User::get();
            $research_discipline_covered = DB::table('discipline_covereds')->select('name')
                                            ->get(); 
            $user= auth()->user();
            $status = array('RMO','Program Chair','Dean','Chancellor');
          //  dd($status);
            $data = Research::where('id', $id)->first();
            $members = ResearchMember::where('proposal_id', $id)->get();
            $paperpublisheds = PaperPublished::where('proposal_id', $id)
                    ->whereIn('status',['RMO','Program Chair', 'Dean', 'Chancellor'])->get();
            $bookciteds = BookCited::where('proposal_id',$id)
            ->whereIn('status',['RMO','Program Chair', 'Dean', 'Chancellor'])->get();
            $journalciteds = JournalCited::where('proposal_id',$id)
            ->whereIn('status',['RMO','Program Chair', 'Dean', 'Chancellor'])->get();
            $paperpresenteds = PaperPresented::where('proposal_id',$id)
            ->whereIn('status',['RMO','Program Chair', 'Dean', 'Chancellor'])->get();
            $utilizeds = Utilized::where('proposal_id',$id)
            ->whereIn('status',['RMO','Program Chair', 'Dean', 'Chancellor'])->get();
            $patenteds = Patented::where('proposal_id', $id)
            ->whereIn('status',['RMO','Program Chair', 'Dean', 'Chancellor'])->get();
            $reqs = SucRequirement::where('research_id',$id)->first();
            //dd($data);
            return view('rmo.rbp.edit', [
                'data' => $data,
                'deliverables' => $deliverables,
                'research_discipline_covered' => $research_discipline_covered,
                'members' => $members,
                'active' => "rmopending",
                'user' => $user,
                'reqs' => $reqs,
                'faculties' => $faculties,
                'paperpublisheds' => $paperpublisheds,
                'paperpresenteds' => $paperpresenteds,
                'bookciteds' => $bookciteds,
                'journalciteds' => $journalciteds,
                'utilizeds' => $utilizeds,
                'patenteds' => $patenteds,
            ]);
        }
    
        public function updateResearch(Request $request, $id){
      
            $leaderId = DB::table('users')->select('id')
                        ->where(['fullname' => $request->proposal_leader_name])
                        ->first();
            $sucreqs = SucRequirement::where('research_id',$id)->first();
            
           $proposal = Research::where('id', $id)->first();
                  $proposal->update([
                        'title' => $request->proposal_title,
                        'type' => $request->type,
                        'contract_from' => $request->contract_from,
                        'contract_to' => $request->contract_to,
                'date_completed' => $request->research_date_completed,
                'discipline_covered' => $request->research_discipline_covered,
                'program_component' => $request->research_program_component,
                'funding_agency' => $request->research_funding_agency,
                'budget' => $request->budget,
                'university_research_agenda' => $request->university_research_agenda,
                'status' => 'APPROVED',
                'funded_on' => $request->funded_on,
                'budget_bsu' => $request->budget_bsu,
                'location_from' => 'RMO',
                'location_to' => 'RMO'

            ]); 
            if($request->fileInputCF) {
                $prevCF = $proposal->completed_file;
                $path = 'requirements/'.$prevCF;
                $path = public_path($path);
                File::delete($path);
                $newCF = date('Y-m-h') . $request->fileInputCF->getClientOriginalName() . 'new';
                $request->fileInputCF->move(public_path('requirements'), $newCF);
                
                $proposal->update([
                    'completed_file' => $newCF,
                ]);
    
        }
            if($request->fileInputPCF) {
                $prevPCF = $proposal->partner_contract_file;
                $path = 'requirements/'.$prevPCF;
                $path = public_path($path);
                File::delete($path);
                $newPCF = date('Y-m-h') . $request->fileInputPCF->getClientOriginalName() . 'new';
                $request->fileInputPCF->move(public_path('requirements'), $newPCF);
                $proposal->update([
                    'partner_contract_file' => $newPCF,
                ]);
            }
    
            return redirect()->route('rmo-rbp')->with('success', ' Proposal successfully updated.');
        }
    
    
        ############################ F O R R E V I S I O N ############################
        public function revisionDashboard(){
            $user = auth()->user();
            $search = request()->query('search');
            if ($search) {
                $proposals = Research::where('title', 'LIKE', '%' . ($search) . '%')
                                        ->where(['status' => 'RMO'])
                                        ->orderBy('created_at', 'desc')
                                        ->paginate(5);
            }
            else {
            $proposals = Research::where(['status' => 'RMO'])
                                 ->orderBy('created_at', 'desc')       
                                 ->paginate(5);
            }
            return view('rmo.revision_dashboard', [
                'user' => $user,
                'proposals' => $proposals,
                'active' => "rmorevision",
                'search' => $search
            ]);
           } 
           public function deleteRBP($id){
            $proposal = Research::where('id', $id)->first();
            $proposal->update([
                'status' => 'I',
             
            ]);
    
            return back()->with('alert', 'Research Information has been deleted');
        }
    
           ###########################P A P E R P U B L I S H E D######################################
           public function createPaperPublished($id){
            $user = auth()->user();
    
            
            return view('faculty.rbp.paperpublished.create', [
                'user' => $user,
                'active' => "rmopending",
                'id' => $id,    
          
            ]);
        }
    
        public function storePaperPublished(Request $request, $id, PaperPublished $pub){
         
            $user = auth()->user();
            $proposal = Research::where('id',$id)->first();
            
            $this->validate($request, [
                'journal_title' => 'required|max:255',
                'publication' => 'required|max:255',
                'publication_title' => 'required|max:255',
                'publisher' => 'required|max:255',
            //    'is_internally_funded' => 'required|max:255',
                'vol_no' => 'required|max:255',
                'pages' => 'required',
                'year_accepted' => 'required|date',
                'year_published' => 'required|date',
            ]);
           
            $newJTP = date('Y-m-h') . $request->fileInputJTP->getClientOriginalName() . 'new';
                $request->fileInputJTP->move(public_path('requirements'), $newJTP);
            $newTOC = date('Y-m-h') . $request->fileInputTOC->getClientOriginalName() . 'new';
                $request->fileInputTOC->move(public_path('requirements'), $newTOC);
            $newAP = date('Y-m-h') . $request->fileInputAP->getClientOriginalName() . 'new';
                $request->fileInputAP->move(public_path('requirements'), $newAP);
           $status = "APPROVED";
            // dd($leaderId->fullname);
            $pub->create([
                'proposal_id' => $id,
                'journal_title' => $request->journal_title,
                'publication' => $request->publication,
                'publication_title' => $request->publication_title,
                'publisher' => $request->publisher,
                'vol_no' => $request->vol_no,
                'pages' => $request->pages,
                'status' => $status,
                'file_1' => $newJTP,
                'file_2' => $newTOC,
                'file_3' => $newAP,
                'year_accepted' => $request->year_accepted,
                'year_published' => $request->year_published,
                
            ]);
         
            $p = "1";
            $year = date('Y', strtotime($request->year_published)); 
            $proposal->update([
                'is_published' => $p,
           
                'year_published' => $year
            ]);
            return redirect()->route('rmo-rbp-view',$id)->with('success', 'Paper Published Information has been added.');
            }
    
            public function viewPaperPublished($id)
            {
                
                $user = auth()->user();
                
                $paperpublisheds = PaperPublished::where('id',$id)->first();
               
                
                return view('rmo.rbp.paperpublished.view',[
                    'user' => $user,
                    'active' => "rmopending",
                    'paperpublisheds' => $paperpublisheds,
                ]);
                
            }
            public function editPaperPublished($proposalid,$id){
                $user= auth()->user();
                $data = PaperPublished::where('id', $id)->first();
                //dd($data);      
                return view('rmo.rbp.paperpublished.edit', [
                    'data' => $data,
                    'user' => $user,
                    'active' => "rmorbp",
                    'proposalid' => $proposalid
                ]);
            }
    
            public function updatePaperPublished(Request $request,$proposalid, $id){
                 
                $files = PaperPublished::where('id',$id)->first();  
                $proposal = Research::where('id',$proposalid)->first();
                $year = date('Y', strtotime($request->year_published)); 
                if($files){
                    if($request->fileInputA) {
                        $prevA = $files->file_1;
                        $path = 'requirements/'.$prevA;
                        $path = public_path($path);
                        File::delete($path);
                        $abs = date('Y-m-h') . $request->fileInputA->getClientOriginalName() . ' ' . '(new)';
                        $request->fileInputA->move(public_path('requirements'), $abs);
                        $files->update([
                            'file_1' => $abs,
                        ]);
                    }
                    if($request->fileInputCOP) {
                        $prevCOP = $files->file_2;
                        $path = 'requirements/'.$prevCOP;
                        $path = public_path($path);
                        File::delete($path);
                        $att = date('Y-m-h') . $request->fileInputCOP->getClientOriginalName() . ' ' . '(new)';
                        $request->fileInputCOP->move(public_path('requirements'), $att);
                        $files->update([
                            'file_2' => $att,
                        ]);
                    }
                    if($request->fileInputCP) {
                        $prevCP = $files->file_3;
                        $path = 'requirements/'.$prevCP;
                        $path = public_path($path);
                        File::delete($path);
                        $con = date('Y-m-h') . $request->fileInputCP->getClientOriginalName() . ' ' . '(new)';
                        $request->fileInputCP->move(public_path('requirements'), $con);
                        $files->update([
                            'file_3' => $con,
                        ]);
                    }
                    $files->update([
                        'journal_title' => $request->journal_title,
                        'publication' => $request->publication,
                        'publication_title' => $request->publication_title,
                        'publisher' => $request->publisher,
                        'year_accepted' => $request->year_accepted,
                        'year_published' => $request->year_published,
                        'status' => 'APPROVED',
                        'vol_no' => $request->vol_no,
                        'pages' => $request->pages,
            ]);
       
            $proposal->update([
                'is_published' => '1',
                
                'year_published' => $year
             
            ]);
            return redirect()->route('rmo-rbp-edit',$proposalid)->with('success', 'Paper Published Successfully Updated.');
            //return redirect()->route('faculty-rbp-view',$id)->with('success', 'Journal Cited Successfully Updated.');
           }
    
           else
            {
                $abs = date('Y-m-h') . $request->fileInputA->getClientOriginalName() . 'new';
                $request->fileInputA->move(public_path('requirements'), $abs);
                
                $att = date('Y-m-h') . $request->fileInputCOP->getClientOriginalName() . 'new';
                $request->fileInputCOP->move(public_path('requirements'), $att);
                $con = date('Y-m-h') . $request->fileInputCP->getClientOriginalName() . 'new';
                $request->fileInputCP->move(public_path('requirements'), $con);
                
                $files->update([
                            'journal_title' => $request->journal_title,
                            'publication' => $request->publication,
                            'publication_title' => $request->publication_title,
                            'publisher' => $request->publisher,
                            'year_accepted' => $request->year_accepted,
                            'year_published' => $request->year_published,
                            'status' => 'APPROVED',
                            'vol_no' => $request->vol_no,
                            'pages' => $request->pages,
                ]);  
                
                $proposal->update([
                    'is_published' => $p,
                  
                    'year_published' => $year
                ]);
                return redirect()->route('rmo-rbp-view',$proposalid)->with('success', 'Paper Published Successfully Updated.');
             //   return redirect()->route('faculty-rbp-view',$id)->with('success', 'Journal Cited Successfully Updated.');
            }
        }
        public function deletePublished($id){
            $pending = PaperPublished::find($id);
            $pending->delete();
    
            return back()->with('alert', 'Paper Published Information has been deleted');
        }
        
        
    
            ########################P A P E R P R E S E N T E D###################################
        public function createPaperPresented($id){
            $user = auth()->user();
               
            return view('rmo.rbp.paperpresented.create', [
                'user' => $user,
                'active' => "rmopending",
                'id' => $id,    
            ]);
        }
    
        public function storePaperPresented(Request $request, $id, PaperPresented $pre){
         
            $user = auth()->user();
            $proposal = Research::where('id',$id)->first();
            
            $this->validate($request, [
                'paper_title' => 'required|max:255',
                'paper_title_2' => 'required|max:255',
                'presenters' => 'required|max:255',
                'venue' => 'required|max:255',
            //    'is_internally_funded' => 'required|max:255',
                'organizer' => 'required|max:255',
                'conference_type' => 'required',
                'date' => 'required|date',
                
            ]);
           
            $newA = date('Y-m-h') . $request->fileInputA->getClientOriginalName() . 'new';
                $request->fileInputA->move(public_path('requirements'), $newA);
            $newCOP = date('Y-m-h') .$request->fileInputCOP->getClientOriginalName() . 'new';
                $request->fileInputCOP->move(public_path('requirements'), $newCOP);
            $newCP = date('Y-m-h') . $request->fileInputCP->getClientOriginalName() . 'new';
                $request->fileInputCP->move(public_path('requirements'), $newCP);
           $status = "APPROVED";
            // dd($leaderId->fullname);
            $pre->create([
                'proposal_id' => $id,
                'paper_title' => $request->paper_title,
                'paper_title_2' => $request->paper_title_2,
                'presenters' => $request->presenters,
                'venue' => $request->venue,
                'organizer' => $request->organizer,
                'conference_type' => $request->conference_type,
                'date' =>$request->date,
                'status' => $status,
                'file_1' => $newA,
                'file_2' => $newCOP,
                'file_3' => $newCP,
            
                
            ]);
            $p = "1";
            $year = date('Y', strtotime($request->year_presented)); 
            $proposal->update([
                'is_presented' => $p,
                'year_presented ' => 'year'
            ]);
            return redirect()->route('rmo-rbp-view',$id)->with('success', 'Paper Presented Information has been added.');
            }
    
            public function viewPaperPresented($id)
            {
                
                $user = auth()->user();
                
                $paperpresenteds = PaperPresented::where('id',$id)->first();

                return view('rmo.rbp.paperpresented.view',[
                    'user' => $user,
                    'active' => "rmopending",
                    'paperpresenteds' => $paperpresenteds,
                ]);
                
            }
    
            public function editPaperPresented($proposalid,$id){
                $user= auth()->user();
                $data = PaperPresented::where('id', $id)->first();
                //dd($data);      
                return view('rmo.rbp.paperpresented.edit', [
                    'data' => $data,
                    'active' => "rmopending",
                    'user' => $user,
                    'proposalid' => $proposalid
                ]);
            }
    
            public function updatePaperPresented(Request $request,$proposalid, $id){
                
                $proposal = Research::where('id',$proposalid)->first();
                $files = PaperPresented::where('id',$id)->first();  
                $year = date('Y', strtotime($request->year_presented)); 
                if($files){
                    if($request->fileInputA) {
                        $prevA = $files->file_1;
                        $path = 'requirements/'.$prevA;
                        $path = public_path($path);
                        File::delete($path);
                        $abs = date('Y-m-h') . $request->fileInputA->getClientOriginalName() . ' ' . '(new)';
                        $request->fileInputA->move(public_path('requirements'), $abs);
                        $files->update([
                            'file_1' => $abs,
                        ]);
                    }
                    if($request->fileInputCOP) {
                        $prevCOP = $files->file_2;
                        $path = 'requirements/'.$prevCOP;
                        $path = public_path($path);
                        File::delete($path);
                        $att = date('Y-m-h') . $request->fileInputCOP->getClientOriginalName() . ' ' . '(new)';
                        $request->fileInputCOP->move(public_path('requirements'), $att);
                        $files->update([
                            'file_2' => $att,
                        ]);
                    }
                    if($request->fileInputCP) {
                        $prevCP = $files->file_3;
                        $path = 'requirements/'.$prevCP;
                        $path = public_path($path);
                        File::delete($path);
                        $con = date('Y-m-h') . $request->fileInputCP->getClientOriginalName() . ' ' . '(new)';
                        $request->fileInputCP->move(public_path('requirements'), $con);
                        $files->update([
                            'file_3' => $con,
                        ]);
                    }
                    $files->update([
                        'paper_title' => $request->paper_title,
                        'paper_title_2' => $request->paper_title_2,
                        'presenters' => $request->presenters,
                        'venue' => $request->venue,
                        'date' => $request->date,
                        'status' => 'APPROVED',
                        'organizer' => $request->organizer,
            ]);
           
            $proposal->update([
                'is_presented' => '1',
                'year_presented' => $year
              
            ]);
            return redirect()->route('rmo-rbp-edit',$proposalid)->with('success', 'Paper Presented Successfully Updated.');
            //return redirect()->route('faculty-rbp-view',$id)->with('success', 'Journal Cited Successfully Updated.');
           }
    
           else
            {
                $abs = date('Y-m-h') . $request->fileInputA->getClientOriginalName() . 'new';
                $request->fileInputA->move(public_path('requirements'), $abs);
                
                $att = date('Y-m-h') . $request->fileInputCOP->getClientOriginalName() . 'new';
                $request->fileInputCOP->move(public_path('requirements'), $att);
                $con = date('Y-m-h') . $request->fileInputCP->getClientOriginalName() . 'new';
                $request->fileInputCP->move(public_path('requirements'), $con);
                
                $files->update([
                            'paper_title' => $request->paper_title,
                            'paper_title_2' => $request->paper_title_2,
                            'presenters' => $request->presenters,
                            'venue' => $request->venue,
                            'date' => $request->date,
                            'status' => 'APPROVED',
                            'organizer' => $request->organizer,
                ]);  
                $proposal->update([
                    'is_presented' => '1',
                    'year_presented' => $year
                  
                ]);
                return redirect()->route('rmo-rbp-edit',$proposalid)->with('success', 'Paper Presented Successfully Updated.'); 
             //   return redirect()->route('faculty-rbp-view',$id)->with('success', 'Journal Cited Successfully Updated.');
            }
        }
    
        public function deletePresented($id){
            $pending = PaperPresented::find($id);
            $pending->delete();
    
            return back()->with('alert', 'Paper Presented Informations has been deleted');
        }
    
    
        ########################J O U R N A L C I T E D###################################
        public function createJournalCited($id){
            $user = auth()->user();
               
            return view('rmo.rbp.journalcited.create', [
                'user' => $user,
                'active' => "rmopending",
                'id' => $id,    
            ]);
        }
    
        public function storeJournalCited(Request $request, $id, JournalCited $jour){
         
            $user = auth()->user();
            $proposal = Research::where('id',$id)->first();
            $year = date('Y', strtotime($request->year_published)); 
        
            $this->validate($request, [
                'journal_title' => 'required|max:255',
                'publication' => 'required|max:255',
                'publisher' => 'required|max:255',
                'authors' => 'required|max:255',
                'link' => 'required|max:255',
                'vol_no' => 'required',
                'pages' => 'required',
                'year_published' => 'required|date',
                
            ]);
    
           $status = "APPROVED";
            // dd($leaderId->fullname);
            $jour->create([
                'proposal_id' => $id,
                'journal_title' => $request->journal_title,
                'publication' => $request->publication,
                'publisher' => $request->publisher,
                'authors' => $request->authors,
                'link' => $request->link,
                'vol_no' => $request->vol_no,
                'pages' =>$request->pages,
                'status' => $status,
                'year_published' => $request->year_published,
    
            
                
            ]);
            $p = "1";
            $proposal->update([
                'is_journal_cited' => $p,
                'year_journal_cited' => $year
            ]);
            return redirect()->route('rmo-rbp-view',$id)->with('success', 'Journal Cited Information has been added.');
            }
    
            public function viewJournalCited($id)
            {
                
                $user = auth()->user();
                
                $journalciteds = JournalCited::where('id',$id)->first();
               
                
                return view('rmo.rbp.journalcited.view',[
                    'user' => $user,
                    'active' => "rmopending",
                    'journalciteds' => $journalciteds,
                ]);
                
            }
    
            public function editJournalCited($proposalid,$id){
                $user= auth()->user();
                $data = JournalCited::where('id', $id)->first();
                //dd($data);      
                return view('rmo.rbp.journalcited.edit', [
                    'data' => $data,
                    'user' => $user,
                    'active' => "rmopending",
                    'proposalid' => $proposalid
                ]);
            }
    
            public function updateJournalCited(Request $request, $proposalid,$id){
                 
                JournalCited::where('id', $id)
                        ->update([
                            'journal_title' => $request->journal_title,
                            'publisher' => $request->publisher,
                            'authors' => $request->authors,
                            'year_published' => $request->year_published,
                            'publication' => $request->publication,
                            'status' => 'APPROVED',
                            'link' => $request->link,
                            'vol_no' => $request->vol_no,
                            'pages' => $request->pages,
                ]);  
                $proposal = Research::where('id',$id)->first();
                $year = date('Y', strtotime($request->year_published)); 
                $p = "1";
                $proposal->update([
                    'is_journal_cited' => $p,
                    'year_journal_cited' => $year
                
                ]);
                return redirect()->route('rmo-rbp-edit',$proposalid)->with('success', 'Journal Cited Successfully Updated.');
            }
    
            public function deleteJournalCited($id){
                $pending = JournalCited::find($id);
                $pending->delete();
        
                return back()->with('alert', 'Journal Cited Informations has been deleted');
            }
    
                 ########################B O O K C I T E D###################################
        public function createBookCited($id){
            $user = auth()->user();
               
            return view('rmo.rbp.bookcited.create', [
                'user' => $user,
                'active' => "rmopending",
                'id' => $id,    
            ]);
        }
    
        public function storeBookCited(Request $request, $id, BookCited $book){
         
            $user = auth()->user();
            $proposal = Research::where('id',$id)->first();
            $year = date('Y', strtotime($request->year_published)); 
            $this->validate($request, [
                'book_title' => 'required|max:255',
                'isbn' => 'required|max:255',
                'publisher' => 'required|max:255',
                'authors' => 'required|max:255',
            //    'is_internally_funded' => 'required|max:255',
                'link' => 'required|max:255',
                'vol_no' => 'required',
                'pages' => 'required',
                'year_published' => 'required|date',
                
            ]);
    
           $status = "APPROVED";
            // dd($leaderId->fullname);
            $book->create([
                'proposal_id' => $id,
                'book_title' => $request->book_title,
                'isbn' => $request->isbn,
                'publisher' => $request->publisher,
                'authors' => $request->authors,
                'link' => $request->link,
                'vol_no' => $request->vol_no,
                'year_published' =>$request->year_published,
                'status' => $status,
                'pages' => $request->pages,
                
            ]);
            $p = "1";
            $proposal->update([
                'is_book_cited' => $p,
                'year_book_cited' => $year
            ]);
            return redirect()->route('rmo-rbp-view',$id)->with('success', 'Book Cited Information has been added.');
            }
    
            public function viewBookCited($id)
            {
                
                $user = auth()->user();
                
                $bookciteds = BookCited::where('id',$id)->first();
               
                
                return view('faculty.rmo.bookcited.view',[
                    'user' => $user,
                    'active' => "rmorbp",
                    'bookciteds' => $bookciteds,
                ]);
                
            }
    
            public function editBookCited($proposalid,$id){
                $user= auth()->user();
                $data = BookCited::where('id', $id)->first();
                //dd($data);      
                return view('rmo.rbp.bookcited.edit', [
                    'data' => $data,
                    'user' => $user,
                    'active' => "rmopending",
                    'proposalid' => $proposalid
                ]);
            }
    
            public function updateBookCited(Request $request,$proposalid, $id){
                 
                BookCited::where('id', $id)
                        ->update([
                            'book_title' => $request->book_title,
                            'publisher' => $request->publisher,
                            'authors' => $request->authors,
                            'year_published' => $request->year_published,
                            'isbn' => $request->isbn,
                            'status' => 'APPROVED',
                            'vol_no' => $request->vol_no,
                            'pages' => $request->pages,
                            'link' => $request->link
                ]);  
                $year = date('Y', strtotime($request->year_published)); 
                $proposal = Research::where('id',$id)->first();
                $p = "1";
                $proposal->update([
                    'is_journal_cited' => $p,
                    'year_journal_cited' => $year
                  
                ]);
    
                return redirect()->route('rmo-rbp-edit',$proposalid)->with('success', 'Book Cited Successfully Updated.');
            }
    
            public function deleteBookCited($id){
                $pending = BookCited::find($id);
                $pending->delete();
        
                return back()->with('alert', 'Book Cited Informations has been deleted');
            }
    
            ######################################### I N V E N T I O N T A B ###############################################
        public function inventionDashboard(){
            $user = auth()->user();
            $search = request()->query('search');
            if ($search) {
                $proposals = Research::where('title', 'LIKE', '%' . ($search) . '%')
                                        ->where(['deliverables' => 'Invention'])
                                        ->orWhere('date_completed', 'LIKE', "%{$search}%")
                                        ->orderBy('created_at', 'desc')
                                        ->paginate(5);
            }
            else {
            $proposals = Research::where(['deliverables' => 'Invention'])
                                 ->orderBy('created_at', 'desc')       
                                 ->paginate(5);
            }
            return view('rmo.invention.invention_dashboard', [
                'user' => $user,
                'proposals' => $proposals,
                'search' => $search,
                'active' => "rmoinvention",
            ]);
        }
    
        public function createInvention(){
            $user = auth()->user();
           
            $research_discipline_covered = DB::table('discipline_covereds')->select('name')
                                            ->get();
            return view('rmo.invention.create', [
                'user' => $user,
                'active' => "rmoinvention",
                'research_discipline_covered' => $research_discipline_covered
            ]);
        }
    
        public function storeInvention(Request $request, Research $research){
           
            $user = auth()->user();
            
          //dd($request);
            $this->validate($request, [
                'title' => 'required|max:255|unique:research,title',
                'research_discipline_covered' => 'required|max:255',
                'budget' => 'required',
                'research_program_component' => 'required|max:255',
                'research_date_completed' => 'required|date',
                'fileInputCF' => 'required',
                'fileInputPCF' => 'required',
                'research_funding_agency' => 'required',
            ]);
    
            $status = 'APPROVED';
            $location = 'College';
            $CF = date('Y-m-h') . $request->fileInputCF->getClientOriginalName() . 'new';
            $request->fileInputCF->move(public_path('requirements'), $CF);
            
            $PCF = date('Y-m-h') . $request->fileInputPCF->getClientOriginalName() . 'new';
            $request->fileInputPCF->move(public_path('requirements'), $PCF);
                                              
          
            $research->create([
                'user_id' => $user->id,
                'title' => $request->title,
                'leader' => $user->fullname,
                'leader_id' => $user->id,
                'status' => $status,
                'deliverables' => 'Invention',
                'date_completed' => $request->research_date_completed,
                'discipline_covered' => $request->research_discipline_covered,
                'program_component' => $request->research_program_component,
                'funding_agency' => $request->research_funding_agency,
                'budget' => $request->budget,
                'completed_file' =>$CF,
                'partner_contract_file' => $PCF,
                'college' => 'N/A',
                'location_to' => 'RMO'
            ]);
            $latest = Research::latest()->first();
           
          return redirect()->route('rmo-invention-addmembers',$latest->id);
          //  return back()->with('alert', 'Faculty added successfully.');
            }
    
            public function viewInventionAddMembers($researchid) {
              
                $search = request()->query('search');
                $proposal = Research::where('id', $researchid)->first();
           
                $user = auth()->user();
                $proposalMember = ResearchMember::where('proposal_id', $proposal->id)->get();
                $added = ResearchMember::where('proposal_id', $proposal->id)->get();
        
                
                if($search) {
                    $faculties = User::where('fullname', 'LIKE', "%{$search}%")
                                        ->orWhere('email', 'LIKE', "%{$search}%")
                                        ->orWhere('employee_no', 'LIKE', "%{$search}%")
                                        ->where('type', ['Faculty'])
                                        ->paginate(5);
                    $faculties->count();
                    return view('rmo.rbp.add_member', [
                        'user' => $user,
                        'added' => $added,
                        'search' => $search,
                        'faculties' => $faculties,
                        'researchid' => $researchid,
                        'proposalMember' => $proposalMember,
                        'proposal' => $proposal,
                        'active' => 'rmoinvention'
                    ]);
        
                } else {
        
                    $faculties = User::where('type', ['Faculty'])
                                        ->paginate(5);
                 
                    return view('faculty.invention.add_member', [
                        'user' => $user,
                        'added' => $added,
                        'active' => "rmoinvention",
                        'search' => $search,
                        'faculties' => $faculties,
                        'proposal' => $proposal,
                        'researchid' => $researchid,
                        'proposalMember' => $proposalMember,
                    ]);
                }
            }
        
            public function addMemberInvention( Research $proposal, ResearchMember $pm, User $faculty,Request $request) { 
              
               $leader = Research::where('leader_id', $faculty->id)
                                    ->where('id', $proposal->id)
                                    ->first();
                $existing = ResearchMember::where('user_id', $faculty->id)
                                            ->where('proposal_id', $proposal->id)
                                            ->first();
                if($existing == true){
                    return back()->with('alert', ' This faculty is already added.');
                }
                if($leader == true){
                    return back()->with('alert', ' This faculty is the leader of the proposal.');
                }
               
                $pm->create([
                    'fullname' => $request->fullname,
                    'user_id' => $faculty->id,
                    'proposal_id' => $proposal->id,
                    'employee_no' => $request->employee_no,
                    'email' => $request->email,
                    'college' => $faculty->college,
                ]);
                return back()->with('success', ' Member Added.');
            }
        
            public function deleteInventionMember($proposal, $member){
    
                ResearchMember::where('proposal_id', $proposal)
                                ->where('user_id', $member)->delete();
                return back()->with('delete', ' Member Removed');
            }
    
          
            public function viewInvention($id)
            {
            $members = DB::table('research_members')->select('fullname')
                        ->where('proposal_id',$id)->get();
            $user = auth()->user();
            $paperpublisheds = PaperPublished::where('proposal_id', $id)
                        ->where('status','<>','REJECTED')->get();
            $bookciteds = BookCited::where('proposal_id',$id)
                        ->where('status','<>','REJECTED')->get();
            $journalciteds = JournalCited::where('proposal_id',$id)
                        ->where('status','<>','REJECTED')->get();
            $proposal = Research::where('id',$id)->first();
            $paperpresenteds = PaperPresented::where('proposal_id',$id)
                        ->where('status','<>','REJECTED')->get();
            $utilizeds = Utilized::where('proposal_id',$id)
                        ->where('status','<>','REJECTED')->get();
            $patenteds = Patented::where('proposal_id', $id)
                        ->where('status','<>','REJECTED')->get();
            $req = SucRequirement::where('research_id',$id)->first();
    
            return view('rmo.invention.view_invention',[
                'proposal' => $proposal,
                'user' => $user,
                'members' => $members,
                'paperpublisheds' => $paperpublisheds,
                'bookciteds' => $bookciteds,
                'journalciteds' => $journalciteds,
                'paperpresenteds' =>$paperpresenteds,
                'utilizeds' => $utilizeds,
                'patenteds' => $patenteds,
                'req' => $req,
                'active' => "rmoinvention",
    
    
    ]);
    
            }
    
                        ########################P A T E N T E D###################################
        
            public function createPatented($id){
                $user = auth()->user();
                    
                return view('rmo.invention.patented.create', [
                    'user' => $user,
                    'active' => "rmoinvention",
                    'id' => $id,    
                ]);
            }
            public function storePatented(Request $request, $id, Patented $pat){
         
            $user = auth()->user();
            $proposal = Research::where('id',$id)->first();
            
            $this->validate($request, [
                'patent_no' => 'required|max:255',
                'date_issue' => 'required|date',
                'utilization' => 'required|max:255',
                'product_name' => 'required|max:255',
        
                
            ]);
    
           $status = "APPROVED";
            // dd($leaderId->fullname);
            $pat->create([
                'proposal_id' => $id,
                'patent_no' => $request->patent_no,
                'date_issue' => $request->date_issue,
                'utilization' => $request->utilization,
                'product_name' => $request->product_name,
                'status' => $status,
                
            ]);
            $p = "1";
            $proposal->update([
                'is_patented' => $p,
            ]);
          
            return redirect()->route('rmo-invention-view',$id)->with('success', 'Patented Information Successfully Added.');
            }
    
            public function viewPatented($id)
            {
                
                $user = auth()->user();
                
                $patenteds = Patented::where('id',$id)->first();
               
                
                return view('rmo.invention.patented.view',[
                    'user' => $user,
                    'active' => "rmoinvention",
                    'patenteds' => $patenteds,
                ]);
                
            }
    
            public function updatePatented(Request $request, $id){
                Patented::where('id', $id)
                    ->update([
                        'patent_no' => $request->patent_no,
                        'date_issue' => $request->date_issue,
                        'utilization' => $request->utilization,
                        'product_name' => $request->product_name
                    ]);
                    return back()->with('updated', 'Patented Information successfully updated.');
    
            }
    
            public function deletePatented($id){
                $pending = Patented::find($id);
                $pending->delete();
        
                return back()->with('alert', 'Book Cited Informations has been deleted');
            }
    
                            ########################U T I L I Z E D##################################
        
        public function storeUtilized(Request $request, $id, Utilized $uti){
    
            $user = auth()->user();
            $proposal = Research::where('id',$id)->first();
            
            $photo = date('Y-m-h') . $request->file_1->getClientOriginalName() . 'new';
            $request->file_1->move(public_path('requirements'), $photo);
             $moa = date('Y-m-h') . $request->file_2->getClientOriginalName() . 'new';
            $request->file_2->move(public_path('requirements'), $moa);
             $permit = date('Y-m-h') . $request->file_3->getClientOriginalName() . 'new';
                  $request->file_3->move(public_path('requirements'), $permit);   
    
           $status = "APPROVED";
            // dd($leaderId->fullname);
            $uti->create([
                'proposal_id' => $id,
                'file_1' => $photo,
                'file_2' => $moa,
                'file_3' => $permit,
                'status' => $status,
                
            ]);
            $p = "1";
            $proposal->update([
                'is_utilized' => $p,
            ]);
            return back()->with('success','Utilized Information Added.');
            }
    
            public function viewUtilized($id)
            {
                
                $user = auth()->user();
                
                $utilizeds = Utilized::where('id',$id)->first();
               
                
                return view('rmo.invention.utilized.view',[
                    'user' => $user,
                    'active' => "rmoinvention",
                    'utilizeds' => $utilizeds,
                ]);
                
            }
    
            public function updateUtilized(Request $request, $id){
                // dd($id);
                $files = Utilized::where('id',$id)->first();  
                if($files){
                    if($request->fileInputPhoto) {
                        $prevA = $files->file_1;
                        $path = 'requirements/'.$prevA;
                        $path = public_path($path);
                        File::delete($path);
                        $photo = date('Y-m-h') . $request->fileInputPhoto->getClientOriginalName() . ' ' . '(new)';
                        $request->fileInputPhoto->move(public_path('requirements'), $photo);
                        $files->update([
                            'file_1' => $photo,
                        ]);
                    }
                    if($request->fileInputMoa) {
                        $prevCOP = $files->file_2;
                        $path = 'requirements/'.$prevCOP;
                        $path = public_path($path);
                        File::delete($path);
                        $moa = date('Y-m-h') . $request->fileInputMoa->getClientOriginalName() . ' ' . '(new)';
                        $request->fileInputMoa->move(public_path('requirements'), $moa);
                        $files->update([
                            'file_2' => $moa,
                        ]);
                    }
                    if($request->fileInputBP) {
                        $prevCP = $files->file_3;
                        $path = 'requirements/'.$prevCP;
                        $path = public_path($path);
                        File::delete($path);
                        $bus = date('Y-m-h') . $request->fileInputBP->getClientOriginalName() . ' ' . '(new)';
                        $request->fileInputBP->move(public_path('requirements'), $bus);
                        $files->update([
                            'file_3' => $bus,
                        ]);
                    }
              //   dd($request);   
            return  back()->with('success','Utilzed Information Successfully Updated.');  
            //return redirect()->route('faculty-rbp-view',$id)->with('success', 'Journal Cited Successfully Updated.');
           }
    
           else
            {
                $photo = date('Y-m-h') . $request->fileInputPhoto->getClientOriginalName() . 'new';
                $request->fileInputPhoto->move(public_path('requirements'), $photo);
               
                $moa = date('Y-m-h') . $request->fileInputMoa->getClientOriginalName() . 'new';
                $request->fileInputMoa->move(public_path('requirements'), $moa);
                $bus = date('Y-m-h') . $request->fileInputBP->getClientOriginalName() . 'new';
                $request->fileInputBP->move(public_path('requirements'), $bus);
                
             //   dd($bus); 
                return  back()->with('success','Utilized Information Successfully Updated.');  
             //   return redirect()->route('faculty-rbp-view',$id)->with('success', 'Journal Cited Successfully Updated.');
            }
        }
        public function deleteUtilized($id){
            $pending = Utilized::find($id);
            $pending->delete();
    
            return back()->with('success', 'Utilized Informations has been deleted');
        }




        public function viewRevision($id)
        {
            $members = DB::table('research_members')->select('fullname')
                        ->where('proposal_id',$id)->get();
            $user = auth()->user();
            $paperpublisheds = PaperPublished::where('proposal_id', $id)
                            ->whereIn('status',['Rejected by the Program Chair', 'Rejected by the Dean', 'Rejected by the Chancellor', 'Rejected by the RMO'])->get();
            $bookciteds = BookCited::where('proposal_id',$id)
                            ->whereIn('status',['Rejected by the Program Chair', 'Rejected by the Dean', 'Rejected by the Chancellor', 'Rejected by the RMO'])->get();
            $journalciteds = JournalCited::where('proposal_id',$id)
                             ->whereIn('status',['Rejected by the Program Chair', 'Rejected by the Dean', 'Rejected by the Chancellor', 'Rejected by the RMO'])->get();
            $proposal = Research::where('id',$id)->first();
            $paperpresenteds = PaperPresented::where('proposal_id',$id)
                             ->whereIn('status',['Rejected by the Program Chair', 'Rejected by the Dean', 'Rejected by the Chancellor', 'Rejected by the RMO'])->get();
            $utilizeds = Utilized::where('proposal_id',$id)
                            ->whereIn('status',['Rejected by the Program Chair', 'Rejected by the Dean', 'Rejected by the Chancellor', 'Rejected by the RMO'])->get();
            $patenteds = Patented::where('proposal_id', $id)
                             ->whereIn('status',['Rejected by the Program Chair', 'Rejected by the Dean', 'Rejected by the Chancellor', 'Rejected by the RMO'])->get();
            $req = SucRequirement::where('research_id',$id)->first();
          
            return view('rmo.view_revision',[
                'proposal' => $proposal,
                'user' => $user,
                'members' => $members,
                'paperpublisheds' => $paperpublisheds,
                'bookciteds' => $bookciteds,
                'journalciteds' => $journalciteds,
                'paperpresenteds' =>$paperpresenteds,
                'utilizeds' => $utilizeds,
                'patenteds' => $patenteds,
                'req' => $req,
                'active' => "rmorevision",


            ]);
            
        }

        public function validateResearch($id)
        {
            $members = DB::table('research_members')->select('fullname')
                        ->where('proposal_id',$id)->get();
            $user = auth()->user();
            $paperpublisheds = PaperPublished::where('proposal_id', $id)
                            ->where(['status' =>'PENDING'])->get();
            $bookciteds = BookCited::where('proposal_id',$id)
                            ->where(['status' =>'PENDING'])->get();
            $journalciteds = JournalCited::where('proposal_id',$id)
                             ->where(['status' =>'PENDING'])->get();
            $proposal = Research::where('id',$id)->first();
            $paperpresenteds = PaperPresented::where('proposal_id',$id)
                             ->where(['status' =>'PENDING'])->get();
            $utilizeds = Utilized::where('proposal_id',$id)
                             ->where(['status' =>'PENDING'])->get();
            $patenteds = Patented::where('proposal_id', $id)
                             ->where(['status' =>'PENDING'])->get();
            $req = SucRequirement::where('research_id',$id)->first();
          
            return view('rmo.validate_rbp',[
                'proposal' => $proposal,
                'user' => $user,
                'members' => $members,
                'paperpublisheds' => $paperpublisheds,
                'bookciteds' => $bookciteds,
                'journalciteds' => $journalciteds,
                'paperpresenteds' =>$paperpresenteds,
                'utilizeds' => $utilizeds,
                'patenteds' => $patenteds,
                'req' => $req,
                'active' => "rmopending",


            ]);
            
        }

        public function approveResearchRMO($id)
        {
            $research = Research::where('id',$id)->first();
         
            $research->update([
                'location_from' => 'RMO',
                'location_to' => 'RMO',
                'station' => '4',
            ]);
            return redirect()->route('rmo-pending',$id)->with('success', 'Research has been approved.');
        }

        public function rejectResearchRMO(Request $request,$id)
        {
            
            $research = Research::where('id',$id)->first();
            $research->update([
                'status' => 'RMO',
                'location_from' => 'RMO',
                'location_to' => 'Chancellor',
                'station' => '3',

                'remarks' => $request->remarks,
            ]);
            return redirect()->route('rmo-pending',$id)->with('alert', 'Research has been rejected.');
        }
        
        public function approvePaperPresented(Request $request,$id)
        {
            $paperpresented = PaperPresented::where('id',$id)->first();
         
            $paperpresented->update([
                'status' => $request->status,
             
            ]);
            return back()->with('success', 'Paper Presentation Details Approved.');
        }

        public function rejectPaperPresented(Request $request,$id)
        {
            $paperpresented = PaperPresented::where('id',$id)->first();
         
            $paperpresented->update([
                'status' => $request->status,
            ]);

            return back()->with('alert', 'Paper Presentation Details Rejected.');
        }

        public function approvePaperPublished(Request $request,$id)
        {
            $paperpublished = PaperPublished::where('id',$id)->first();
         
            $paperpublished->update([
                'status' => $request->status,
             
            ]);
            return back()->with('success', 'Paper Published Details Approved.');
        }

        public function rejectPaperPublished(Request $request,$id)
        {
            $paperpublished = PaperPublished::where('id',$id)->first();
         
            $paperpublished->update([
                'status' => $request->status,
            ]);

            return back()->with('alert', 'Paper Published Details Rejected.');
        }

        public function approveBookCited(Request $request,$id)
        {
            $bookcited = BookCited::where('id',$id)->first();
         
            $bookcited->update([
                'status' => $request->status,
             
            ]);
            return back()->with('success', 'Book Cited Details Approved.');
        }

        public function rejectBookCited(Request $request,$id)
        {
            $bookcited = BookCited::where('id',$id)->first();
         
            $bookcited->update([
                'status' => $request->status,
            ]);

            return back()->with('alert', 'Book Cited Details Rejected.');
        }

        public function approveJournalCited(Request $request,$id)
        {
            $journalcited = JournalCited::where('id',$id)->first();
         
            $journalcited->update([
                'status' => $request->status,
             
            ]);
            return back()->with('success', 'Journal Cited Details Approved.');
        }

        public function rejectJournalCited(Request $request,$id)
        {
            $journalcited = JournalCited::where('id',$id)->first();
         
            $journalcited->update([
                'status' => $request->status,
            ]);

            return back()->with('alert', 'Journal Cited Details Rejected.');
        }

        public function submitForRevision(Request $request,$id)
        {
            $research = Research::where('id',$id)->first();
         
            $research->update([
                'location_from' => 'RMO',
                'location_to' => 'Chancellor',
                'station' => '3',
            ]);

            return back()->with('alert', 'The research has been rejected.');
        }


        ############################################# G E N E R A T E #####################################################################

        
        ################################S U M M A R Y  S H E E T##########################################
        public function generateSummary(){
            $user = auth()->user();
            $sheets = SummarySheet::all();

            return view('sheet.summarysheet',[
                'user' => $user,
                'sheets' => $sheets,
                'active' => "rmosheet"

                    ]);

                }  
        public function viewSummary(Request $request, Research $proposals){

            if($request->report == "1"){
                ///# of Research Centers
            }
            elseif($request->report == "2")
            {
            $this->validate($request, [
                'faculty_no' => 'required',
                'year' => 'required',
                'report' => 'required'
            ]);
            $user = auth()->user();
            $year2 = $request->year - 1;
            $year3 = $request->year - 2;
            $year1 = $request->year;
            $years = [$request->year1,$year2,$year3];
        
            $faculty_no = $request->faculty_no;  
            $member1 = DB::table('research_members')->join('research', 'research.id', '=', 'research_members.proposal_id')
                        ->whereYear('date_completed','=', $year1)
                        ->distinct('employee_no')
                        ->count('employee_no'); 
            $leader1 = DB::table('research')->whereYear('date_completed', '=', $year1)
                        ->distinct('leader_id')
                        ->count('leader_id');
            $total1 = $member1 + $leader1;

            $member2 = DB::table('research_members')->join('research', 'research.id', '=', 'research_members.proposal_id')
                        ->whereYear('date_completed', '=', $year2)
                        ->distinct('employee_no')
                        ->count('employee_no'); 
            $leader2 = DB::table('research')->whereYear('date_completed', '=', $year2)
                        ->distinct('leader_id')
                        ->count('leader_id');
            $total2 = $member2 + $leader2;

            $member3 = DB::table('research_members')->join('research', 'research.id', '=', 'research_members.proposal_id')
                        ->whereYear('date_completed', '=', $year3)
                        ->distinct('employee_no')
                        ->count('employee_no'); 
            $leader3 = DB::table('research')->whereYear('date_completed', '=', $year3)
                        ->distinct('leader_id')
                        ->count('leader_id');
            $total3 = $member3 + $leader3;
            $percent1 = round((($total1 / $faculty_no) * 100),2);
            $percent2 = round((($total2 / $faculty_no) * 100),2);
            $percent3 = round((($total3 / $faculty_no) * 100),2);
            $ave = round((($percent1 + $percent2 + $percent3)/3),2);

            $date = Carbon::now();
             $formatdate = $date->format('d-m-Y'); 

            
            return view('sheet.sheet2',[
                'year1' => $year1,
                'year2' => $year2,
                'year3' => $year3,
                'total1' => $total1,
                'total2' => $total2,
                'total3' => $total3,
                'percent1' => $percent1,
                'percent2' => $percent2,
                'percent3' => $percent3,
                'faculty_no' => $faculty_no,
                'ave' => $ave,
                'date' => $date,
                'active' => "rmosheet",
                'formatdate'  => $formatdate,
            ]);
            }
            elseif($request->report == "3")
            {
                $user = auth()->user();
                $year2 = $request->year - 1;
                $year3 = $request->year - 2;
                $year1 = $request->year;
                $years = [$request->year1,$year2,$year3];
                $programs = Research::where('type','Program')
                                    ->whereNotIn('funding_agency',['BSU', 'BulSU', 'Bulacan State University', 'bsu', 'bulsu', 'bulacan state university'])
                                      ->whereIn('contract_from',$years)
                                      ->get();
                           
                $projects = Research::where('type','Project')
                                    ->whereNotIn('funding_agency',['BSU', 'BulSU', 'Bulacan State University', 'bsu', 'bulsu', 'bulacan state university'])
                                    ->whereIn('contract_from',$years)
                                    ->get();
                $studies = Research::where('type','Study')
                                    ->whereNotIn('funding_agency',['BSU', 'BulSU', 'Bulacan State University', 'bsu', 'bulsu', 'bulacan state university'])
                                    ->whereIn('contract_from',$years)
                                    ->get();
                $programcount = Research::where('type','Program')
                                  ->whereNotIn('funding_agency',['BSU', 'BulSU', 'Bulacan State University', 'bsu', 'bulsu', 'bulacan state university'])
                                ->whereIn('contract_from',$years)
                                ->count();
                $projectcount = Research::where('type','Project')
                                 ->whereNotIn('funding_agency',['BSU', 'BulSU', 'Bulacan State University', 'bsu', 'bulsu', 'bulacan state university'])
                                ->whereIn('contract_from',$years)
                                ->count();
                $studycount = Research::where('type','Study')
                                  ->whereNotIn('funding_agency',['BSU', 'BulSU', 'Bulacan State University', 'bsu', 'bulsu', 'bulacan state university'])
                                ->whereIn('contract_from',$years)
                                ->count();
                $programpoints = $programcount * 1;
                $projectpoints = $projectcount * 0.75;
                $studypoints = $studycount * 0.50;
                
                $total = $programpoints + $projectpoints + $studypoints;

                $date = Carbon::now();
                $formatdate = $date->format('d-m-Y'); 

                if($total < 0.5){
                    $equ = "0";
                }
                elseif($total <= 2){
                    $equ = "2";
                }
                else{
                    $equ = "2";
                }
                return view('sheet.sheet3',[
                    'year1' => $year1,
                    'year2' => $year2,
                    'year3' => $year3,
                    'user' => $user,
                    'years' => $years,
                    'programs' => $programs,
                    'projects' => $projects,
                    'studies' => $studies,
                    'programcount' => $programcount,
                    'projectcount' => $projectcount,
                    'studycount' => $studycount,
                    'programpoints' => $programpoints,
                    'projectpoints' => $projectpoints,
                    'studypoints' => $studypoints,
                    'total' => $total,
                    'equ' => $equ,
                    'date' => $date,
                    'active' => "rmosheet",
                    'formatdate' => $formatdate,

                ]);
            }
            elseif($request->report == "4")
            {

            $user = auth()->user();
            $year2 = $request->year - 1;
            $year3 = $request->year - 2;
            $year1 = $request->year;
            $years = [$request->year1,$year2,$year3];
            $international1 = $proposals::join('paper_publisheds', 'paper_publisheds.proposal_id', '=', 'research.id')
                                        ->whereYear('research.date_published','=' , $year1)
                                        ->where('publication', 'International')
                                        ->count();
            $international2 = $proposals::join('paper_publisheds', 'paper_publisheds.proposal_id', '=', 'research.id')
                                        ->whereYear('research.date_published', '=' ,$year2)
                                    ->where('publication', 'International')
                                        ->count();
            $international3 = $proposals::join('paper_publisheds', 'paper_publisheds.proposal_id', '=', 'research.id')
                                        ->whereYear('research.date_published', '=', $year3)
                                    ->where('publication', 'International')
                                        ->count();
            $ched1 = $proposals::join('paper_publisheds', 'paper_publisheds.proposal_id', '=', 'research.id')
                                        ->whereYear('research.date_published', '=', $year1)
                                        ->where('publication', '<>', 'International')
                                        ->count();
            $ched2 = $proposals::join('paper_publisheds', 'paper_publisheds.proposal_id', '=', 'research.id')
                                        ->whereYear('research.date_published', '=', $year2)
                                        ->where('publication', '<>', 'International')
                                        ->count();
            $ched3 = $proposals::join('paper_publisheds', 'paper_publisheds.proposal_id', '=', 'research.id')
                                        ->whereYear('research.date_published','=' ,$year3)
                                        ->where('publication', '<>', 'International')
                                        ->count();
            $totalinternational = $international1 + $international2 + $international3;
            $totalched = $ched1 + $ched2 + $ched3;

            $date = Carbon::now();
            $formatdate = $date->format('d-m-Y'); 

            return view('sheet.sheet4',[
                    'year1' => $year1,
                    'year2' => $year2,
                    'year3' => $year3,
                    'international1' => $international1,
                    'international2' => $international2,
                    'international3' => $international3,
                    'ched1' => $ched1,
                    'ched2' => $ched2,
                    'ched3' => $ched3,
                    'totalinternational' => $totalinternational,
                    'totalched' => $totalched,
                    'active' => "rmosheet",
                    'formatdate' => $formatdate
                ]);
            }
            elseif($request->report == "5")
            {
                $user = auth()->user();
                $year2 = $request->year - 1;
                $year3 = $request->year;
                $year1 = $request->year - 2;
                $years = [$request->year1,$year2,$year3];
            
                $rbp1 = Research::where('date_completed', $year1)
                                ->where('deliverables', 'RBP')
                                ->count();
                $rbp2 = Research::where('date_completed', $year2)
                                ->where('deliverables', 'RBP')
                                ->count();
                $rbp3 = Research::where('date_completed', $year3)
                                ->where('deliverables', 'RBP')
                                ->count(); 
                $totalrbp = $rbp1 + $rbp2 + $rbp3;
                $pub1 = Research::where('date_completed', $year1)
                                ->where('date_published', $year1)
                                ->count();
                $pub2 = Research::where('date_completed', $year1)
                                ->where('date_published', $year2)
                                ->count();      
                $pub3 = Research::where('date_completed', $year1)
                                ->where('date_published', $year3)
                                ->count();
                $pub4 = Research::where('date_completed', $year2)
                                ->where('date_published', $year1)
                                ->count();
                $pub5 = Research::where('date_completed', $year2)
                                ->where('date_published', $year2)
                                ->count();
                $pub6 = Research::where('date_completed', $year2)
                                ->where('date_published', $year3)
                                ->count();
                $pub7 = Research::where('date_completed', $year3)
                                ->where('date_published', $year1)
                                ->count();
                $pub8 = Research::where('date_completed', $year3)
                                ->where('date_published', $year2)
                                ->count();
                $pub9 = Research::where('date_completed', $year3)
                                ->where('date_published', $year3)
                                ->count();   
                $total1 = $pub1 + $pub4 + $pub7;
                $total2 = $pub2 + $pub5 + $pub8;
                $total3 = $pub3 + $pub6 + $pub9;
                $total4 = $pub1 + $pub2 + $pub3;
                $total5 = $pub4 + $pub5 + $pub6;
                $total6 = $pub7 + $pub8 + $pub9;
                $total7 = $total4 + $total5 + $total6;

                if($totalrbp != "0")
                {
                    $percent1 = ($total1/$totalrbp) * 100;
                    $percent2 = ($total2/$totalrbp) * 100;
                    $percent3 = ($total3/$totalrbp) * 100;
                    $percent4 = $percent1 + $percent2 + $percent3;  
                }
                else{
                    $percent1 = "0";
                    $percent2 = "0";
                    $percent3 = "0";
                    $percent4 = "0";
                }
                if($percent4 < 5 )
                {
                    $pts = "0.0";
                }
                elseif($percent4 < 10 )
                {
                    $pts = "0.25";
                }
                elseif($percent4 < 15 )
                {
                    $pts = "0.5";
                }
                elseif($percent4 < 20 )
                {
                    $pts = "0.75";
                }
                else
                {
                    $pts = "1";
                }

                $date = Carbon::now();
                $formatdate = $date->format('d-m-Y'); 

                return view('sheet.sheet5',[
                    'year1' => $year1,
                    'year2' => $year2,
                    'year3' => $year3,
                    'rbp1' => $rbp1,
                    'rbp2' => $rbp2,
                    'rbp3' => $rbp3,
                    'totalrbp' => $totalrbp,
                    'pub1' => $pub1,
                    'pub2' => $pub2,
                    'pub3' => $pub3,
                    'pub4' => $pub4,
                    'pub5' => $pub5,
                    'pub6' => $pub6,
                    'pub7' => $pub7,
                    'pub8' => $pub8,
                    'pub9' => $pub9,
                    'total1' => $total1,
                    'total2' => $total2,
                    'total3' => $total3,
                    'total4' => $total4,
                    'total5' => $total5,
                    'total6' => $total6,
                    'total7' => $total7,
                    'percent1' => $percent1,
                    'percent2' => $percent2,
                    'percent3' => $percent3,
                    'percent4' => $percent4,
                    'pts' => $pts,
                    'date' => $date,
                    'active' => "rmosheet",
                    'formatdate' => $formatdate,


                ]);
            }
            elseif($request->report == "6"){
                $year2 = $request->year - 1;
                $year3 = $request->year;
                $year1 = $request->year - 2;
                $years = [$request->year1,$year2,$year3];
                $date = Carbon::now();
                $formatdate = $date->format('d-m-Y'); 
                $rbp1 = Research::where('date_completed', $year1)
                            ->where('deliverables', 'RBP')
                                ->count();
                $rbp2 = Research::where('date_completed', $year2)
                                ->where('deliverables', 'RBP')
                                ->count();
                $rbp3 = Research::where('date_completed', $year3)
                                ->where('deliverables', 'RBP')
                                ->count(); 
                $totalrbp = $rbp1 + $rbp2 + $rbp3;
                $pub1 = DB::table('research')->join('paper_presenteds', 'paper_presenteds.proposal_id', '=', 'research.id')
                                    ->where('research.date_presented', $year1)
                                    ->where('conference_type', 'International')
                                    ->count();
                $pub2 =DB::table('research')->join('paper_presenteds', 'paper_presenteds.proposal_id', '=', 'research.id')
                                    ->where('research.date_presented', $year1)
                                    ->where('conference_type', 'National')
                                    ->count();     
                $pub3 = DB::table('research')->join('paper_presenteds', 'paper_presenteds.proposal_id', '=', 'research.id')
                                    ->where('research.date_presented', $year1)
                                    ->where('conference_type', 'Regional')
                                    ->count();
                $pub4 = DB::table('research')->join('paper_presenteds', 'paper_presenteds.proposal_id', '=', 'research.id')
                                    ->where('research.date_presented', $year2)
                                    ->where('conference_type', 'International')
                                    ->count();
                $pub5 = DB::table('research')->join('paper_presenteds', 'paper_presenteds.proposal_id', '=', 'research.id')
                                    ->where('research.date_presented', $year2)
                                    ->where('conference_type', 'National')
                                    ->count();     
                $pub6 = DB::table('research')->join('paper_presenteds', 'paper_presenteds.proposal_id', '=', 'research.id')
                                    ->where('research.date_presented', $year2)
                                    ->where('conference_type', 'Regional')
                                    ->count();
                $pub7 = DB::table('research')->join('paper_presenteds', 'paper_presenteds.proposal_id', '=', 'research.id')
                                    ->where('research.date_presented', $year3)
                                    ->where('conference_type', 'International')
                                    ->count();
                $pub8 = $proposals::join('paper_presenteds', 'paper_presenteds.proposal_id', '=', 'research.id')
                                    ->where('research.date_presented', $year3)
                                    ->where('conference_type', 'National')
                                    ->count();     
                $pub9 = $proposals::join('paper_presenteds', 'paper_presenteds.proposal_id', '=', 'research.id')
                                    ->where('research.date_presented', $year3)
                                    ->where('conference_type', 'Regional')
                                    ->count();
                $total1 = $pub1 + $pub2 + $pub3;
                $total2 = $pub4 + $pub5 + $pub6;
                $total3 = $pub7 + $pub8 + $pub9;
                $total4 = $total1 + $total2 + $total3;
                $total5 = $pub1 + $pub4 + $pub7;
                $total6= $pub2 + $pub5 + $pub8;
                $total7 = $pub3 + $pub6 + $pub9;
                if($totalrbp != "0"){
                $percent1 = ($total4/$totalrbp) * 100;
                }
                else{
                    $percent1 = "0";
                }
                
                if($percent1 <20){
                    $equ = "0.0";
                }
                elseif($percent1 <30){
                    $equ = "0.25";
                }
                elseif($percent1 <40){
                    $equ = "0.50";
                }
                elseif($percent1 <51){
                    $equ = "0.75";
                }
                else{
                    $equ = "0.50";
                }
                if($total5 < 1){
                    $pts1 = "0.0";
                }
                elseif($total5 < 6){
                    $pts1 = "0.50";
                }
                elseif($total5 < 11){
                    $pts1 = "0.75";
                }
                else{
                    $pts1 = "1.0";
                }
                if($total6 < 3){
                    $pts2 = "0.0";
                }
                elseif($total6 < 9){
                    $pts2 = "0.125";
                }
                elseif($total6 < 15){
                    $pts2 = "0.25";
                }
                else{
                    $pts2 = "0.5";
                }
                if($total7 < 3){
                    $pts3 = "0.0";
                }
                elseif($total7 < 9){
                    $pts3 = "0.125";
                }
                elseif($total7 < 15){
                    $pts3 = "0.25";
                }
                else{
                    $pts3 = "05";
                }
                $totalpts = $equ + $pts1 + $pts2 + $pts3;
                return view('sheet.sheet6',[
                    'year1' => $year1,
                    'year2' => $year2,
                    'year3' => $year3,
                    'rbp1' => $rbp1,
                    'rbp2' => $rbp2,
                    'rbp3' => $rbp3,
                    'totalrbp' => $totalrbp,
                    'pub1' => $pub1,
                    'pub2' => $pub2,
                    'pub3' => $pub3,
                    'pub4' => $pub4,
                    'pub5' => $pub5,
                    'pub6' => $pub6,
                    'pub7' => $pub7,
                    'pub8' => $pub8,
                    'pub9' => $pub9,
                    'total1' => $total1,
                    'total2' => $total2,
                    'total3' => $total3,
                    'total4' => $total4,
                    'total5' => $total5,
                    'total6' => $total6,
                    'total7' => $total7,
                    'percent1' => $percent1,
                    'pts1' => $pts1,
                    'pts2' => $pts2,
                    'pts3' => $pts3,
                    'equ' => $equ,
                    'totalpts' => $totalpts,
                    'date' => $date,
                    'active' => "rmosheet",
                    'formatdate' => $formatdate,
                ]);
            }
            elseif($request->report == "7")
            {
                $year2 = $request->year - 1;
                $year3 = $request->year;
                $year1 = $request->year - 2;
                $years = [$request->year1,$year2,$year3];
                $date = Carbon::now();
                $formatdate = $date->format('d-m-Y'); 
                $cit1 = JournalCited::where('year_published', $year1)
                                    ->where('publication', 'International')
                                    ->count();
                $cit2 = JournalCited::where('year_published', $year2)
                                    ->where('publication', 'International')
                                    ->count();
                $cit3 = JournalCited::where('year_published', $year3)
                                    ->where('publication', 'International')
                                    ->count();
                $cit4 = JournalCited::where('year_published', $year1)
                                    ->where('publication', '<>', 'International')
                                    ->count();
                $cit5 = JournalCited::where('year_published', $year2)
                                    ->where('publication', '<>', 'International')
                                    ->count();
                $cit6 = JournalCited::where('year_published', $year3)
                                    ->where('publication', '<>', 'International')
                                    ->count();
                $total1 = $cit1 + $cit4;
                $total2 = $cit2 + $cit5;
                $total3 = $cit3 + $cit6;
                $total4 = $total1 + $total2 + $total3;
                if($total4 <= 20){
                    $pts = "0.0";
                }
                elseif($total4 <= 250 && $total4 > 20){
                    $pts = "0.0625";
                }
                elseif($total4 <= 480 && $total4 > 250){
                    $pts = "0.125";
                }
                else{
                    $pts = "0.25";
                }
                return view('sheet.sheet7',[
                    'year1' => $year1,
                    'year2' => $year2,
                    'year3' => $year3,
                    'cit1' => $cit1,
                    'cit2' => $cit2,
                    'cit3' => $cit3,
                    'cit4' => $cit4,
                    'cit5' => $cit5,
                    'cit6' => $cit6,
                    'total1' => $total1,
                    'total2' => $total2,
                    'total3' => $total3,
                    'total4' => $total4,
                    'pts' => $pts,
                    'date' => $date,
                    'active' => "rmosheet",
                    'formatdate' => $formatdate,

                ]);
            }
            elseif($request->report == "8"){
                $year2 = $request->year - 1;
                $year3 = $request->year;
                $year1 = $request->year - 2;
                $years = [$request->year1,$year2,$year3];
                $date = Carbon::now();
                $formatdate = $date->format('d-m-Y'); 
                $pub1 = DB::table('research')->join('book_citeds', 'book_citeds.proposal_id', '=', 'research.id')
                                    ->where('research.deliverables', 'RBP')
                                    ->where('book_citeds.year_published', $year1)
                                    ->count();
                $pub2 = DB::table('research')->join('book_citeds', 'book_citeds.proposal_id', '=', 'research.id')
                                    ->where('research.deliverables', 'RBP')
                                    ->where('book_citeds.year_published', $year2)
                                                        ->count();     
                $pub3 = DB::table('research')->join('book_citeds', 'book_citeds.proposal_id', '=', 'research.id')
                                    ->where('research.deliverables', 'RBP')
                                    ->where('book_citeds.year_published', $year3)
                                    ->count();
                $total = $pub1 + $pub2 + $pub3;
                if($total < 1){
                    $equ = "0.0";
                }
                if($total < 10 && $total > 0){
                    $equ = "0.125";
                }
                if($total > 9){
                    $equ = "0.25";
                }
                return view('sheet.sheet8',[
                    'year1' => $year1,
                    'year2' => $year2,
                    'year3' => $year3,
                    'pub1' => $pub1,
                    'pub2' => $pub2,
                    'pub3' => $pub3,
                    'total' => $total,
                    'equ' => $equ,
                    'date' => $date,
                    'active' => "rmosheet",
                    'formatdate' => $formatdate,
                ]);
            }
            else{
            
            }
        }



        ##################################### R E P O R T########################################################
        public function generateReport(){
            $user = auth()->user();
            $reports = Report::all();

            return view('report.report',[
                'user' => $user,
                'reports' => $reports,
                'active' => "rmoreport"
                    ]);

                }
                
        public function viewReport(Request $request){
            if($request->report == "1"){
                $user = auth()->user();
                $year2 = $request->year - 1;
                $year3 = $request->year - 2;
                $year1 = $request->year;
                $proposals = Research::where('date_completed', 'LIKE', ['%'.$year1.'%', '%'.$year2.'%', '%'.$year3.'%'])
                                        ->orderBy('date_completed','desc');

                return view('report.report1',[
                    'year1' => $year1,
                    'year2' => $year2,
                    'year3' => $year3,
                    'proposals' => $proposals,
                    'user' => $user,
                    'active' => "rmoreport"
                ]);
            }
            elseif($request->report == "2")
            {
            $this->validate($request, [
                
                'year' => 'required',
                'report' => 'required'
            ]);
            $user = auth()->user();
            $year2 = $request->year - 1;
            $year3 = $request->year - 2;
            $year1 = $request->year;
            $years = [$year1,$year2,$year3];
                
            //  $count = DB::table('users')
            //              ->join('research', 'research.leader_id', '=', 'users.id')
            //              ->whereNotIn('status',['I','RMO','PENDING','Chancellor','Dean','Program Chair'])
            //              ->whereIn('year_completed',$years)
            //              ->count();
            //              dd($count->year_completed);

            // $counts = DB::table('users')->leftJoin('research', 'research.leader_id', '=', 'users.id')
            //             ->select('research.title')
            //             ->groupBy('research.title')
                        
            //              ->where('users.type','Faculty')
            //              ->whereIn('research.year_completed',$years)    
            //              ->get();

            // dd($counts);
           $count = DB::table('users')
                    ->where('research_no','>=','2')
                    ->get();
                  
            $research = Research::whereIn('year_completed',$years)
                ->get();
            foreach($count as $c)
            $awards = ResearcherAward::where('researcher_id',$c->id)
                    ->whereIn('year',$years)
                    ->get();
            
            return view('report.report2',[
                'year1' => $year1,
                'year2' => $year2,
                'year3' => $year3,
                'years' => $years,
                'count' => $count,
                'research' => $research,
                'user' => $user,
                'awards' => $awards,
                'active' => "rmoreport",
                'count' => $count,

            ]);

        }
            elseif($request->report == "3"){
                $user = auth()->user();
                $year2 = $request->year - 1;
                $year3 = $request->year - 2;
                $year1 = $request->year;
                $publisheds = PaperPublished::where('status','Approved by the RMO')->get(); 
                // $title = DB::table('paper_publisheds')->select('title')
                //                     ->join('research', 'research.id', '=', 'paper_publisheds.proposal_id')
                //                     ->where(['paper_publisheds.status' => 'Approved by the RMO'])
                //  
                
                           

                return view('report.report3',[
                    'year1' => $year1,
                    'year2' => $year2,
                    'year3' => $year3,
                    'publisheds' => $publisheds,
                    'user' => $user,
                  //  'title' => $title,
                    'active' => "rmoreport",
                    
                ]);
            }
            elseif($request->report == "4"){
                $user = auth()->user();
                $year2 = $request->year - 1;
                $year3 = $request->year - 2;
                $year1 = $request->year;
                $presenteds = PaperPresented::where('status','Approved by the RMO')->get(); 
                $title = DB::table('paper_presenteds')->select('title')
                                    ->join('research', 'research.id', '=', 'paper_presenteds.proposal_id')
                                    ->where(['paper_presenteds.status' => 'Approved by the RMO'])
                                    ->first();
                $members = DB::table('paper_presenteds')
                        ->join('research', 'research.id', '=', 'paper_presenteds.proposal_id')
                        ->join('research_members', 'research_members.proposal_id','=','research.id')
                        ->selectRaw('GROUP_CONCAT(research_members.fullname) as fullnames')
                        ->first();

                return view('report.report4',[
                    'year1' => $year1,
                    'year2' => $year2,
                    'year3' => $year3,
                    'presenteds' => $presenteds,
                    'user' => $user,
                    'title' => $title,
                    'members' => $members,
                    'active' => "rmoreport"
                ]);
            }
            elseif($request->report == "5"){
                $user = auth()->user();
                $year2 = $request->year - 1;
                $year3 = $request->year - 2;
                $year1 = $request->year;
                $journalciteds = JournalCited::where('status','Approved by the RMO')->get(); 
                $title = DB::table('journal_citeds')->select('title')
                                    ->join('research', 'research.id', '=', 'journal_citeds.proposal_id')
                                    ->where(['journal_citeds.status' => 'Approved by the RMO'])
                                    ->first();
                $members = DB::table('journal_citeds')
                        ->join('research', 'research.id', '=', 'journal_citeds.proposal_id')
                        ->join('research_members', 'research_members.proposal_id','=','research.id')
                        ->select(DB::raw('group_concat(research_members.fullname) as names'))
                        ->first();

                return view('report.report5',[
                    'year1' => $year1,
                    'year2' => $year2,
                    'year3' => $year3,
                    'journalciteds' => $journalciteds,
                    'user' => $user,
                    'title' => $title,
                    'members' => $members,
                    'active' => "rmoreport"
                ]);
            }
            elseif($request->report == "6"){
            
                $user = auth()->user();
                $year2 = $request->year - 1;
                $year3 = $request->year - 2;
                $year1 = $request->year;
                $bookciteds = BookCited::where('status','Approved by the RMO')->get(); 
                $title = DB::table('book_citeds')->select('title')
                                    ->join('research', 'research.id', '=', 'book_citeds.proposal_id')
                                    ->where(['book_citeds.status' => 'Approved by the RMO'])
                                    ->first();
                $members = DB::table('book_citeds')
                        ->join('research', 'research.id', '=', 'book_citeds.proposal_id')
                        ->join('research_members', 'research_members.proposal_id','=','research.id')
                        ->select(DB::raw('group_concat(research_members.fullname) as names'))
                        ->first();

                return view('report.report6',[
                    'year1' => $year1,
                    'year2' => $year2,
                    'year3' => $year3,
                    'bookciteds' => $bookciteds,
                    'user' => $user,
                    'title' => $title,
                    'members' => $members,
                    'active' => "rmoreport"
                ]);
            }
        }


             #-----------------------Researchers Tab---------------------------------------------
    public function facultyDashboard(){
        $user = auth()->user();
        $search = request()->query('search');
        if ($search) {
            $faculties = User::where('firstname', 'LIKE', '%' . ($search) . '%')
                                    ->orWhere('lastname', 'LIKE', "%{$search}%")
                                    ->orWhere('suffix', 'LIKE', "%{$search}%")
                                    ->orWhere('fullname', 'LIKE', "%{$search}%")    
                                    ->orWhere('email', 'LIKE', "%{$search}%")
                                    ->orWhere('employee_no', 'LIKE', "%{$search}%")
                                    ->orWhere('employee_type', 'LIKE', "%{$search}%")
                                    ->orWhere('position', 'LIKE', "%{$search}%")
                                    ->where(['is_active' => '1'])
                                    ->where('type','Faculty')
                                    ->orderBy('fullname', 'asc')
                                    ->paginate(5);
        }
        else {
        $faculties = User::where('is_active', '1')
                             ->where('type','Faculty')
                             ->orderBy('fullname', 'asc')       
                             ->paginate(5);
        }
        return view('rmo.faculties.index', [
            'user' => $user,
            'faculties' => $faculties,
            'search' => $search,
            'active' => "rmofaculty"
        ]);
}

public function viewFaculty($id){
    
    $user = auth()->user();
    $faculties = User::where('id',$id)->first();
    $pos = Research::where('id',$id)->first();
    $try = Research::where(['leader_id' => $id, 'status' => 'COMPLETED'])->get();
    $leader = Research::where(['leader_id' => $id])
                        ->count();
    $member = ResearchMember::where(['user_id' => $id])
                        ->count();
    $total = $member + $leader;
    $mtable = $faculties::join('research_members', 'research_members.user_id', '=', 'users.id')
                ->join('research', 'research.id', '=', 'research_members.proposal_id')
                ->where('users.id', $id)
                ->get();         
    $ltable = Research::where(['leader_id' => $id])
                    ->get();
    // $position = 'Member';

                   
    $proposals = $ltable->merge($mtable)->paginate(5);
   //  $proposals = Paginator($proposals, 5);
   // $proposals = DB::table($proposals)->simplePaginate(5);
  
    
    return view('rmo.faculties.show_faculty',[
        'proposals' => $proposals,
        'user' => $user,
        'faculties' => $faculties,
        'leader' => $leader,
        'member' => $member,
        'total' => $total,
        'id' => $id,
      //  'position' => $position,
        'pos' => $pos,
        'active' => "rmofaculty"
    ]);

}

public function viewFacultyResearch(Research $proposal, $id, User $faculties){
    $user = auth()->user();
    $userid = $user->id;
    $fid = $faculties->id;
    $proposal = Research::where('id', $id)->first();
    $members = DB::table('research_members')->select('fullname')
                        ->where('proposal_id',$id)
                        ->get();
    
    return view('rmo.faculties.view_research',[
        'user' => $user,
        'userid' => $userid,
        'fid' => $fid,
        'faculties' => $faculties,
        'proposal' => $proposal,
        'members' => $members,
        'active' => "rmofaculty"
    ]);
  
    }
}

