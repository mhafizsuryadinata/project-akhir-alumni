<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login',[ApiController::class, 'login']);
Route::post('update_profile',[ApiController::class, 'update_profile']);
Route::get('alumni/dashboard',[ApiController::class, 'alumni'])->name('alumni.dashboard');
Route::get('get_comments',[ApiController::class, 'getComments']);
Route::post('store_comment',[ApiController::class, 'storeComment']);
Route::post('delete_comment',[ApiController::class, 'deleteComment']);
Route::get('get_stats',[ApiController::class, 'getStats']);
Route::get('alumni/{id}',[ApiController::class, 'alumniDetail']);
Route::get('info_pondok',[ApiController::class, 'getInfoPondok']);
Route::get('get_galeri',[ApiController::class, 'getGaleri']);
Route::get('events',[ApiController::class, 'getEvents']);
Route::get('kontak_ustadz',[ApiController::class, 'getKontakUstadz']);
Route::get('lowongan',[ApiController::class, 'getLowongan']);
Route::post('apply_lowongan', [ApiController::class, 'applyLowongan']);
Route::get('my_applications/{id_user}', [ApiController::class, 'getMyApplications']);
Route::post('store_lowongan', [ApiController::class, 'storeLowongan']);
Route::post('join_event', [ApiController::class, 'joinEvent']);
Route::post('store_event', [ApiController::class, 'storeEvent']);
Route::post('update_photo', [ApiController::class, 'update_photo']);
Route::get('get_albums', [ApiController::class, 'getAlbums']);
Route::get('album/{id}/media', [ApiController::class, 'getAlbumMedia']);
Route::post('store_media', [ApiController::class, 'storeMedia']);
Route::post('store_album', [ApiController::class, 'storeAlbum']);
Route::get('faqs', [ApiController::class, 'getFaqs']);
Route::get('my_messages/{id_user}', [ApiController::class, 'getMyMessages']);
Route::post('send_contact_message', [ApiController::class, 'sendContactMessage']);