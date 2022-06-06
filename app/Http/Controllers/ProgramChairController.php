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
use Illuminate\Support\Facades\File;
use DB;
use Illuminate\Pagination\Paginator;

class ProgramChairController extends Controller
{
    public function pendingDashboard(){
        $user = auth()->user();
        $search = request()->query('search');
        if ($search) {
            $proposals = Research::where('title', 'LIKE', '%' . ($search) . '%')
                                    ->where(['status' => 'PENDING'])
                                    ->where(['location_from' => 'Faculty'])
                                     ->where(['location_to' => 'Program Chair'])
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(5);
        }
        else {
        $proposals = Research::where(['status' => 'PENDING'])
                             ->where(['location_from' => 'Faculty'])
                             ->where(['location_to' => 'Program Chair'])
                             ->orderBy('created_at', 'desc')       
                             ->paginate(5);
        }
        return view('programchair.pending_dashboard', [
            'user' => $user,
            'proposals' => $proposals,
            'active' => "pcpending",
            'search' => $search
        ]);
       }

       public function revisionDashboard(){
        $user = auth()->user();
        $search = request()->query('search');
        if ($search) {
            $proposals = Research::where('title', 'LIKE', '%' . ($search) . '%')
                                    ->where('status', 'Program Chair')   
                                    ->where('location_from','Program Chair')   
                                    ->where('location_to','Faculty')                           
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(5);
        }
        else {
        $proposals = Research::where(['status' => 'Program Chair'])   
                             ->where('location_from','Program Chair')   
                             ->where('location_to','Faculty')  
                             ->orderBy('created_at', 'desc')       
                             ->paginate(5);
        }
        return view('programchair.revision_dashboard', [
            'user' => $user,
            'proposals' => $proposals,
            'active' => "pcrevision",
            'search' => $search
        ]);
       }
       
       public function rbpDashboard(){
        $user = auth()->user();
        $search = request()->query('search');
        if ($search) {
            $proposals = Research::where('title', 'LIKE', '%' . ($search) . '%')
                                    ->orWhere(['status' => 'PENDING'])
                                    ->where('location_from',['Dean','Chancellor','Program Chair'])
                                    ->where('location_to',['Dean', 'Chancellor', 'RMO'])
                                    ->orWhere(['status' => 'APPROVED'])
                                    ->where(['deliverables' => 'Research Based Paper'])
                                    ->orWhere('date_completed', 'LIKE', "%{$search}%")
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(5);
        }
        else {
            $proposals = Research::where(['deliverables' => 'Research Based Paper'])
                            ->where('location_to',['Dean', 'Chancellor', 'RMO'])
                            //->where('location_from',['Dean','Chancellor','Program Chair'])
                           // ->orWhere(['status' => 'APPROVED'])
                           // ->orWhere(['location_from' => 'Faculty'])
                         //   ->orWhere(['status' => 'PENDING'])
                             ->orderBy('created_at', 'desc')       
                             ->paginate(5);
        }
        return view('programchair.rbp_dashboard', [
            'user' => $user,
            'proposals' => $proposals,
            'search' => $search,
            'active' => "pcrbp",
        ]);
    }

