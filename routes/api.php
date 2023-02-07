<?php

use App\Http\Controllers\Tracker\AuthController;
use App\Http\Controllers\Tracker\ProjectController;
use App\Http\Controllers\Tracker\TrackerController;
use App\Http\Controllers\WebTrackingController;
use Centroall\Helper\Utils\CommonUtil;
use Illuminate\Support\Facades\Route;



/* Auth */
Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

/* Project Crud */
Route::group(['middleware' => 'auth:sanctum','prefix'=> 'project'], function () {
    Route::get('show',[ProjectController::class, 'show']);
    Route::get('getProject/{project_id}',[ProjectController::class, 'getProject']);
    Route::post('store',[ProjectController::class, 'store']);
    Route::post('update/{project_id}',[ProjectController::class, 'update']);
    Route::post('delete/{project_id}',[ProjectController::class, 'delete']);
});

// Route::group(['middleware' => ['api', 'DecryptRequest', 'redis-auth-token', 'selectOrganisation']], function () {
Route::group(['middleware' => ['auth:sanctum']], function () {
    /* web-tracking - clockin/clockout api */
    Route::get('web-tracking', [WebTrackingController::class, 'getWebTracking']);
    Route::post('web-tracking', [WebTrackingController::class, 'saveWebTracking']);


    /* Tracker apis */
    Route::group(['middleware' => ['projectExist']], function () {
        Route::post("tracker/get-status", [TrackerController::class, 'getStatus']);
        Route::post("tracker/start-activity", [TrackerController::class, 'startActivity']);
        Route::post("tracker/stop-activity", [TrackerController::class, 'stopActivity']);
        Route::post("tracker/restart-activity", [TrackerController::class, 'restartActivity']);
        Route::post("tracker/accept-screenshot", [TrackerController::class, 'acceptScreenshot']);
        Route::post("tracker/reject-screenshot", [TrackerController::class, 'rejectScreenshot']);
        Route::put("tracker/add-memo", [TrackerController::class, 'addMemo']);
        Route::post("tracker/search-memo", [TrackerController::class, 'searchMemo']);
        Route::post("tracker/week-hours", [TrackerController::class, 'weeklyTrackedHours']);
    });

        Route::get("tracker/assigned-projects", [TrackerController::class, 'getAssignedProjects']);
        Route::get("tracker/today-time-track", [TrackerController::class, 'TodayTime']);
        Route::post("tracker/set-reminder", [TrackerController::class, 'setReminder']);
        Route::post("tracker/offline-tracking", [TrackerController::class, 'offlineTracker']);
        Route::post("tracker/upload-screenshot-links", [TrackerController::class, 'getTrackerS3Links']);
        // Route::get("tracker/temp-upload-screenshot", [TrackerController::class, 'uploadScreenshot']);

});