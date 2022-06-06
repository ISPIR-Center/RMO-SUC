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
use App\Models\EmployeeType;
use App\Models\Department;
use App\Models\EmployeePosition;
use App\Models\PaperPresented;
use App\Models\ResearcherAward;
use Illuminate\Support\Facades\File;
use DB;
use Illuminate\Pagination\Paginator;

class FacultyController extends Controller
{
    ################################################## A P P R O V E D T A B ############################################################
    public function rbpDashboard(){
        $user = auth()->user();
        $search = request()->query('search');
        if ($search) {
            $proposals = Research::where('title', 'LIKE', '%' . ($search) . '%')
                                    ->where([ 'user_id' => $user->id])
                                    ->where(['status' => 'APPROVED'])
                                    ->where(['deliverables' => 'Research Based Paper'])
                                    ->orWhere('date_completed', 'LIKE', "%{$search}%")
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(5);
        }
        else {
        $proposals = Research::where(['user_id' => $user->id])
                             ->where(['deliverables' => 'Research Based Paper'])
                             ->where(['status' => 'APPROVED'])
                             ->orderBy('created_at', 'desc')       
                             ->paginate(5);
        }
        return view('faculty.rbp.rbp_dashboard', [
            'user' => $user,
            'proposals' => $proposals,
            'search' => $search,
            'active' => "facultyrbp",
        ]);
    }