    public function viewResearch($id)
        {
            $members = DB::table('research_members')->select('fullname')
                        ->where('proposal_id',$id)->get();
            $user = auth()->user();
            $paperpublisheds = PaperPublished::where('proposal_id', $id)
                            ->whereIn('status',['APPROVED','Approved by the Program Chair', 'Approved by the Dean', 'Approved by the Chancellor'])->get();
            $bookciteds = BookCited::where('proposal_id',$id)
                            ->whereIn('status',['APPROVED','Approved by the Program Chair', 'Approved by the Dean', 'Approved by the Chancellor'])->get();
            $journalciteds = JournalCited::where('proposal_id',$id)
                             ->whereNotIn('status',['APPROVED','Approved by the Program Chair', 'Approved by the Dean', 'Approved by the Chancellor'])->get();
            $proposal = Research::where('id',$id)->first();
            $paperpresenteds = PaperPresented::where('proposal_id',$id)
                             ->whereIn('status',['APPROVED','Approved by the Program Chair', 'Approved by the Dean', 'Approved by the Chancellor'])->get();
            $utilizeds = Utilized::where('proposal_id',$id)
                            ->whereIn('status',['APPROVED','Approved by the Program Chair', 'Approved by the Dean', 'Approved by the Chancellor'])->get();
            $patenteds = Patented::where('proposal_id', $id)
                             ->whereIn('status',['APPROVED','Approved by the Program Chair', 'Approved by the Dean', 'Approved by the Chancellor'])->get();
            $req = SucRequirement::where('research_id',$id)->first();
          
            return view('programchair.view_rbp',[
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
                'active' => "pcpending",


            ]);
            
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
          
            return view('programchair.view_revision',[
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
                'active' => "pcpending",


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
          
            return view('programchair.validate_rbp',[
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
                'active' => "pcpending",


            ]);
            
        }

        public function approveResearchProgramChair($id)
        {
            $research = Research::where('id',$id)->first();
         
            $research->update([
                'location_from' => 'Program Chair',
                'location_to' => 'Dean',
                'station' => '2',
            ]);
            return redirect()->route('programchair-pending',$id)->with('success', 'Research has been submitted.');
        }

        public function rejectResearchProgramChair(Request $request,$id)
        {
            
            $research = Research::where('id',$id)->first();
            $research->update([
                'status' => 'Program Chair',
                'location_from' => 'Program Chair',
                'location_to' => 'Faculty',
                'remarks' => $request->remarks,
            ]);
            return redirect()->route('programchair-pending',$id)->with('alert', 'Research has been rejected.');
        }

        public function viewPending($id)
        {
            $members = DB::table('research_members')->select('fullname')
                        ->where('proposal_id',$id)->get();
            $user = auth()->user();
            $paperpublisheds = PaperPublished::where('proposal_id', $id)
                            ->whereNotIn('status',['APPROVED','RMO','Program Chair', 'Dean', 'Chancellor'])->get();
            $bookciteds = BookCited::where('proposal_id',$id)
                            ->whereNotIn('status',['APPROVED','RMO','Program Chair', 'Dean', 'Chancellor'])->get();
            $journalciteds = JournalCited::where('proposal_id',$id)
                             ->whereNotIn('status',['APPROVED','RMO','Program Chair', 'Dean', 'Chancellor'])->get();
            $proposal = Research::where('id',$id)->first();
            $paperpresenteds = PaperPresented::where('proposal_id',$id)
                             ->whereNotIn('status',['APPROVED','RMO','Program Chair', 'Dean', 'Chancellor'])->get();
            $utilizeds = Utilized::where('proposal_id',$id)
                            ->whereNotIn('status',['APPROVED','RMO','Program Chair', 'Dean', 'Chancellor'])->get();
            $patenteds = Patented::where('proposal_id', $id)
                             ->whereNotIn('status',['APPROVED','RMO','Program Chair', 'Dean', 'Chancellor'])->get();
            $req = SucRequirement::where('research_id',$id)->first();
          
            return view('programchair.view_pending',[
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
                'active' => "pcpending",


            ]);
            
        }
        public function viewPaperPublished($id)
        {
            
            $user = auth()->user();
            $paperpublisheds = PaperPublished::where('id',$id)->first();

            return view('programchair.view_paperpublished',[
                'user' => $user,
                'active' => "pcpending",
                'paperpublisheds' => $paperpublisheds,
            ]);
            
        }

        public function viewPaperPresented($id)
        {
            
            $user = auth()->user();
            $paperpresenteds = PaperPresented::where('id',$id)->first();

            return view('programchair.view_paperpresented',[
                'user' => $user,
                'active' => "pcpending",
                'paperpresenteds' => $paperpresenteds,
            ]);
            
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
                'location_from' => $request->location_from,
                'location_to' => 'Faculty',
                'station' => '0',
            ]);

            return back()->with('alert', 'The research goes back to Faculty.');
        }

        
}
