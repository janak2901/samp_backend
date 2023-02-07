<?php

use Carbon\Carbon;
use Centroall\Helper\Models\EmailTemplate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Tracker\TrackerController;

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
    return view('welcome');
});

Route::get('/hash', function () {
    echo Hash::make("admin@123");
});


Route::get('test-mail', function () {
    $otp = 11111;
    return view('email.otp-varify', compact('otp'));
});

Route::get('health-check', function () {
    return response()->json(['message' => (config('app.PROJECT_MODULE') ?? '') . ' Module is working'], 200);
});


/*Route::get('/current-route', function () {
   dd($_SERVER['HTTP_HOST']);
});*/

/* accept/decline client invitation */
// Route::group(['middleware' => 'selectOrganisation'], function () {
//     Route::get('/accept/client-invitation/{client_user_id}/{unique_id}/{base_url}', [ClientController::class, 'acceptClientInvitation'])->name('accept-client-invitation');
//     Route::get('/reject/client-invitation/{client_user_id}/{unique_id}/{base_url}', [ClientController::class, 'rejectClientInvitation'])->name('reject-client-invitation');

//     Route::get('/accept/user-invitation/{user_id}/{unique_id}/{base_url}', [EmployeeController::class, 'acceptUserInvitation'])->name('accept-user-invitation');
//     Route::get('/reject/user-invitation/{user_id}/{unique_id}/{base_url}', [EmployeeController::class, 'rejectUserInvitation'])->name('reject-user-invitation');
// });