    public function createRBP(){
        $user = auth()->user();
       
        $research_discipline_covered = DB::table('discipline_covereds')->select('name')
                                        ->get();
        return view('faculty.rbp.create', [
            'user' => $user,
            'active' => "facultyrbp",
            'research_discipline_covered' => $research_discipline_covered
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

        $status = 'PENDING';
        $location = 'College';
        $CF = date('Y-m-h') . $request->fileInputCF->getClientOriginalName() . 'new';
        $request->fileInputCF->move(public_path('requirements'), $CF);
        
        $PCF = date('Y-m-h') . $request->fileInputPCF->getClientOriginalName() . 'new';
        $request->fileInputPCF->move(public_path('requirements'), $PCF);
        $research_no = $user->research_no + 1;
        $year = date('Y', strtotime($request->research_date_completed));

        $research->create([
            'user_id' => $user->id,
            'title' => $request->title,
            'type' => $request->type,
            'leader' => $user->fullname,
            'leader_id' => $user->id,
            'status' => $status,
            'deliverables' => 'Research Based Paper',
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
         'college' => $user->college,
         'location_from' => 'Faculty',
            'location_to' => 'Program Chair',
            'year_completed' => $year
        ]);

        $user->update([
            'research_no' => $research_no
        ]);
        $latest = Research::latest()->first();
       
      return redirect()->route('faculty-rbp-addmembers',$latest->id);
      //  return back()->with('alert', 'Faculty added successfully.');
        }

        public function viewResearchAddMembers($researchid) {
          
            $search = request()->query('search');
            $proposal = Research::where('id', $researchid)->first();
       
            $user = auth()->user();
            $proposalMember = ResearchMember::where('proposal_id', $proposal->id)->get();
            $added = ResearchMember::where('proposal_id', $proposal->id)->get();
    
            
            if($search) {
                $faculties = User::where('fullname', 'LIKE', "%{$search}%")
                                    ->orWhere('email', 'LIKE', "%{$search}%")
                                    ->orWhere('employee_no', 'LIKE', "%{$search}%")
                                    ->orWhere('college', 'LIKE', "%{$search}%")
                                    ->where('type', ['Faculty'])
                                    ->where('id','<>',$user->id)
                                    ->paginate(5);
                $faculties->count();
                return view('faculty.rbp.add_member', [
                    'user' => $user,
                    'added' => $added,
                    'search' => $search,
                    'faculties' => $faculties,
                    'researchid' => $researchid,
                    'proposalMember' => $proposalMember,
                    'proposal' => $proposal
                ]);
    
            } else {
    
                $faculties = User::where('type', ['Faculty'])
                                    ->where('id','<>',$user->id)
                                    ->paginate(5);
             
                return view('faculty.rbp.add_member', [
                    'user' => $user,
                    'added' => $added,
                    'active' => "facultyrbp",
                    'search' => $search,
                    'faculties' => $faculties,
                    'proposal' => $proposal,
                    'researchid' => $researchid,
                    'proposalMember' => $proposalMember,
                ]);
            }
        }
    
        public function addMember( Research $proposal, ResearchMember $pm, User $faculty,Request $request) { 
          
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
            return view('faculty.rbp.upload_file',[
                'user' => $user,
                'active' => "rbp",
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
                            ->where('status','Approved by the RMO')->get();
            $bookciteds = BookCited::where('proposal_id',$id)
                             ->where('status','Approved by the RMO')->get();
            $journalciteds = JournalCited::where('proposal_id',$id)
                             ->where('status','Approved by the RMO')->get();
            $proposal = Research::where('id',$id)->first();
            $paperpresenteds = PaperPresented::where('proposal_id',$id)
                             ->where('status','Approved by the RMO')->get();
            $utilizeds = Utilized::where('proposal_id',$id)
                              ->where('status','Approved by the RMO')->get();
            $patenteds = Patented::where('proposal_id', $id)
                              ->where('status','Approved by the RMO')->get();
            $req = SucRequirement::where('research_id',$id)->first();
          
            return view('faculty.rbp.view_rbp',[
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
                'active' => "facultyrbp",


            ]);
            
        }

    ##################################### P E N D I N G T A B ############################################################ 
    public function pendingDashboard(){
        $user = auth()->user();
        $search = request()->query('search');
        if ($search) {
            $proposals = Research::where('title', 'LIKE', '%' . ($search) . '%')
                                    ->where(['user_id' => $user->id])
                                    ->whereIn('status',['RMO', 'Dean', 'Chancellor','PENDING'])
                                    ->where('location_from','<>','Program Chair')
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(5);
        }
        else {
        $proposals = Research::where(['user_id' => $user->id])
                             ->whereIn('status',['RMO', 'Dean', 'Chancellor','PENDING'])
                             ->where('location_from','<>','Program Chair')
                             ->orderBy('created_at', 'desc')       
                             ->paginate(5);
        }
        return view('faculty.pending_dashboard', [
            'user' => $user,
            'proposals' => $proposals,
            'active' => "facultypending",
            'search' => $search
        ]);
       } 

       public function viewPending($id)
        {
            $members = DB::table('research_members')->select('fullname')
                        ->where('proposal_id',$id)->get();
            $user = auth()->user();
            $paperpublisheds = PaperPublished::where('proposal_id', $id)
                                ->whereIn('status',['Approved by the Program Chair','Approved by the Dean', 'Approved by the Chancellor', 'Approved by the RMO'])->get();
            $bookciteds = BookCited::where('proposal_id',$id)
                                ->whereIn('status',['Approved by the Program Chair','Approved by the Dean', 'Approved by the Chancellor', 'Approved by the RMO'])->get();
            $journalciteds = JournalCited::where('proposal_id',$id)
                                ->whereIn('status',['Approved by the Program Chair','Approved by the Dean', 'Approved by the Chancellor', 'Approved by the RMO'])->get();
            $proposal = Research::where('id',$id)->first();
            $paperpresenteds = PaperPresented::where('proposal_id',$id)
                                 ->whereIn('status',['Approved by the Program Chair','Approved by the Dean', 'Approved by the Chancellor', 'Approved by the RMO'])->get();
            $utilizeds = Utilized::where('proposal_id',$id)
                                 ->whereIn('status',['Approved by the Program Chair','Approved by the Dean', 'Approved by the Chancellor', 'Approved by the RMO'])->get();
            $patenteds = Patented::where('proposal_id', $id)
                                  ->whereIn('status',['Approved by the Program Chair','Approved by the Dean', 'Approved by the Chancellor', 'Approved by the RMO'])->get();
            $req = SucRequirement::where('research_id',$id)->first();
          
            return view('faculty.rbp.view_pending',[
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
                'active' => "facultypending",
            ]);
            
        }

        public function viewRevision($id)
        {
            $members = DB::table('research_members')->select('fullname')
                        ->where('proposal_id',$id)->get();
            $user = auth()->user();
            $paperpublisheds = PaperPublished::where('proposal_id', $id)
                                ->whereIn('status',['Program Chair','Dean', 'Chancellor', 'RMO'])->get();
            $bookciteds = BookCited::where('proposal_id',$id)
                                ->whereIn('status',['Program Chair','Dean', 'Chancellor', 'RMO'])->get();
            $journalciteds = JournalCited::where('proposal_id',$id)
                                ->whereIn('status',['Program Chair','Dean', 'Chancellor', 'RMO'])->get();
            $proposal = Research::where('id',$id)->first();
            $paperpresenteds = PaperPresented::where('proposal_id',$id)
                                ->whereIn('status',['Program Chair','Dean', 'Chancellor', 'RMO'])->get();
            $utilizeds = Utilized::where('proposal_id',$id)
                                 ->whereIn('status',['Program Chair','Dean', 'Chancellor', 'RMO'])->get();
            $patenteds = Patented::where('proposal_id', $id)
                                ->whereIn('status',['Program Chair','Dean', 'Chancellor', 'RMO'])->get();
            $req = SucRequirement::where('research_id',$id)->first();
          
            return view('faculty.rbp.view_revision',[
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
                'active' => "facultypending",
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
                ->whereIn('status',['Rejected by the RMO','Rejected by the Program Chair', 'Rejected by the Dean', 'Rejected by the Chancellor'])->get();
        $bookciteds = BookCited::where('proposal_id',$id)
        ->whereIn('status',['Rejected by the RMO','Rejected by the Program Chair', 'Rejected by the Dean', 'Rejected by the Chancellor'])->get();
        $journalciteds = JournalCited::where('proposal_id',$id)
        ->whereIn('status',['Rejected by the RMO','Rejected by the Program Chair', 'Rejected by the Dean', 'Rejected by the Chancellor'])->get();
        $paperpresenteds = PaperPresented::where('proposal_id',$id)
        ->whereIn('status',['Rejected by the RMO','Rejected by the Program Chair', 'Rejected by the Dean', 'Rejected by the Chancellor'])->get();
        $utilizeds = Utilized::where('proposal_id',$id)
        ->whereIn('status',['Rejected by the RMO','Rejected by the Program Chair', 'Rejected by the Dean', 'Rejected by the Chancellor'])->get();
        $patenteds = Patented::where('proposal_id', $id)
        ->whereIn('status',['Rejected by the RMO','Rejected by the Program Chair', 'Rejected by the Dean', 'Rejected by the Chancellor'])->get();
        $reqs = SucRequirement::where('research_id',$id)->first();
        //dd($data);
        return view('faculty.rbp.edit', [
            'data' => $data,
            'deliverables' => $deliverables,
            'research_discipline_covered' => $research_discipline_covered,
            'members' => $members,
            'active' => "facultypending",
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
            'leader' => $request->proposal_leader_name,
            'leader_id' => $leaderId->id,
            'date_completed' => $request->research_date_completed,
            'discipline_covered' => $request->research_discipline_covered,
            'program_component' => $request->research_program_component,
            'funding_agency' => $request->research_funding_agency,
            'budget' => $request->budget,
            'university_research_agenda' => $request->university_research_agenda,
            'status' => 'PENDING',
            'location_from' => 'Faculty',
            'location_to' => 'Program Chair',
            'station' => '1',
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

        // SucRequirements::where('proposal_id', $id)
        //                 ->update([
        //                     'suc_completed_file' => $request->fileInputCF,
        //                     'suc_contract_file' => $request->fileInputPCF,
        //                 ]);
        return redirect()->route('faculty-pending')->with('success', 'Pending Proposal successfully updated.');
    }


    ############################ F O R R E V I S I O N ############################
    public function revisionDashboard(){
        $user = auth()->user();
        $search = request()->query('search');
        if ($search) {
            $proposals = Research::where('title', 'LIKE', '%' . ($search) . '%')
                                    ->where(['user_id' => $user->id])
                                    ->whereIn('status',['RMO','Program Chair', 'Dean', 'Chancellor'])
                                    ->where(['location_from' => 'Program Chair'])
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(5);
        }
        else {
        $proposals = Research::where(['user_id' => $user->id])
                            ->whereIn('status',['RMO','Program Chair', 'Dean', 'Chancellor' ])
                            ->where(['location_from' => 'Program Chair'])
                             ->orderBy('created_at', 'desc')       
                             ->paginate(5);
        }
        return view('faculty.revision_dashboard', [
            'user' => $user,
            'proposals' => $proposals,
            'active' => "facultyrevision",
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
            'active' => "rbp",
            'id' => $id,    
            'active' => "facultypending",
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
       $status = "PENDING";
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
            'status' => $status,
            'year_published' => $year
        ]);
        return redirect()->route('faculty-rbp-view',$id)->with('success', 'Paper Published Information has been added.');
        }

        public function viewPaperPublished($id)
        {
            
            $user = auth()->user();
            
            $paperpublisheds = PaperPublished::where('id',$id)->first();
           
            
            return view('faculty.rbp.paperpublished.view',[
                'user' => $user,
                'active' => "facultypending",
                'paperpublisheds' => $paperpublisheds,
            ]);
            
        }
        public function editPaperPublished($proposalid,$id){
            $user= auth()->user();
            $data = PaperPublished::where('id', $id)->first();
            //dd($data);      
            return view('faculty.rbp.paperpublished.edit', [
                'data' => $data,
                'user' => $user,
                'active' => "facultypending",
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
                    'status' => 'PENDING',
                    'vol_no' => $request->vol_no,
                    'pages' => $request->pages,
        ]);
        
        $proposal->update([
            'is_published' => '1',
            'year_published' => $year,
            'status' => 'PENDING'
         
        ]);
        return redirect()->route('faculty-rbp-edit',$proposalid)->with('success', 'Paper Published Successfully Updated.');
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
                        'status' => 'PENDING',
                        'vol_no' => $request->vol_no,
                        'pages' => $request->pages,
            ]);  
            
            $proposal->update([
                'is_published' => $p,
                'status' => 'PENDING',
                'year_published' => $year
            ]);
            return redirect()->route('faculty-rbp-view',$proposalid)->with('success', 'Paper Published Successfully Updated.');
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
           
        return view('faculty.rbp.paperpresented.create', [
            'user' => $user,
            'active' => "facultypending",
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
       $status = "PENDING";
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
        $year = date('Y', strtotime($request->date));
        $proposal->update([
            'is_presented' => $p,
            'status' => 'PENDING',
            'year_presented' => $year
        ]);
        return redirect()->route('faculty-rbp-view',$id)->with('success', 'Paper Presented Information has been added.');
        }

        public function viewPaperPresented($id)
        {
            
            $user = auth()->user();
            
            $paperpresenteds = PaperPresented::where('id',$id)->first();
           
            
            return view('faculty.rbp.paperpresented.view',[
                'user' => $user,
                'active' => "facultypending",
                'paperpresenteds' => $paperpresenteds,
            ]);
            
        }

        public function editPaperPresented($proposalid,$id){
            $user= auth()->user();
            $data = PaperPresented::where('id', $id)->first();
            //dd($data);      
            return view('faculty.rbp.paperpresented.edit', [
                'data' => $data,
                'active' => "facultypending",
                'user' => $user,
                'proposalid' => $proposalid
            ]);
        }

        public function updatePaperPresented(Request $request,$proposalid, $id){
            
            $proposal = Research::where('id',$proposalid)->first();
            $files = PaperPresented::where('id',$id)->first();  
            $year = date('Y', strtotime($request->date));
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
                    'status' => 'PENDING',
                    'organizer' => $request->organizer,
        ]);
       
        $proposal->update([
            'is_published' => '1',
            'status' => 'PENDING',
            'year_published' => $year
          
        ]);
        return redirect()->route('faculty-rbp-edit',$proposalid)->with('success', 'Paper Presented Successfully Updated.');
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
                        'status' => 'PENDING',
                        'organizer' => $request->organizer,
            ]);  
            $proposal->update([
                'is_published' => '1',
                'year_published' => $year,
                'status' => 'PENDING'
              
            ]);
            return redirect()->route('faculty-rbp-edit',$proposalid)->with('success', 'Paper Presented Successfully Updated.'); 
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
           
        return view('faculty.rbp.journalcited.create', [
            'user' => $user,
            'active' => "facultypending",
            'id' => $id,    
        ]);
    }

    public function storeJournalCited(Request $request, $id, JournalCited $jour){
     
        $user = auth()->user();
        $proposal = Research::where('id',$id)->first();
    
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

       $status = "PENDING";
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
        $year = date('Y', strtotime($request->year_published));
        $proposal->update([
            'is_journal_cited' => $p,
            'status' => $status,
            'year_journal_cited' => $year
        ]);
        return redirect()->route('faculty-rbp-view',$id)->with('success', 'Journal Cited Information has been added.');
        }

        public function viewJournalCited($id)
        {
            
            $user = auth()->user();
            
            $journalciteds = JournalCited::where('id',$id)->first();
           
            
            return view('faculty.rbp.journalcited.view',[
                'user' => $user,
                'active' => "facultypending",
                'journalciteds' => $journalciteds,
            ]);
            
        }

        public function editJournalCited($proposalid,$id){
            $user= auth()->user();
            $data = JournalCited::where('id', $id)->first();
            //dd($data);      
            return view('faculty.rbp.journalcited.edit', [
                'data' => $data,
                'user' => $user,
                'active' => "facultypending",
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
                        'status' => 'PENDING',
                        'link' => $request->link,
                        'vol_no' => $request->vol_no,
                        'pages' => $request->pages,
            ]);  
            $year = date('Y', strtotime($request->year_published));
            $proposal = Research::where('id',$id)->first();
            $p = "1";
            $proposal->update([
                'is_journal_cited' => $p,
                'status' => 'PENDING',
                'year_journal_cited' => $year
            
            ]);
            return redirect()->route('faculty-rbp-edit',$proposalid)->with('success', 'Journal Cited Successfully Updated.');
        }

        public function deleteJournalCited($id){
            $pending = JournalCited::find($id);
            $pending->delete();
    
            return back()->with('alert', 'Journal Cited Informations has been deleted');
        }

             ########################B O O K C I T E D###################################
    public function createBookCited($id){
        $user = auth()->user();
           
        return view('faculty.rbp.bookcited.create', [
            'user' => $user,
            'active' => "facultypending",
            'id' => $id,    
        ]);
    }

    public function storeBookCited(Request $request, $id, BookCited $book){
     
        $user = auth()->user();
        $proposal = Research::where('id',$id)->first();
        
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

       $status = "PENDING";
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
        $year = date('Y', strtotime($request->year_published));
        $proposal->update([
            'is_book_cited' => $p,
            'status' => $status,
            'year_book_cited' => $year
        ]);
        return redirect()->route('faculty-rbp-view',$id)->with('success', 'Book Cited Information has been added.');
        }

        public function viewBookCited($id)
        {
            
            $user = auth()->user();
            
            $bookciteds = BookCited::where('id',$id)->first();
           
            
            return view('faculty.rbp.bookcited.view',[
                'user' => $user,
                'active' => "facultypending",
                'bookciteds' => $bookciteds,
            ]);
            
        }

        public function editBookCited($proposalid,$id){
            $user= auth()->user();
            $data = BookCited::where('id', $id)->first();
            //dd($data);      
            return view('faculty.rbp.bookcited.edit', [
                'data' => $data,
                'user' => $user,
                'active' => "facultypending",
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
                        'status' => 'PENDING',
                        'vol_no' => $request->vol_no,
                        'pages' => $request->pages,
                        'link' => $request->link
            ]); 
            $year = date('Y', strtotime($request->year_published)); 
            $proposal = Research::where('id',$id)->first();
            $p = "1";
            $proposal->update([
                'is_book_cited' => $p,
                'status' => 'PENDING',
                'year_book_cited' => $year
              
            ]);

            return redirect()->route('faculty-rbp-edit',$proposalid)->with('success', 'Book Cited Successfully Updated.');
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
                                    ->where([ 'user_id' => $user->id])
                                    ->where(['deliverables' => 'Invention'])
                                    ->orWhere('date_completed', 'LIKE', "%{$search}%")
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(5);
        }
        else {
        $proposals = Research::where(['user_id' => $user->id])
                             ->where(['deliverables' => 'Invention'])
                             ->orderBy('created_at', 'desc')       
                             ->paginate(5);
        }
        return view('faculty.invention.invention_dashboard', [
            'user' => $user,
            'proposals' => $proposals,
            'search' => $search,
            'active' => "facultyinvention",
        ]);
    }

    public function createInvention(){
        $user = auth()->user();
       
        $research_discipline_covered = DB::table('discipline_covereds')->select('name')
                                        ->get();
        return view('faculty.invention.create', [
            'user' => $user,
            'active' => "facultyinvention",
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

        $status = 'PENDING';
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
        ]);
        $latest = Research::latest()->first();
       
      return redirect()->route('faculty-invention-addmembers',$latest->id);
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
                                    ->orWhere('college', 'LIKE', "%{$search}%")
                                    ->where('type', ['Faculty'])
                                    ->where('id','<>',$user->id)
                                    ->paginate(5);
                $faculties->count();
                return view('faculty.invention.add_member', [
                    'user' => $user,
                    'added' => $added,
                    'search' => $search,
                    'faculties' => $faculties,
                    'researchid' => $researchid,
                    'proposalMember' => $proposalMember,
                    'proposal' => $proposal
                ]);
    
            } else {
    
                $faculties = User::where('type', ['Faculty'])
                                    ->where('id','<>',$user->id)
                                    ->paginate(5);
             
                return view('faculty.invention.add_member', [
                    'user' => $user,
                    'added' => $added,
                    'active' => "facultyinvention",
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

        return view('faculty.invention.view_invention',[
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
            'active' => "facultyinvention",


]);

        }

                    ########################P A T E N T E D###################################
    
        public function createPatented($id){
            $user = auth()->user();
                
            return view('faculty.invention.patented.create', [
                'user' => $user,
                'active' => "facultyinvention",
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

       $status = "PENDING";
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
            'status' => $status,
        ]);
      
        return redirect()->route('faculty-invention-view',$id)->with('success', 'Patented Information Successfully Added.');
        }

        public function viewPatented($id)
        {
            
            $user = auth()->user();
            
            $patenteds = Patented::where('id',$id)->first();
           
            
            return view('faculty.invention.patented.view',[
                'user' => $user,
                'active' => "facultyinvention",
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

       $status = "PENDING";
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
            'status' => $status,
        ]);
        return back()->with('success','Utilized Information Added.');
        }

        public function viewUtilized($id)
        {
            
            $user = auth()->user();
            
            $utilizeds = Utilized::where('id',$id)->first();
           
            
            return view('faculty.invention.utilized.view',[
                'user' => $user,
                'active' => "facultyinvention",
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



    ############################################# P R O F I L E###################################################
    public function viewProfile($id){
        $user = auth()->user();
        $proponent = User::where(['id'=>$id])->first();
        $awards = ResearcherAward::where(['researcher_id'=>$id])->get();

        return view('faculty.profile.view_profile')->with([
            'proponent' => $proponent,
            'user' => $user,
            'awards' => $awards,
            'active' => 'manageaccount'
        ]);
    }
    public function editProfile($id){
        $user = auth()->user();
        $proponent = User::where(['id'=>$id])->first();
        $type = EmployeeType::get();
        $position = EmployeePosition::get();
        $departments = Department::get();
        
        return view('faculty.profile.edit_profile')->with([
            'proponent' => $proponent,
            'type' => $type,
            'departments' => $departments,
            'position' => $position,
            'user' => $user,
            'active' => 'manageaccount'
        ]);
    }
    public function updateProfile(Request $request,$id) {
        
        if($request->middlename) {
            $fullname = $request->firstname . ' ' . $request->middlename . ' ' . $request->lastname;
        } else {
            $fullname = $request->firstname . ' ' .$request->lastname;
        }
        $proponent = User::where(['id' => $id])->first();
        $proponent->update([
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'fullname' => $fullname,
            'suffix' => $request->suffix,
            'employee_no' => $request->employee_no,
            'email' => $request->email,
            'contact' => $request->contact,
            'gender' => $request->gender,
            'employee_type' => $request->employee_type,
            'position' => $request->position,
            'employee_type' => $request->employee_type,
        ]);

        if($request->fileInputPic) {
            $newImage = time() . $fullname . '.' . $request->fileInputPic->extension();
            $request->fileInputPic->move(public_path('img/users/'), $newImage);
            $proponent->update(['image' => $newImage]);
        }

        return back()->with('success', 'Proponent profile updated.');
    }
    
        public function addAward( $id,Request $request, ResearcherAward $awards)
        {
    
        $this->validate($request, [
            'name' => 'required',
            'year' => 'required',

        ]);  
        
           $awards->create([
            'researcher_id' => $id,
            'name' => $request->name,
            'year' => $request->year,

        ]);
        return back()->with('success', ' Award has been added.');
        }

}
