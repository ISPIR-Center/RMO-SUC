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

class DeanController extends Controller
{
    public function pendingDashboard(){
        $user = auth()->user();
        $search = request()->query('search');
        if ($search) {
            $proposals = Research::where('title', 'LIKE', '%' . ($search) . '%')
                                    ->where(['status' => 'PENDING'])
                                    ->where(['location_from' => 'Program Chair'])
                                     ->where(['location_to' => 'Dean'])
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(5);
        }
        else {
        $proposals = Research::where(['status' => 'PENDING'])
                             ->where(['location_from' => 'Program Chair'])
                             ->where(['location_to' => 'Dean'])
                             ->orderBy('created_at', 'desc')       
                             ->paginate(5);
        }
        return view('dean.pending_dashboard', [
            'user' => $user,
            'proposals' => $proposals,
            'active' => "deanpending",
            'search' => $search
        ]);
       }

       public function revisionDashboard(){
        $user = auth()->user();
        $search = request()->query('search');
        if ($search) {
            $proposals = Research::where('title', 'LIKE', '%' . ($search) . '%')
                                    ->whereNotIn('status',['PENDING', 'APPROVED'])   
                                    ->whereNotIn('location_from',['Faculty', 'Program Chair','RMO'])   
                                    ->whereNotIn('location_to',['Chancellor', 'RMO'])                           
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(5);
        }
        else {
        $proposals = Research::whereNotIn('status',['PENDING', 'APPROVED'])   
                             ->whereNotIn('location_from',['Faculty', 'Program Chair','RMO'])   
                             ->whereNotIn('location_to',['Chancellor', 'RMO'])   
                             ->orderBy('created_at', 'desc')       
                             ->paginate(5);
        }
        return view('dean.revision_dashboard', [
            'user' => $user,
            'proposals' => $proposals,
            'active' => "deanrevision",
            'search' => $search
        ]);
       }
       
       public function rbpDashboard(){
        $user = auth()->user();
        $search = request()->query('search');
        if ($search) {
            $proposals = Research::where('title', 'LIKE', '%' . ($search) . '%')
                                    // ->orWhere(['status' => 'PENDING'])
                                    ->where('location_to',[ 'Chancellor', 'RMO'])
                                    // ->whereIn('location_from',['Dean','Chancellor'])
                                    // ->orWhere(['status' => 'APPROVED'])
                                    ->where(['deliverables' => 'Research Based Paper'])
                                    ->orWhere('date_completed', 'LIKE', "%{$search}%")
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(5);
        }
        else {
            $proposals = Research::where(['deliverables' => 'Research Based Paper'])
                            ->where('location_to',['Chancellor', 'RMO'])
                            // ->whereIn('location_from',['Dean','Chancellor'])
                            // ->orWhere(['status' => 'APPROVED'])
                            //  ->orWhere(['status' => 'PENDING'])
                             ->orderBy('created_at', 'desc')       
                             ->paginate(5);
        }
        return view('dean.rbp_dashboard', [
            'user' => $user,
            'proposals' => $proposals,
            'search' => $search,
            'active' => "deanrbp",
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
                                            ->whereIn('status',['APPROVED','Approved by the Program Chair', 'Approved by the Dean', 'Approved by the Chancellor'])->get();
            $proposal = Research::where('id',$id)->first();
            $paperpresenteds = PaperPresented::where('proposal_id',$id)
                                            ->whereIn('status',['APPROVED','Approved by the Program Chair', 'Approved by the Dean', 'Approved by the Chancellor'])->get();
            $utilizeds = Utilized::where('proposal_id',$id)
                                            ->whereIn('status',['APPROVED','Approved by the Program Chair', 'Approved by the Dean', 'Approved by the Chancellor'])->get();
            $patenteds = Patented::where('proposal_id', $id)
                                            ->whereIn('status',['APPROVED','Approved by the Program Chair', 'Approved by the Dean', 'Approved by the Chancellor'])->get();
            $req = SucRequirement::where('research_id',$id)->first();
          
            return view('dean.view_rbp',[
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
                'active' => "deanpending",


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
          
            return view('dean.view_revision',[
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
                'active' => "deanpending",


            ]);
            
        }

        public function validateResearch($id)
        {
            $members = DB::table('research_members')->select('fullname')
                        ->where('proposal_id',$id)->get();
            $user = auth()->user();
            $paperpublisheds = PaperPublished::where('proposal_id', $id)
                            ->where(['status' =>'Approved by the Program Chair'])->get();
            $bookciteds = BookCited::where('proposal_id',$id)
                            ->where(['status' =>'Approved by the Program Chair'])->get();
            $journalciteds = JournalCited::where('proposal_id',$id)
                             ->where(['status' =>'Approved by the Program Chair'])->get();
            $proposal = Research::where('id',$id)->first();
            $paperpresenteds = PaperPresented::where('proposal_id',$id)
                             ->where(['status' =>'Approved by the Program Chair'])->get();
            $utilizeds = Utilized::where('proposal_id',$id)
                             ->where(['status' =>'Approved by the Program Chair'])->get();
            $patenteds = Patented::where('proposal_id', $id)
                             ->where(['status' =>'Approved by the Program Chair'])->get();
            $req = SucRequirement::where('research_id',$id)->first();
          
            return view('dean.validate_rbp',[
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
                'active' => "deanpending",


            ]);
            
        }

        public function approveResearchDean($id)
        {
            $research = Research::where('id',$id)->first();
         
            $research->update([
                'location_from' => 'Dean',
                'location_to' => 'Chancellor',
                'station' => '3',
            ]);
            return redirect()->route('dean-pending',$id)->with('success', 'Research has been submitted.');
        }

        public function rejectResearchDean(Request $request,$id)
        {
            
            $research = Research::where('id',$id)->first();
            $research->update([
                'status' => 'Dean',
                'location_from' => 'Dean',
                'location_to' => 'Program Chair',
                'station'=> '2',
                'remarks' => $request->remarks,
            ]);
            return redirect()->route('dean-pending',$id)->with('alert', 'Research has been rejected.');
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
          
            return view('dean.view_pending',[
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
                'active' => "deanpending",


            ]);
            
        }
        public function viewPaperPublished($id)
        {
            
            $user = auth()->user();
            $paperpublisheds = PaperPublished::where('id',$id)->first();

            return view('dean.view_paperpublished',[
                'user' => $user,
                'active' => "deanpending",
                'paperpublisheds' => $paperpublisheds,
            ]);
            
        }

        public function viewPaperPresented($id)
        {
            
            $user = auth()->user();
            $paperpresenteds = PaperPresented::where('id',$id)->first();

            return view('dean.view_paperpresented',[
                'user' => $user,
                'active' => "deanpending",
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
                'location_from' => 'Dean',
                'location_to' => 'Program Chair',
                'station' => '1',
            ]);

            return back()->with('alert', 'The research has been rejected.');
        }

        
}

