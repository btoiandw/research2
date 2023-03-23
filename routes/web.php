<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
Route::get('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/getdata-login', [App\Http\Controllers\HomeController::class, 'index'])->name('getdata-login');

Route::get('/admin/dashboard/{id}', [\App\Http\Controllers\Pre\TbAdminController::class, 'index'])->name('admin.dashboard');
Route::get('/users/dashboard/{id}/{roles}', [\App\Http\Controllers\Pre\TbUserController::class, 'index'])->name('users.dashboard');
Route::get('/director/dashboard/{id}/{roles}', [\App\Http\Controllers\Pre\TbDirectorController::class, 'index'])->name('director.dashboard');
Route::get('/users-director/{id}/{roles}', [\App\Http\Controllers\Pre\UDController::class, 'index'])->name('ud.dashboard');


Route::get('research/{id}/{roles}', [\App\Http\Controllers\Pre\TbResearchController::class, 'index'])->name('research-pages');
Route::post('/research/store', [\App\Http\Controllers\Pre\TbResearchController::class, 'store'])->name('research.store');
Route::get('/view/research/{id}', [\App\Http\Controllers\Pre\TbResearchController::class, 'show']);
Route::get('autocomplete', [\App\Http\Controllers\Pre\TbResearchController::class, 'autocomplete'])->name('autocomplete');


Route::get('/admin/request/{id}', [\App\Http\Controllers\Pre\TbAdminController::class, 'rePages'])->name('admin.request');
Route::get('/admin/manage/users/{id}', [\App\Http\Controllers\Pre\TbAdminController::class, 'manaUser'])->name('admin.manage-user');
Route::get('/admin/send-director/{id}', [\App\Http\Controllers\Pre\TbAdminController::class, 'ResearchDirector'])->name('admin.send-research-director');
Route::get('/admin/manage-source/{id}', [\App\Http\Controllers\Pre\TbSourceController::class, 'manageSource'])->name('admin.manage-source');

Route::get('/admin/research/director/{id}', [\App\Http\Controllers\Pre\TbResearchController::class, 'addDirector']);
Route::post('/admin/add-director', [\App\Http\Controllers\TbFeedbackController::class, 'store'])->name('admin.add-director');

Route::get('/admin/view-feed/director/{id}', [\App\Http\Controllers\TbFeedbackController::class, 'viewFeed'])->name('admin.view-feed-director');

Route::get('director/feedback/{id}/{roles}', [\App\Http\Controllers\Pre\TbDirectorController::class, 'feedPages'])->name('director.feedPages');
Route::post('/director/addfeed', [\App\Http\Controllers\TbFeedbackController::class, 'addFeed'])->name('director.add-feed');
Route::get('/view-word/{id}', [\App\Http\Controllers\Pre\TbResearchController::class, 'viewFile'])->name('view.word');
Route::get('/view-pdf/{id}', [\App\Http\Controllers\Pre\TbResearchController::class, 'viewFilePDF'])->name('view.pdf');
Route::post('research/update', [\App\Http\Controllers\Pre\TbResearchController::class, 'update'])->name('user.update_research');


Route::get('admin/deliver-list/{id}', [\App\Http\Controllers\Pre\TbAdminController::class, 'deliverPages'])->name('admin.deliver-pages');
Route::get('admin/report/cbg/{id}', [\App\Http\Controllers\Pre\TbAdminController::class, 'cbgPages'])->name('admin.dbg-pages');
Route::get('admin/report/cresearch/{id}', [\App\Http\Controllers\Pre\TbAdminController::class, 'cresearchPages'])->name('admin.cresearch-pages');


Route::get('/admin/cancel/{id}', [\App\Http\Controllers\Pre\TbAdminController::class, 'show']);
Route::get('/admin/cancel/admin/{id}', [\App\Http\Controllers\Pre\TbAdminController::class, 'edit']);
Route::post('/admin/search', [\App\Http\Controllers\Pre\TbAdminController::class, 'searchAdmin']);
Route::post('/admin/store', [\App\Http\Controllers\Pre\TbAdminController::class, 'store']);

Route::get('/users/cancel-research/{id}', [\App\Http\Controllers\Pre\TbResearchController::class, 'cancel']);

Route::get('/view/feed/detail/{id}/{u_id}', [\App\Http\Controllers\TbFeedbackController::class, 'FeedDetail']);
Route::get('/admin/view/source/{id}',[\App\Http\Controllers\Pre\TbSourceController::class,'viewSource']);
Route::get('/cencel/source/{id}',[\App\Http\Controllers\Pre\TbSourceController::class,'cancelSource']);
Route::post('/admin/edit/source',[\App\Http\Controllers\Pre\TbSourceController::class,'edit'])->name('admin.edit-source');
Route::get('/view/source/file/{id}',[\App\Http\Controllers\Pre\TbSourceController::class,'viewFile']);
Route::post('/admin/source/store',[\App\Http\Controllers\Pre\TbSourceController::class,'store'])->name('admin.source-store');
Route::post('/admin/list',[\App\Http\Controllers\TbDeliverListController::class,'store'])->name('admin.deliver-store');
Route::get('/admin/view/list/{id}',[\App\Http\Controllers\TbDeliverListController::class,'view']);
Route::get('/admin/cancel/list/{id}',[\App\Http\Controllers\TbDeliverListController::class,'cancel']);
Route::post('/admin/list/edit',[\App\Http\Controllers\TbDeliverListController::class,'update'])->name('admin.list-edit');
Route::post('/admin/sum/feed',[\App\Http\Controllers\TbFeedbackController::class,'sumFeed'])->name('admin.add-sumFeed');
Route::post('/admin/approve/contact',[\App\Http\Controllers\Pre\TbAdminController::class,'approve'])->name('admin.approve-contact');


Route::get('/gen/pdf', [\App\Http\Controllers\Pre\PDFController::class, 'generatePDF']);
