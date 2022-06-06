<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\ProgramChairController;
use App\Http\Controllers\DeanController;
use App\Http\Controllers\ChancellorController;
use App\Http\Controllers\RMOController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

#Auth
Route::get('/register', [AuthController::class, 'registerPage' ])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'registerUser' ]);
Route::get('/login', [AuthController::class, 'loginPage'])->name('login')->middleware('guest');
Route::get('/', [AuthController::class, 'loginPage'])->name('login')->middleware('guest');
Route::post('/', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/faculty/change-password', [AuthController::class, 'facultyview'])->name('faculty-change')->middleware(['auth','faculty']); 
Route::post('/faculty/change-password', [AuthController::class, 'changepw']);
Route::get('/faculty/profile/edit/{faculty}',[FacultyController::class, 'editProfile'])->name('faculty-edit-profile')->middleware(['auth','faculty']);
Route::put('/faculty/profile/edit/{faculty}',[FacultyController::class, 'updateProfile']);
Route::get('/faculty/profile/view/{faculty}',[FacultyController::class, 'viewProfile'])->name('faculty-view-profile')->middleware(['auth','faculty']);
Route::post('/faculty/profile/view/{faculty}',[FacultyController::class, 'addAward']);

Route::get('/rmo/change-password', [AuthController::class, 'viewRmo'])->name('rmo-change')->middleware(['auth','rmo']); 
Route::post('/rmo/change-password', [AuthController::class, 'changepwRmo']);

Route::get('/dean/change-password', [AuthController::class, 'viewDean'])->name('dean-change')->middleware(['auth','dean']); 
Route::post('/dean/change-password', [AuthController::class, 'changepwDean']);

Route::get('/programchair/change-password', [AuthController::class, 'viewPc'])->name('programchair-change')->middleware(['auth','programchair']); 
Route::post('/programchair/change-password', [AuthController::class, 'changepwPc']);

Route::get('/chancellor/change-password', [AuthController::class, 'viewChancellor'])->name('chancellor-change')->middleware(['auth','chancellor']); 
Route::post('/chancellor/change-password', [AuthController::class, 'changepwChancellor']);


###RBP DASHBOARD################
Route::get('/faculty/rbp', [FacultyController::class, 'rbpDashboard'])->name('faculty-rbp')->middleware(['auth','faculty']);
Route::get('/faculty/rbp/create', [FacultyController::class, 'createRBP'])->name('faculty-rbp-create')->middleware(['auth','faculty']);
Route::post('/faculty/rbp/create', [FacultyController::class, 'storeRBP']);
Route::get('/faculty/rbp/{rbp}/add-members', [FacultyController::class, 'viewResearchAddMembers'])->name('faculty-rbp-addmembers')->middleware(['auth','faculty']);
Route::post('/faculty/rbp/{proposal}/add-members/{faculty}', [FacultyController::class, 'addMember'])->name('faculty-addmember');
Route::delete('/faculty/rbp/{rbp}/{member}', [FacultyController::class, 'deleteResearchMember'])->name('faculty-rbp-deletemember');
Route::get('/faculty/rbp/view/{rbp}',[FacultyController::class, 'viewResearch'])->name('faculty-rbp-view')->middleware(['auth','faculty']);
Route::get('/faculty/rbp/view/pending/{rbp}',[FacultyController::class, 'viewPending'])->name('faculty-pending-view')->middleware(['auth','faculty']);
Route::get('/faculty/rbp/view/revision/{rbp}',[FacultyController::class, 'viewRevision'])->name('faculty-revision-view')->middleware(['auth','faculty']);
Route::get('/faculty/rbp/{proposal}/upload', [FacultyController::class, 'uploadFile'])->name('faculty-rbp-upload')->middleware(['auth','faculty']);
Route::post('/faculty/rbp/{proposal}/upload', [FacultyController::class, 'storeFile']);
Route::get('/faculty/rbp/edit/{researches}', [FacultyController::class, 'editResearch'])->name('faculty-rbp-edit')->middleware(['auth','faculty']);
Route::put('/faculty/rbp/edit/{researches}', [FacultyController::class, 'updateResearch']);
Route::post('/faculty/rbp/delete/{researches}', [FacultyController::class, 'deleteRBP'])->name('faculty-rbp-delete');
Route::get('/faculty/rbp/view/{researches}',[FacultyController::class, 'viewResearch'])->name('faculty-rbp-view')->middleware(['auth','faculty']);
Route::post('/faculty/rbp/view/{researches}',[FacultyController::class, 'storeUtilized']);
Route::put('/faculty/rbp/view/{researches}',[FacultyController::class, 'updatePatented']);
Route::put('/faculty/utilized/update/{researches}',[FacultyController::class, 'updateUtilized'])->name('faculty-utilized-update');
Route::post('/faculty/utilized/delete/{researches}',[FacultyController::class, 'deleteUtilized'])->name('faculty-utilized-delete');
Route::post('/faculty/published/delete/{researches}',[FacultyController::class, 'deletePublished'])->name('faculty-published-delete');
Route::post('/faculty/presented/delete/{researches}',[FacultyController::class, 'deletePresented'])->name('faculty-presented-delete');
Route::post('/faculty/journalcited/delete/{researches}',[FacultyController::class, 'deleteJournalCited'])->name('faculty-journalcited-delete');
Route::post('/faculty/bookcited/delete/{researches}',[FacultyController::class, 'deleteBookCited'])->name('faculty-bookcited-delete');
Route::post('/faculty/patented/delete/{researches}',[FacultyController::class, 'deletePatented'])->name('faculty-patented-delete');


###PENDING################
Route::get('/faculty/pending', [FacultyController::class, 'pendingDashboard'])->name('faculty-pending')->middleware(['auth','faculty']);
Route::get('/faculty/pending/edit/{researches}', [FacultyController::class, 'editPending'])->name('faculty-pending-edit')->middleware(['auth','faculty']);
Route::put('/faculty/pending/edit/{researches}', [FacultyController::class, 'updatePending']); 


#####FOR REVISION########
Route::get('/faculty/revision', [FacultyController::class, 'revisionDashboard'])->name('faculty-revision')->middleware(['auth','faculty']);

######PAPER PUBLISHED############
Route::get('/faculty/paper-published/create/{researches}', [FacultyController::class, 'createPaperPublished'])->name('faculty-paperpublished-create')->middleware(['auth','faculty']);
Route::post('/faculty/paper-published/create/{researches}/', [FacultyController::class, 'storePaperPublished']);
Route::get('/faculty/paper-published/edit/{researches}/{published}', [FacultyController::class, 'editPaperPublished'])->name('faculty-paperpublished-edit')->middleware(['auth','faculty']);
Route::put('/faculty/paper-published/edit/{researches}/{published}', [FacultyController::class, 'updatePaperPublished']);
Route::get('/faculty/paper-published/view/{researches}',[FacultyController::class, 'viewPaperPublished'])->name('faculty-paperpublished-view')->middleware(['auth','faculty']);



######JOURNAL CITED#############
Route::get('/faculty/journal-cited/create/{researches}', [FacultyController::class, 'createJournalCited'])->name('faculty-journalcited-create')->middleware(['auth','faculty']);
Route::post('/faculty/journal-cited/create/{researches}', [FacultyController::class, 'storeJournalCited']);
Route::get('/faculty/journal-cited/edit/{researches}/{journalcited}', [FacultyController::class, 'editJournalCited'])->name('faculty-journalcited-edit')->middleware(['auth','faculty']);
Route::put('/faculty/journal-cited/edit/{researches}/{journalcited}', [FacultyController::class, 'updateJournalCited']);
Route::get('/faculty/journal-cited/view/{researches}',[FacultyController::class, 'viewJournalCited'])->name('faculty-journalcited-view')->middleware(['auth','faculty']);



#####BOOK CITED#############
Route::get('/faculty/book-cited/create/{researches}', [FacultyController::class, 'createBookCited'])->name('faculty-bookcited-create')->middleware(['auth','faculty']);
Route::post('/faculty/book-cited/create/{researches}', [FacultyController::class, 'storeBookCited']);
Route::get('/faculty/book-cited/edit/{researches}/{bookcited}', [FacultyController::class, 'editBookCited'])->name('faculty-bookcited-edit')->middleware(['auth','faculty']);
Route::put('/faculty/book-cited/edit/{researches}/{bookcited}', [FacultyController::class, 'updateBookCited']);
Route::get('/faculty/book-cited/view/{researches}',[FacultyController::class, 'viewBookCited'])->name('faculty-bookcited-view')->middleware(['auth','faculty']);



#####PAPER PRESENTED#############
Route::get('/faculty/paper-presented/create/{researches}', [FacultyController::class, 'createPaperPresented'])->name('faculty-paperpresented-create')->middleware(['auth','faculty']);
Route::post('/faculty/paper-presented/create/{researches}', [FacultyController::class, 'storePaperPresented']);
Route::get('/faculty/paper-presented/edit/{researches}/{presented}', [FacultyController::class, 'editPaperPresented'])->name('faculty-paperpresented-edit')->middleware(['auth','faculty']);
Route::put('/faculty/paper-presented/edit/{researches}/{presented}', [FacultyController::class, 'updatePaperPresented']);
Route::get('/faculty/paper-presented/view/{researches}',[FacultyController::class, 'viewPaperPresented'])->name('faculty-paperpresented-view')->middleware(['auth','faculty']);



##### INVENTION ###########
Route::get('/faculty/invention', [FacultyController::class, 'inventionDashboard'])->name('faculty-invention')->middleware(['auth','faculty']);
Route::get('/faculty/invention/create', [FacultyController::class, 'createInvention'])->name('faculty-invention-create')->middleware(['auth','faculty']);
Route::post('/faculty/invention/create', [FacultyController::class, 'storeInvention']);
Route::get('/faculty/invention/{invention}/add-members', [FacultyController::class, 'viewInventionAddMembers'])->name('faculty-invention-addmembers')->middleware(['auth','faculty']);
Route::post('/faculty/invention/{proposal}/add-members/{faculty}', [FacultyController::class, 'addMemberInvention'])->name('faculty-addmember');
Route::delete('/faculty/invention/{invention}/{member}', [FacultyController::class, 'deleteResearchMember'])->name('faculty-invention-deletemember');
Route::get('/faculty/invention/view/{invention}',[FacultyController::class, 'viewInvention'])->name('faculty-invention-view')->middleware(['auth','faculty']);
Route::get('/faculty/invention/edit/{researches}', [FacultyController::class, 'editInvention'])->name('faculty-invention-edit')->middleware(['auth','faculty']);
Route::put('/faculty/invention/edit/{researches}', [FacultyController::class, 'updateInvention']);




#####PATENTED#############
Route::get('/faculty/patented/create/{researches}', [FacultyController::class, 'createPatented'])->name('faculty-patented-create')->middleware(['auth','faculty']);
Route::post('/faculty/patented/create/{researches}', [FacultyController::class, 'storePatented']);
Route::get('/faculty/patented/edit/{researches}', [FacultyController::class, 'editPatented'])->name('faculty-patented-edit')->middleware(['auth','faculty']);
Route::put('/faculty/patented/edit/{researches}', [FacultyController::class, 'updatePatented']);
Route::get('/faculty/patented/view/{researches}',[FacultyController::class, 'viewPatented'])->name('faculty-patented-view')->middleware(['auth','faculty']);



#####UTILIZED#############
Route::get('/faculty/utilized/create/{researches}', [FacultyController::class, 'createUtilized'])->name('faculty-utilized-create')->middleware(['auth','faculty']);
Route::post('/faculty/utilized/create/{researches}', [FacultyController::class, 'storeUtilized']);
Route::get('/faculty/utilized/edit/{researches}', [FacultyController::class, 'editUtilized'])->name('faculty-utilized-edit')->middleware(['auth','faculty']);
Route::put('/faculty/utilized/edit/{researches}', [FacultyController::class, 'updateUtilized']);
Route::get('/faculty/utilized/view/{researches}',[FacultyController::class, 'viewUtilized'])->name('faculty-utilized-view')->middleware(['auth','faculty']);







################################################# P R O G R A M  C H A I R #####################################################

###RBP DASHBOARD################
Route::get('/programchair/rbp', [ProgramChairController::class, 'rbpDashboard'])->name('programchair-rbp')->middleware(['auth','programchair']);
Route::get('/programchair/rbp/view/{rbp}',[ProgramChairController::class, 'viewResearch'])->name('programchair-rbp-view')->middleware(['auth','programchair']);

###PENDING################
Route::get('/programchair/pending', [ProgramChairController::class, 'pendingDashboard'])->name('programchair-pending')->middleware(['auth','programchair']);
Route::get('/programchair/pending/edit/{researches}', [ProgramChairController::class, 'editPending'])->name('programchair-pending-edit')->middleware(['auth','programchair']);
Route::put('/programchair/pending/edit/{researches}', [ProgramChairController::class, 'updatePending']); 
Route::get('/programchair/pending/view/{rbp}',[ProgramChairController::class, 'viewPending'])->name('programchair-pending-view')->middleware(['auth','programchair']);
Route::get('/programchair/pending/validate/{rbp}',[ProgramChairController::class, 'validateResearch'])->name('programchair-rbp-validate')->middleware(['auth','programchair']);
Route::put('/programchair/pending/approve/{rbp}',[ProgramChairController::class, 'approveResearchProgramChair'])->name('programchair-rbp-approve');
Route::put('/programchair/pending/validate/{rbp}',[ProgramChairController::class, 'rejectResearchProgramChair'])->name('programchair-rbp-reject');

#####FOR REVISION########
Route::get('/programchair/revision', [ProgramChairController::class, 'revisionDashboard'])->name('programchair-revision')->middleware(['auth','programchair']);
Route::put('/programchair/submit/revision/{rbp}', [ProgramChairController::class, 'submitForRevision'])->name('programchair-submit-revision');
Route::get('/programchair/revision/view/{rbp}',[ProgramChairController::class, 'viewRevision'])->name('programchair-revision-view')->middleware(['auth','programchair']);

######PAPER PUBLISHED############
Route::get('/programchair/paper-published/view/{paperpublished}/{researches}',[ProgramChairController::class, 'viewPaperPublished'])->name('programchair-paperpublished-view')->middleware(['auth','programchair']);
Route::put('/programchair/paper-published/approve/{researches}',[ProgramChairController::class, 'approvePaperPublished'])->name('programchair-paperpublished-approve');
Route::patch('/programchair/paper-published/reject/{researches}',[ProgramChairController::class, 'rejectPaperPublished'])->name('programchair-paperpublished-reject');

#####PAPER PRESENTED#############
Route::get('/programchair/paper-presented/view/{paperpresented}/{researches}',[ProgramChairController::class, 'viewPaperPresented'])->name('programchair-paperpresented-view')->middleware(['auth','programchair']);
Route::put('/programchair/paper-presented/approve/{researches}',[ProgramChairController::class, 'approvePaperPresented'])->name('programchair-paperpresented-approve');
Route::patch('/programchair/paper-presented/reject/{researches}',[ProgramChairController::class, 'rejectPaperPresented'])->name('programchair-paperpresented-reject');
#####JOURNAL CITED#############
Route::get('/programchair/journal-cited/view/{researches}',[ProgramChairController::class, 'viewJournalCited'])->name('programchair-journalcited-view')->middleware(['auth','programchair']);
Route::put('/programchair/journal-cited/approve/{researches}',[ProgramChairController::class, 'approveJournalCited'])->name('programchair-journalcited-approve');
Route::patch('/programchair/journal-cited/reject/{researches}',[ProgramChairController::class, 'rejectJournalCited'])->name('programchair-journalcited-reject');
#####BOOK CITED#############
Route::get('/programchair/book-cited/view/{researches}',[ProgramChairController::class, 'viewBookCited'])->name('programchair-bookcited-view')->middleware(['auth','programchair']);
Route::put('/programchair/book-cited/approve/{researches}',[ProgramChairController::class, 'approveBookCited'])->name('programchair-bookcited-approve');
Route::patch('/programchair/book-cited/reject/{researches}',[ProgramChairController::class, 'rejectBookCited'])->name('programchair-bookcited-reject');
#####PATENTED #############
Route::get('/programchair/patented/view/{researches}',[ProgramChairController::class, 'viewPatented'])->name('programchair-patented-view')->middleware(['auth','programchair']);
Route::put('/programchair/patented/approve/{researches}',[ProgramChairController::class, 'approvePatented'])->name('programchair-patented-approve');
Route::patch('/programchair/patented/reject/{researches}',[ProgramChairController::class, 'rejectPatented'])->name('programchair-patented-reject');
#####UTILIZED#############
Route::get('/programchair/utilized/view/{researches}',[ProgramChairController::class, 'viewUtilized'])->name('programchair-utilized-view')->middleware(['auth','programchair']);
Route::put('/programchair/utilized/approve/{researches}',[ProgramChairController::class, 'approveUtilized'])->name('programchair-utilized-approve');
Route::patch('/programchair/utilized/reject/{researches}',[ProgramChairController::class, 'rejectUtilized'])->name('programchair-utilized-reject');






############################################## D            E             A              N ################################################
###RBP DASHBOARD################
Route::get('/dean/rbp', [DeanController::class, 'rbpDashboard'])->name('dean-rbp')->middleware(['auth','dean']);
Route::get('/dean/rbp/view/{rbp}',[DeanController::class, 'viewResearch'])->name('dean-rbp-view')->middleware(['auth','dean']);

###PENDING################
Route::get('/dean/pending', [DeanController::class, 'pendingDashboard'])->name('dean-pending')->middleware(['auth','dean']);
Route::get('/dean/pending/edit/{researches}', [DeanController::class, 'editPending'])->name('dean-pending-edit')->middleware(['auth','dean']);
Route::put('/dean/pending/edit/{researches}', [DeanController::class, 'updatePending']); 
Route::get('/dean/pending/view/{rbp}',[DeanController::class, 'viewPending'])->name('dean-pending-view')->middleware(['auth','dean']);
Route::get('/dean/pending/validate/{rbp}',[DeanController::class, 'validateResearch'])->name('dean-rbp-validate')->middleware(['auth','dean']);
Route::put('/dean/pending/approve/{rbp}',[DeanController::class, 'approveResearchDean'])->name('dean-rbp-approve');
Route::put('/dean/pending/validate/{rbp}',[DeanController::class, 'rejectResearchDean'])->name('dean-rbp-reject');

#####FOR REVISION########
Route::get('/dean/revision', [DeanController::class, 'revisionDashboard'])->name('dean-revision')->middleware(['auth','dean']);
Route::put('/dean/submit/revision/{rbp}', [DeanController::class, 'submitForRevision'])->name('dean-submit-revision');


######PAPER PUBLISHED############
Route::get('/dean/paper-published/view/{paperpresented}/{researches}',[DeanController::class, 'viewPaperPublished'])->name('dean-paperpublished-view')->middleware(['auth','dean']);
Route::put('/dean/paper-published/approve/{researches}',[DeanController::class, 'approvePaperPublished'])->name('dean-paperpublished-approve');
Route::patch('/dean/paper-published/reject/{researches}',[DeanController::class, 'rejectPaperPublished'])->name('dean-paperpublished-reject');

#####PAPER PRESENTED#############
Route::get('/dean/paper-presented/view/{paperpublished}/{researches}',[DeanController::class, 'viewPaperPresented'])->name('dean-paperpresented-view')->middleware(['auth','dean']);
Route::put('/dean/paper-presented/approve/{researches}',[DeanController::class, 'approvePaperPresented'])->name('dean-paperpresented-approve');
Route::patch('/dean/paper-presented/reject/{researches}',[DeanController::class, 'rejectPaperPresented'])->name('dean-paperpresented-reject');
#####JOURNAL CITED#############
Route::get('/dean/journal-cited/view/{researches}',[DeanController::class, 'viewJournalCited'])->name('dean-journalcited-view')->middleware(['auth','dean']);
Route::put('/dean/journal-cited/approve/{researches}',[DeanController::class, 'approveJournalCited'])->name('dean-journalcited-approve');
Route::patch('/dean/journal-cited/reject/{researches}',[DeanController::class, 'rejectJournalCited'])->name('dean-journalcited-reject');
#####BOOK CITED#############
Route::get('/dean/book-cited/view/{researches}',[DeanController::class, 'viewBookCited'])->name('dean-bookcited-view')->middleware(['auth','dean']);
Route::put('/dean/book-cited/approve/{researches}',[DeanController::class, 'approveBookCited'])->name('dean-bookcited-approve');
Route::patch('/dean/book-cited/reject/{researches}',[DeanController::class, 'rejectBookCited'])->name('dean-bookcited-reject');
#####PATENTED #############
Route::get('/dean/patented/view/{researches}',[DeanController::class, 'viewPatented'])->name('dean-patented-view')->middleware(['auth','dean']);
Route::put('/dean/patented/approve/{researches}',[DeanController::class, 'approvePatented'])->name('dean-patented-approve');
Route::patch('/dean/patented/reject/{researches}',[DeanController::class, 'rejectPatented'])->name('dean-patented-reject');
#####UTILIZED#############
Route::get('/dean/utilized/view/{researches}',[DeanController::class, 'viewUtilized'])->name('dean-utilized-view');
Route::put('/dean/utilized/approve/{researches}',[DeanController::class, 'approveUtilized'])->name('dean-utilized-approve')->middleware(['auth','dean']);
Route::patch('/dean/utilized/reject/{researches}',[DeanController::class, 'rejectUtilized'])->name('dean-utilized-reject');







##############################################C   H   A   N  C   E   L    L   O    R################################################
###RBP DASHBOARD################
Route::get('/chancellor/rbp', [ChancellorController::class, 'rbpDashboard'])->name('chancellor-rbp')->middleware(['auth','chancellor']);
Route::get('/chancellor/rbp/view/{rbp}',[ChancellorController::class, 'viewResearch'])->name('chancellor-rbp-view')->middleware(['auth','chancellor']);

###PENDING################
Route::get('/chancellor/pending', [ChancellorController::class, 'pendingDashboard'])->name('chancellor-pending')->middleware(['auth','chancellor']);
Route::get('/chancellor/pending/edit/{researches}', [ChancellorController::class, 'editPending'])->name('chancellor-pending-edit')->middleware(['auth','chancellor']);
Route::put('/chancellor/pending/edit/{researches}', [ChancellorController::class, 'updatePending']); 
Route::get('/chancellor/pending/view/{rbp}',[ChancellorController::class, 'viewPending'])->name('chancellor-pending-view')->middleware(['auth','chancellor']);
Route::get('/chancellor/pending/validate/{rbp}',[ChancellorController::class, 'validateResearch'])->name('chancellor-rbp-validate')->middleware(['auth','chancellor']);
Route::put('/chancellor/pending/approve/{rbp}',[ChancellorController::class, 'approveResearchChancellor'])->name('chancellor-rbp-approve');
Route::put('/chancellor/pending/validate/{rbp}',[ChancellorController::class, 'rejectResearchChancellor'])->name('chancellor-rbp-reject');

#####FOR REVISION########
Route::get('/chancellor/revision', [ChancellorController::class, 'revisionDashboard'])->name('chancellor-revision')->middleware(['auth','chancellor']);
Route::put('/chancellor/submit/revision/{rbp}', [ChancellorController::class, 'submitForRevision'])->name('chancellor-submit-revision');


######PAPER PUBLISHED############
Route::get('/chancellor/paper-published/view/{paperpresented}/{researches}',[ChancellorController::class, 'viewPaperPublished'])->name('chancellor-paperpublished-view');
Route::put('/chancellor/paper-published/approve/{researches}',[ChancellorController::class, 'approvePaperPublished'])->name('chancellor-paperpublished-approve');
Route::patch('/chancellor/paper-published/reject/{researches}',[ChancellorController::class, 'rejectPaperPublished'])->name('chancellor-paperpublished-reject');

#####PAPER PRESENTED#############
Route::get('/chancellor/paper-presented/view/{paperpublished}/{researches}',[ChancellorController::class, 'viewPaperPresented'])->name('chancellor-paperpresented-view')->middleware(['auth','chancellor']);
Route::put('/chancellor/paper-presented/approve/{researches}',[ChancellorController::class, 'approvePaperPresented'])->name('chancellor-paperpresented-approve');
Route::patch('/chancellor/paper-presented/reject/{researches}',[ChancellorController::class, 'rejectPaperPresented'])->name('chancellor-paperpresented-reject');

#####JOURNAL CITED#############
Route::get('/chancellor/journal-cited/view/{researches}',[ChancellorController::class, 'viewJournalCited'])->name('chancellor-journalcited-view')->middleware(['auth','chancellor']);
Route::put('/chancellor/journal-cited/approve/{researches}',[ChancellorController::class, 'approveJournalCited'])->name('chancellor-journalcited-approve');
Route::patch('/chancellor/journal-cited/reject/{researches}',[ChancellorController::class, 'rejectJournalCited'])->name('chancellor-journalcited-reject');

#####BOOK CITED#############
Route::get('/chancellor/book-cited/view/{researches}',[ChancellorController::class, 'viewBookCited'])->name('chancellor-bookcited-view')->middleware(['auth','chancellor']);
Route::put('/chancellor/book-cited/approve/{researches}',[ChancellorController::class, 'approveBookCited'])->name('chancellor-bookcited-approve');
Route::patch('/chancellor/book-cited/reject/{researches}',[ChancellorController::class, 'rejectBookCited'])->name('chancellor-bookcited-reject');

#####PATENTED #############
Route::get('/chancellor/patented/view/{researches}',[ChancellorController::class, 'viewPatented'])->name('chancellor-patented-view')->middleware(['auth','chancellor']);
Route::put('/chancellor/patented/approve/{researches}',[ChancellorController::class, 'approvePatented'])->name('chancellor-patented-approve');
Route::patch('/chancellor/patented/reject/{researches}',[ChancellorController::class, 'rejectPatented'])->name('chancellor-patented-reject');

#####UTILIZED#############
Route::get('/chancellor/utilized/view/{researches}',[ChancellorController::class, 'viewUtilized'])->name('chancellor-utilized-view')->middleware(['auth','chancellor']);
Route::put('/chancellor/utilized/approve/{researches}',[ChancellorController::class, 'approveUtilized'])->name('chancellor-utilized-approve');
Route::patch('/chancellor/utilized/reject/{researches}',[ChancellorController::class, 'rejectUtilized'])->name('chancellor-utilized-reject');








############################################################# R M O ######################################################################

Route::get('/rmo/rbp', [RMOController::class, 'rbpDashboard'])->name('rmo-rbp')->middleware(['auth','rmo']);
Route::get('/rmo/rbp/create', [RMOController::class, 'createRBP'])->name('rmo-rbp-create')->middleware(['auth','rmo']);
Route::post('/rmo/rbp/create', [RMOController::class, 'storeRBP']);
Route::get('/rmo/rbp/{rbp}/add-members/{leader}', [RMOController::class, 'viewResearchAddMembers'])->name('rmo-rbp-addmembers')->middleware(['auth','rmo']);
Route::post('/rmo/rbp/{proposal}/add-members/{rmo}', [RMOController::class, 'addMember'])->name('rmo-rbp-addmember');
Route::delete('/rmo/rbp/{rbp}/{member}', [RMOController::class, 'deleteResearchMember'])->name('rmo-rbp-deletemember');
Route::get('/rmo/rbp/view/{rbp}',[RMOController::class, 'viewResearch'])->name('rmo-rbp-view')->middleware(['auth','rmo']);
Route::get('/rmo/rbp/{proposal}/upload', [RMOController::class, 'uploadFile'])->name('rmo-rbp-upload')->middleware(['auth','rmo']);
Route::post('/rmo/rbp/{proposal}/upload', [RMOController::class, 'storeFile']);
Route::get('/rmo/rbp/edit/{researches}', [RMOController::class, 'editResearch'])->name('rmo-rbp-edit')->middleware(['auth','rmo']);
Route::put('/rmo/rbp/edit/{researches}', [RMOController::class, 'updateResearch']);
Route::post('/rmo/rbp/delete/{researches}', [RMOController::class, 'deleteRBP'])->name('rmo-rbp-delete');
Route::get('/rmo/rbp/view/{researches}',[RMOController::class, 'viewResearch'])->name('rmo-rbp-view')->middleware(['auth','rmo']);
Route::post('/rmo/rbp/view/{researches}',[RMOController::class, 'storeUtilized']);
Route::put('/rmo/rbp/view/{researches}',[RMOController::class, 'updatePatented']);
Route::put('/rmo/utilized/update/{researches}',[RMOController::class, 'updateUtilized'])->name('rmo-utilized-update');
Route::post('/rmo/utilized/delete/{researches}',[RMOController::class, 'deleteUtilized'])->name('rmo-utilized-delete');
Route::post('/rmo/published/delete/{researches}',[RMOController::class, 'deletePublished'])->name('rmo-published-delete');
Route::post('/rmo/presented/delete/{researches}',[RMOController::class, 'deletePresented'])->name('rmo-presented-delete');
Route::post('/rmo/journalcited/delete/{researches}',[RMOController::class, 'deleteJournalCited'])->name('rmo-journalcited-delete');
Route::post('/rmo/bookcited/delete/{researches}',[RMOController::class, 'deleteBookCited'])->name('rmo-bookcited-delete');
Route::post('/rmo/patented/delete/{researches}',[RMOController::class, 'deletePatented'])->name('rmo-patented-delete');


###PENDING################
Route::get('/rmo/pending', [RMOController::class, 'pendingDashboard'])->name('rmo-pending')->middleware(['auth','rmo']);
Route::get('/rmo/pending/edit/{researches}', [RMOController::class, 'editPending'])->name('rmo-pending-edit')->middleware(['auth','rmo']);
Route::put('/rmo/pending/edit/{researches}', [RMOController::class, 'updatePending']); 


#####FOR REVISION########
Route::get('/rmo/revision', [RMOController::class, 'revisionDashboard'])->name('rmo-revision')->middleware(['auth','rmo']);

######PAPER PUBLISHED############
Route::get('/rmo/paper-published/create/{researches}', [RMOController::class, 'createPaperPublished'])->name('rmo-paperpublished-create')->middleware(['auth','rmo']);
Route::post('/rmo/paper-published/create/{researches}/', [RMOController::class, 'storePaperPublished']);
Route::get('/rmo/paper-published/edit/{researches}/{published}', [RMOController::class, 'editPaperPublished'])->name('rmo-paperpublished-edit')->middleware(['auth','rmo']);
Route::put('/rmo/paper-published/edit/{researches}/{published}', [RMOController::class, 'updatePaperPublished']);
Route::get('/rmo/paper-published/view/{researches}',[RMOController::class, 'viewPaperPublished'])->name('rmo-paperpublished-view')->middleware(['auth','rmo']);



######JOURNAL CITED#############
Route::get('/rmo/journal-cited/create/{researches}', [RMOController::class, 'createJournalCited'])->name('rmo-journalcited-create')->middleware(['auth','rmo']);
Route::post('/rmo/journal-cited/create/{researches}', [RMOController::class, 'storeJournalCited']);
Route::get('/rmo/journal-cited/edit/{researches}/{journalcited}', [RMOController::class, 'editJournalCited'])->name('rmo-journalcited-edit')->middleware(['auth','rmo']);
Route::put('/rmo/journal-cited/edit/{researches}/{journalcited}', [RMOController::class, 'updateJournalCited']);
Route::get('/rmo/journal-cited/view/{researches}',[RMOController::class, 'viewJournalCited'])->name('rmo-journalcited-view')->middleware(['auth','rmo']);



#####BOOK CITED#############
Route::get('/rmo/book-cited/create/{researches}', [RMOController::class, 'createBookCited'])->name('rmo-bookcited-create')->middleware(['auth','rmo']);
Route::post('/rmo/book-cited/create/{researches}', [RMOController::class, 'storeBookCited']);
Route::get('/rmo/book-cited/edit/{researches}/{bookcited}', [RMOController::class, 'editBookCited'])->name('rmo-bookcited-edit')->middleware(['auth','rmo']);
Route::put('/rmo/book-cited/edit/{researches}/{bookcited}', [RMOController::class, 'updateBookCited']);
Route::get('/rmo/book-cited/view/{researches}',[RMOController::class, 'viewBookCited'])->name('rmo-bookcited-view')->middleware(['auth','rmo']);



#####PAPER PRESENTED#############
Route::get('/rmo/paper-presented/create/{researches}', [RMOController::class, 'createPaperPresented'])->name('rmo-paperpresented-create')->middleware(['auth','rmo']);
Route::post('/rmo/paper-presented/create/{researches}', [RMOController::class, 'storePaperPresented']);
Route::get('/rmo/paper-presented/edit/{researches}/{presented}', [RMOController::class, 'editPaperPresented'])->name('rmo-paperpresented-edit')->middleware(['auth','rmo']);
Route::put('/rmo/paper-presented/edit/{researches}/{presented}', [RMOController::class, 'updatePaperPresented']);
Route::get('/rmo/paper-presented/view/{researches}',[RMOController::class, 'viewPaperPresented'])->name('rmo-paperpresented-view')->middleware(['auth','rmo']);



##### INVENTION ###########
Route::get('/rmo/invention', [RMOController::class, 'inventionDashboard'])->name('rmo-invention')->middleware(['auth','rmo']);
Route::get('/rmo/invention/create', [RMOController::class, 'createInvention'])->name('rmo-invention-create')->middleware(['auth','rmo']);
Route::post('/rmo/invention/create', [RMOController::class, 'storeInvention']);
Route::get('/rmo/invention/{invention}/add-members', [RMOController::class, 'viewInventionAddMembers'])->name('rmo-invention-addmembers')->middleware(['auth','rmo']);
Route::post('/rmo/invention/{proposal}/add-members/{rmo}', [RMOController::class, 'addMemberInvention'])->name('rmo-addmember');
Route::delete('/rmo/invention/{invention}/{member}', [RMOController::class, 'deleteResearchMember'])->name('rmo-invention-deletemember');
Route::get('/rmo/invention/view/{invention}',[RMOController::class, 'viewInvention'])->name('rmo-invention-view')->middleware(['auth','rmo']);
Route::get('/rmo/invention/edit/{researches}', [RMOController::class, 'editInvention'])->name('rmo-invention-edit')->middleware(['auth','rmo']);
Route::put('/rmo/invention/edit/{researches}', [RMOController::class, 'updateInvention']);




#####PATENTED#############
Route::get('/rmo/patented/create/{researches}', [RMOController::class, 'createPatented'])->name('rmo-patented-create')->middleware(['auth','rmo']);
Route::post('/rmo/patented/create/{researches}', [RMOController::class, 'storePatented']);
Route::get('/rmo/patented/edit/{researches}', [RMOController::class, 'editPatented'])->name('rmo-patented-edit')->middleware(['auth','rmo']);
Route::put('/rmo/patented/edit/{researches}', [RMOController::class, 'updatePatented']);
Route::get('/rmo/patented/view/{researches}',[RMOController::class, 'viewPatented'])->name('rmo-patented-view')->middleware(['auth','rmo']);



#####UTILIZED#############
Route::get('/rmo/utilized/create/{researches}', [RMOController::class, 'createUtilized'])->name('rmo-utilized-create')->middleware(['auth','rmo']);
Route::post('/rmo/utilized/create/{researches}', [RMOController::class, 'storeUtilized']);
Route::get('/rmo/utilized/edit/{researches}', [RMOController::class, 'editUtilized'])->name('rmo-utilized-edit')->middleware(['auth','rmo']);
Route::put('/rmo/utilized/edit/{researches}', [RMOController::class, 'updateUtilized']);
Route::get('/rmo/utilized/view/{researches}',[RMOController::class, 'viewUtilized'])->name('rmo-utilized-view')->middleware(['auth','rmo']);

Route::get('/rmo/pending/validate/{rbp}',[RMOController::class, 'validateResearch'])->name('rmo-rbp-validate')->middleware(['auth','rmo']);
Route::put('/rmo/pending/approve/{rbp}',[RMOController::class, 'approveResearchChancellor'])->name('rmo-rbp-approve');
Route::put('/rmo/pending/validate/{rbp}',[RMOController::class, 'rejectResearchChancellor'])->name('rmo-rbp-reject');

Route::put('/rmo/submit/revision/{rbp}', [RMOController::class, 'submitForRevision'])->name('rmo-submit-revision');

Route::put('/rmo/paper-published/approve/{researches}',[RMOController::class, 'approvePaperPublished'])->name('rmo-paperpublished-approve');
Route::patch('/rmo/paper-published/reject/{researches}',[RMOController::class, 'rejectPaperPublished'])->name('rmo-paperpublished-reject');

Route::put('/rmo/paper-presented/approve/{researches}',[RMOController::class, 'approvePaperPresented'])->name('rmo-paperpresented-approve');
Route::patch('/rmo/paper-presented/reject/{researches}',[RMOController::class, 'rejectPaperPresented'])->name('rmo-paperpresented-reject');

Route::put('/rmo/journal-cited/approve/{researches}',[RMOController::class, 'approveJournalCited'])->name('rmo-journalcited-approve');
Route::patch('/rmo/journal-cited/reject/{researches}',[RMOController::class, 'rejectJournalCited'])->name('rmo-journalcited-reject');

Route::put('/rmo/book-cited/approve/{researches}',[RMOController::class, 'approveBookCited'])->name('rmo-bookcited-approve');
Route::patch('/rmo/book-cited/reject/{researches}',[RMOController::class, 'rejectBookCited'])->name('rmo-bookcited-reject');

Route::put('/rmo/patented/approve/{researches}',[RMOController::class, 'approvePatented'])->name('rmo-patented-approve');
Route::patch('/rmo/patented/reject/{researches}',[RMOController::class, 'rejectPatented'])->name('rmo-patented-reject');

Route::put('/rmo/utilized/approve/{researches}',[RMOController::class, 'approveUtilized'])->name('rmo-utilized-approve');
Route::patch('/rmo/utilized/reject/{researches}',[RMOController::class, 'rejectUtilized'])->name('rmo-utilized-reject');


#####SUMMARY SHEET########
Route::get('/rmo/generate-summarysheet', [RMOController::class, 'generateSummary'])->name('rmo-sheet')->middleware(['auth','rmo']);
Route::get('/rmo/view-summarysheet', [RMOController::class, 'viewSummary'])->name('rmo-view-sheet')->middleware(['auth','rmo']);


########REPORT#############
Route::get('/rmo/generate-report', [RMOController::class, 'generateReport'])->name('rmo-report')->middleware(['auth','rmo']);
Route::get('/rmo/view-report', [RMOController::class, 'viewReport'])->name('rmo-view-report')->middleware(['auth','rmo']);

####################FACULTY##########################################
Route::get('/rmo/faculties', [RMOController::class, 'facultyDashboard'])->name('rmo-faculty')->middleware(['auth','rmo']);
Route::get('/rmo/faculties/view/{faculty}',[RMOController::class, 'viewFaculty'])->name('rmo-faculty-view')->middleware(['auth','rmo']);
Route::get('/rmo/faculties/view/research/{researches}/{faculty}',[RMOController::class, 'viewFacultyResearch'])->name('rmo-faculty-view-research')->middleware(['auth','rmo']);

