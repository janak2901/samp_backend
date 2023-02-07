<?php

namespace App\Http\Controllers\Tracker;

use App\Http\Controllers\Controller;
use Centroall\Helper\Models\EmployeeDetail;
use Centroall\Helper\Models\Project;
use Centroall\Helper\Models\TrackerActivity;
use Centroall\Helper\Models\TrackerMemo;
use Centroall\Helper\Models\TrackerPolicy;
use Centroall\Helper\Models\TrackerReminder;
use Centroall\Helper\Models\TrackerScreenshot;
use Centroall\Helper\Models\TrackerStatus;
use Centroall\Helper\Traits\ApiResponse;
use Carbon\Carbon;
use Centroall\Helper\Models\Shift;
use Centroall\Helper\Models\WebTracking;
use Centroall\Helper\Utils\CommonUtil;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TrackerController extends Controller
{
    use ApiResponse;

    public function getAssignedProjects(Request $request)
    {
        try {
            // $projects =  Project::with("tracker_status")->whereHas('project_members', function ($query) {
            //     $query->where('user_id', 1);
            // })->orWhere("pm_id", 1)->get();
            $projects =  Project::whereHas('project_members', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })->get();

            if ($projects->isNotEmpty()) {
                foreach ($projects as $project) {
                    $lastMemo = $project->id ? $this->getLastMemo($project->id) : null;
                    $project->TodayTime = $this->TodayTime($request, "common") ?? null;
                    $project->WeekTime = $project->id ? $this->weeklyTrackedHours($request, "common", $project->id) : null;
                    $project->LastMemo = $lastMemo ? TrackerMemo::with("status")->find($lastMemo) : null;
                    $project->Lastcreenshot = $project->id ? $this->getLastScreenshot($project->id) : null;
                }
                $tPolicy = EmployeeDetail::with('tracker_productivity')->where("user_id", Auth::user()->id)->first();
                if ((!empty($tPolicy)) && (!empty($tPolicy->tracker_productivity))) {
                    $projects[0]->tracker_policy = $tPolicy->tracker_productivity;
                } else {
                    $defaultPolicy = TrackerPolicy::first();
                    if ($defaultPolicy && (!empty($defaultPolicy))) {
                        $projects[0]->tracker_policy = $defaultPolicy;
                    } else {
                        $projects[0]->tracker_policy = null;
                    }
                }
                if (count($projects) > 0) {
                    return $this->response("SUCCESS", "Assigned projects.", ($projects));
                } else {
                    return $this->response("RECORD_NOT_FOUND", "No projects found.");
                }
            } else {
                return $this->response("RECORD_NOT_FOUND", "You don't have any projects.");
            }
        } catch (Exception $e) {
            return $this->serverErrorResponse($e);
        }
    }

    public function checkLateComming($request, $dayEndTime = null, $isFirst = false, $type = null)
    {
        
        $tPolicy = EmployeeDetail::with('tracker_productivity', 'shift')->where("user_id", Auth::user()->id)->first();
        if ((!empty($tPolicy)) && (!empty($tPolicy->tracker_productivity))) {
            $trackerPolicy =  $tPolicy->tracker_productivity;
        } else {
            $defaultPolicy = TrackerPolicy::where("status", 1)->first();
            if ($defaultPolicy && (!empty($defaultPolicy))) {
                $trackerPolicy =   $defaultPolicy;
            }
        }

        $userLateComing = false;
        
        if ($trackerPolicy && $trackerPolicy->late_coming_early_going) {
            if ((!empty($tPolicy)) && (!empty($tPolicy->shift))) {
                $isStartShift = $tPolicy->shift->day_start;
                $isEndShift = $tPolicy->shift->day_end;
            } else {
                $defaultShift = Shift::where("status", 1)->first();
                if ($defaultShift && (!empty($defaultShift))) {
                    $isStartShift = $defaultShift->day_start;
                    $isEndShift = $defaultShift->day_end;
                }
            }


            if ($isStartShift && $isFirst) {
                $userLateComing = $this->fetchTimeDiffernce($isStartShift, date("H:i:s", strtotime($request->start_date)), "start", $trackerPolicy);
            } else if ($isEndShift && !$isFirst && $dayEndTime < $isEndShift) {
                $userLateComing = $this->fetchTimeDiffernce($isEndShift, $dayEndTime, $type, $trackerPolicy);
            }
        }
        
        return $userLateComing;
    }

    public function fetchTimeDiffernce($isShift, $start = null, $type = null, $trackerPolicy)
    {
        $start = strtotime($start);
        $end = strtotime($isShift);
        $minutes = ($type == "stop" && $start < $end) ?  (($end - $start) / 60) : (($start > $end) ? (($start - $end) / 60) : 0);
        if (($type == "stop" && $minutes > $trackerPolicy->early_going_before_mins) ||  ($type == "start" && $minutes > $trackerPolicy->late_coming_after_mins)) {
            $userLateComing = true;
        } else {
            $userLateComing = false;
        }

        return $userLateComing;
    }

    public function saveWebTracking($request, $startDate, $endDate, $type)
    {

        $updateDateTime = empty($endDate) ? $startDate : $endDate;
        $lastMemoId = $request->project_id  ? $this->getLastMemo($request->project_id) : null;
        $memo = $lastMemoId ? TrackerMemo::find($lastMemoId) : null;
        $activityArray = [
            "activity" => [
                [
                    "memo" => $memo->description ?? null,
                    "start" => $startDate ? strtotime($startDate) : null,
                    "end" => $endDate ? strtotime($endDate) : null,
                    "method" => "centroall_tracker",
                    "is_missing_punch" => 0,
                ]
            ],
            "recent_activity_type" => $type == "start" ? "clock-in" : "clock-out",
        ];

        $isFirstActivity = TrackerActivity::where("user_id", Auth::user()->id)->where("project_id", $request->project_id)->whereNotNull("end_date")->whereDate("start_date", date('Y-m-d', strtotime($updateDateTime)))->first();

        $checkLateOrNot = 0;
        if (!empty($isFirstActivity) && $type == "stop") {
            $checkLateOrNot = $this->checkLateComming($request, date('H:i:s', strtotime($endDate)), null, $type) ? 1 : 0;
        } else if ($type == "start" && empty($isFirstActivity)) {
            $checkLateOrNot =  $this->checkLateComming($request, null, true, $type) ? 1 : 0;
        }
        if ($checkLateOrNot) {
            $type == "start" ? $activityArray["activity"][0]["is_late_coming"] = $checkLateOrNot : $activityArray["activity"][0]["is_early_going"] = $checkLateOrNot;
        }


        if ($activityArray) {
            $webTracking = WebTracking::where("user_id", Auth::user()->id)->whereDate("created_at", date('Y-m-d', strtotime($updateDateTime)))->first();

            if (empty($webTracking)) {
                
                $webTracking = new WebTracking();
                $Existingactivity = $activityArray;
            } else {

                $Existingactivity = json_decode($webTracking->activity, true);
                if ($type == "start") {
                    $tPolicy = EmployeeDetail::with('tracker_productivity')->where("user_id", Auth::user()->id)->first();
                    $ignoreOutPunchMins = empty($tPolicy->tracker_productivity) ? 5 : $tPolicy->tracker_productivity->ignore_out_punch_mins;
                    $ignoreOutPunchTime = (empty($ignoreOutPunchMins) ? 5 : $ignoreOutPunchMins) * 60;

                    end($Existingactivity['activity']);
                    $lastExistingActivityKey = key($Existingactivity['activity']);
                    reset($Existingactivity['activity']);

                    $data = array_map(
                        function (array $subArr) {
                            static $i = 0;
                            if ($subArr['end'] != null && array_key_exists('is_early_going', $subArr)) {
                                unset($subArr['is_early_going']);
                            } else if ($subArr['end'] == null) {
                                if (array_key_exists('is_missing_punch', $subArr)) {
                                    $subArr['is_missing_punch'] = 1;
                                }
                            } else if (array_key_exists('is_late_coming', $subArr)) {
                                if ($i > 0) {
                                    unset($subArr['is_late_coming']);
                                }
                            }
                            $i++;
                            return $subArr;
                        },
                        $Existingactivity["activity"]
                    );
                    $Existingactivity["activity"] = $data;

                    if (!empty($Existingactivity["activity"][$lastExistingActivityKey]['end']) && (((int)$activityArray["activity"][0]['start']) - ((int)$Existingactivity["activity"][$lastExistingActivityKey]['end'])) < $ignoreOutPunchTime) {
                        $Existingactivity["activity"][$lastExistingActivityKey]['end'] = null;
                    } else {
                        array_push($Existingactivity["activity"], $activityArray["activity"][0]);
                    }
                } else {
                    $length = count($Existingactivity["activity"]);
                    $Existingactivity["activity"][$length - 1]["end"] =  $Existingactivity["activity"][$length - 1]["end"] == null ? strtotime($updateDateTime) : null;
                    if ($activityArray["activity"][0] && array_key_exists('is_early_going', $activityArray["activity"][0])) {
                        $Existingactivity["activity"][$length - 1]["is_early_going"] =  $activityArray["activity"][0]["is_early_going"];
                    }
                }
                $Existingactivity["recent_activity_type"] = $activityArray["recent_activity_type"];
            }
            
            $webTracking->user_id = Auth::user()->id;
            $webTracking->total = $this->TodayTime($request, "common") ?? 0;
            $webTracking->activity = json_encode($Existingactivity);
            $webTracking->save();
        }
    }

    public function startActivity(Request $request, $type = true)
    {

        if ($request->has('project_id') && $request->project_id != '') {
            $request->merge(['project_id' => $this->decode($request->project_id)]);
        }

        $validator = Validator::make($request->all(), [
            'project_id' => 'required|exists:projects,id,deleted_at,NULL',
            'start_date' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->response('VALIDATION_ERROR', $validator->errors()->first());
        }
        try {
            DB::beginTransaction();
            $startActivity = new TrackerActivity();
            $startActivity->user_id  = Auth::user()->id;
            $startActivity->project_id = $request->project_id;
            $startActivity->tracker_memo_id = $request->project_id ? $this->getLastMemo($request->project_id, true) : null;
            $startActivity->start_date = $request->start_date ? date("Y-m-d H:i:s", strtotime($request->start_date)) : null;
            $startActivity->created_by = Auth::user()->id;
            if ($startActivity->save()) {
                DB::commit();
                $this->saveWebTracking($request, $request->start_date, null, "start");
                if ($type) {
                    return $this->response('SUCCESS', "Successfully Start Tracker", /* json_encode */($startActivity));
                } else {
                    return;
                }
            } else {
                DB::rollBack();
                return $this->response('FAILURE', "Something went wrong");
            }
        } catch (Exception $e) {
            DB::rollBack();
            return $this->serverErrorResponse($e->getMessage());
        }
    }

    public function stopActivity(Request $request, $type = true)
    {
        if ($request->has('project_id') && $request->project_id != '') {
            $request->merge(['project_id' => $this->decode($request->project_id)]);
        }

        $validator = Validator::make($request->all(), [
            'project_id' => 'required|exists:projects,id,deleted_at,NULL',
            "keyboard_mouse_count" => "required",
            "duration" => "required",
            "end_date" => "required"
        ]);

        if ($validator->fails()) {
            return $this->response('VALIDATION_ERROR', $validator->errors()->first());
        }
        try {
            DB::beginTransaction();
            $activityId = $this->getLastActivityId($request->project_id);
            if ($activityId) {
                $production = CommonUtil::calculateProductivity($request);
                $stopActivity = TrackerActivity::find($activityId);
                $stopActivity->duration =  strtotime(preg_replace('/[^0-9:]/', '', $request->duration)) - strtotime('TODAY');
                $stopActivity->keyboard_mouse_count  = $request->keyboard_mouse_count;
                $stopActivity->end_date = $request->end_date ?  date("Y-m-d H:i:s", strtotime($request->end_date)) : null;
                $stopActivity->productivity = $production ? $production["productivity"] : null;
                $stopActivity->productive_duration = $production ? $production["productive_duration"] : null;
                $stopActivity->updated_by = Auth::user()->id;
                if ($stopActivity->save()) {
                    DB::commit();
                    $this->saveWebTracking($request, $stopActivity->start_date, $request->end_date, "stop");
                    if ($type) {
                        return $this->response('SUCCESS', "Tracker stop successfully", /* json_encode */($stopActivity));
                    } else {
                        return;
                    }
                } else {
                    DB::rollBack();
                    return $this->response('FAILURE', "Something went wrong");
                }
            } else {
                return $this->response('FAILURE', "Something went wrong");
            }
        } catch (Exception $e) {
            DB::rollBack();
            return $this->serverErrorResponse($e->getMessage());
        }
    }

    public function restartActivity(Request $request, $type = true)
    {
        if ($request->has('project_id') && $request->project_id != '') {
            $request->merge(['project_id' => $this->decode($request->project_id)]);
        }

        $validator = Validator::make($request->all(), [
            'project_id' => 'required|exists:projects,id,deleted_at,NULL',
            "keyboard_mouse_count" => "required",
            "duration" => "required",
            "start_date" => "required"
        ]);

        if ($validator->fails()) {
            return $this->response('VALIDATION_ERROR', $validator->errors()->first());
        }
        $production = CommonUtil::calculateProductivity($request);

        try {
            DB::beginTransaction();
            $activityId = $this->getLastActivityId($request->project_id);
            if ($activityId) {
                $stopActivity = TrackerActivity::find($activityId);
                $stopActivity->duration = strtotime(preg_replace('/[^0-9:]/', '', $request->duration)) - strtotime('TODAY');
                $stopActivity->keyboard_mouse_count  = $request->keyboard_mouse_count;
                $stopActivity->end_date = $request->start_date ?  date("Y-m-d H:i:s", strtotime($request->start_date)) : null;
                $stopActivity->productivity = $production ? $production["productivity"] : null;
                $stopActivity->productive_duration = $production ? $production["productive_duration"] : null;
                $stopActivity->updated_by = Auth::user()->id;
                if ($stopActivity->save()) {
                    $reStartActivity = new TrackerActivity();
                    $reStartActivity->project_id = $request->project_id;
                    $reStartActivity->user_id  = Auth::user()->id;
                    $reStartActivity->tracker_memo_id = $request->project_id ? $this->getLastMemo($request->project_id) : null;
                    $reStartActivity->created_by = Auth::user()->id;
                    $reStartActivity->start_date = $request->start_date ? date("Y-m-d H:i:s", strtotime($request->start_date)) : null;
                    if ($reStartActivity->save()) {

                        $this->saveWebTracking($request, $stopActivity->start_date, $stopActivity->end_date, "stop");
                        $this->saveWebTracking($request, $reStartActivity->start_date, null, "start");

                        DB::commit();
                        if ($type)
                            return $this->response('SUCCESS', "Tracker restart successfully", /* json_encode */($reStartActivity));
                        else
                            return;
                    } else {
                        DB::rollBack();
                        return $this->response('FAILURE', "Something went wrong");
                    }
                } else {
                    DB::rollBack();
                    return $this->response('FAILURE', "Something went wrong");
                }
            } else {
                return $this->response('FAILURE', "Something went wrong");
            }
        } catch (Exception $e) {
            DB::rollBack();
            return $this->serverErrorResponse($e);
        }
    }

    public function addMemo(Request $request, $type = true)
    {
        if ($request->has('project_id') && $request->project_id != '') {
            $request->merge(['project_id' => $this->decode($request->project_id)]);
        }

        if ($request->has('tracker_status_id') && $request->tracker_status_id != '') {
            $request->merge(['tracker_status_id' => $this->decode($request->tracker_status_id)]);
        }

        $validator = Validator::make($request->all(), [
            'project_id' => 'required|exists:projects,id,deleted_at,NULL',
            "tracker_status_id" => 'required|exists:tracker_statuses,id,deleted_at,NULL',
            "description" => "required"
        ]);

        if ($validator->fails()) {
            return $this->response('VALIDATION_ERROR', $validator->errors()->first());
        }

        try {
            DB::beginTransaction();
            /* $trackerMemo = TrackerMemo::where('user_id', CommonUtil::getRedisUserID())
                ->where('project_id', $request->project_id)
                ->where('tracker_status_id', $request->tracker_status_id)
                ->where('description', $request->description)->first();
            if (!$trackerMemo) {
                $trackerMemo = new TrackerMemo();
            } */
            $trackerMemo = new TrackerMemo();
            $trackerMemo->user_id  = Auth::user()->id;
            $trackerMemo->project_id = $request->project_id;
            $trackerMemo->tracker_status_id  = $request->tracker_status_id;
            $trackerMemo->description  = $request->description;
            $trackerMemo->created_by = Auth::user()->id;
            if ($trackerMemo->save()) {
                DB::commit();
                $lastActivityId = $this->getLastActivityId($request->project_id);
                if ($lastActivityId) {
                    $LastActivity = TrackerActivity::find($lastActivityId);
                    if ($LastActivity) {
                        $LastActivity->tracker_memo_id = $trackerMemo->id;
                        if ($LastActivity->save()) {
                            DB::commit();
                        }
                    }
                }
                if ($type) {
                    return $this->response('SUCCESS', "Memo added Successfully", /* json_encode */($trackerMemo));
                } else {
                    return;
                }
            } else {
                DB::rollBack();
                return $this->response('FAILURE', "Something went wrong");
            }
        } catch (Exception $e) {
            DB::rollBack();
            return $this->serverErrorResponse($e);
        }
    }

    public function searchMemo(Request $request)
    {
        if ($request->has('project_id') && $request->project_id != '') {
            $request->merge(['project_id' => $this->decode($request->project_id)]);
        }

        if ($request->has('tracker_status_id') && $request->tracker_status_id != '') {
            $request->merge(['tracker_status_id' => $this->decode($request->tracker_status_id)]);
        }

        $validator = Validator::make($request->all(), [
            'project_id' => 'required|exists:projects,id,deleted_at,NULL',
            "tracker_status_id" => 'required|exists:tracker_statuses,id,deleted_at,NULL',
            "description" => "required"
        ]);

        if ($validator->fails()) {
            return $this->response('VALIDATION_ERROR', $validator->errors()->first());
        }

        try {
            $trackerMemo = TrackerMemo::where('user_id', CommonUtil::getRedisUserID())
                ->where('project_id', $request->project_id)
                ->where('tracker_status_id', $request->tracker_status_id)
                ->where('description', 'LIKE', '%' . $request->description . '%')->distinct()->pluck('description');

            if ($trackerMemo) {
                return $this->response('SUCCESS', "Related memo", json_encode($trackerMemo));
            } else {
                return $this->response('FAILURE', "Something went wrong");
            }
        } catch (Exception $e) {
            return $this->serverErrorResponse($e);
        }
    }

    public function getLastMemo($projectId, $type = false)
    {
        try {
            $memo = TrackerMemo::where('user_id', Auth::user()->id)
                ->where('project_id', $projectId)
                ->orderBy("id", "DESC")
                ->orderBy("created_at", "DESC")
                ->first();

                
            if (empty($memo) && $type) {
                
                $trackerStatus = TrackerStatus::where("project_id", $projectId)->first();
                if ($trackerStatus) {
                    $trackerMemo = new TrackerMemo();
                    $trackerMemo->user_id  = Auth::user()->id;
                    $trackerMemo->project_id = $projectId;
                    $trackerMemo->tracker_status_id  = $trackerStatus->id;
                    $trackerMemo->created_by = Auth::user()->id;
                    if ($trackerMemo->save()) {
                        DB::commit();
                        return $trackerMemo ? $trackerMemo->id : null;
                    } else {
                        DB::rollBack();
                        return null;
                    }
                }
            }

            return $memo ? $memo->id : null;
        } catch (Exception $e) {
            return $this->serverErrorResponse($e);
        }
    }

    public function getLastMemoData($projectId)
    {
        try {
            $memo = $this->getLastMemo($projectId);
            if ($memo)
                return $this->response('SUCCESS', "Last memo", json_encode($memo));
            else
                return $this->response('RECORD_NOT_FOUND', "Last memo not-found");
        } catch (Exception $e) {
            DB::rollBack();
            return $this->serverErrorResponse($e);
        }
    }

    public function TodayTime(Request $request, $type = "api")
    {
        try {
            $date = $request->manualDate ? $request->manualDate : Carbon::now()->format("Y-m-d");
            $todayTotalTime = TrackerActivity::where('user_id', Auth::user()->id)
                ->whereDate('start_date', $date)
                ->whereDate('end_date', $date)
                ->sum('duration');
            if ($type == "api") {
                return $this->response('SUCCESS', "Today's tracked time", json_encode($todayTotalTime));
            } else {
                return $todayTotalTime;
            }
        } catch (Exception $e) {
            return $this->serverErrorResponse($e);
        }
    }

    public function weeklyTrackedHours(Request $request, $type = "api", $projectID = null)
    {
        if ($type == "api") {
            if ($request->has('project_id') && $request->project_id != '') {
                $request->merge(['project_id' => $this->decode($request->project_id)]);
            }

            $validator = Validator::make($request->all(), [
                'project_id' => 'required|exists:projects,id,deleted_at,NULL',
            ]);

            if ($validator->fails()) {
                return $this->response('VALIDATION_ERROR', $validator->errors()->first());
            }
        }

        try {
            $now =  Carbon::now();
            $week_start = $now->startOfWeek(Carbon::SUNDAY)->format('Y-m-d');
            $week_end = $now->endOfWeek(Carbon::SATURDAY)->format('Y-m-d');
            $project_id = $type == "api" ? $request->project_id : $projectID;
            if ($project_id) {
                $totalTrackedHours = TrackerActivity::where('project_id', $project_id)
                    ->where('user_id', Auth::user()->id)
                    ->whereDate('start_date', ">=", $week_start)
                    ->whereDate('end_date', "<=", $week_end)
                    ->sum('duration');

                if ($type == "api") {
                    return $this->response('SUCCESS', "Weekly tracked time", json_encode($totalTrackedHours));
                } else {
                    return $totalTrackedHours;
                }
            } else {
                return  $this->response('FAILURE', "something went wrong");
            }
        } catch (Exception $e) {
            return $this->serverErrorResponse($e);
        }
    }

    public function getStatus(Request $request)
    {
        try {
            if ($request->has('project_id') && $request->project_id != '') {
                $request->merge(['project_id' => $this->decode($request->project_id)]);
            }

            $validator = Validator::make($request->all(), [
                'project_id' => 'required|exists:projects,id,deleted_at,NULL',
            ]);

            if ($validator->fails()) {
                return $this->response('VALIDATION_ERROR', $validator->errors()->first());
            }

            $statuses = TrackerStatus::where('project_id', $request->project_id)->get();
            if ($statuses) {
                return $this->response('SUCCESS', "All statuses", json_encode($statuses));
            } else {
                return $this->response('RECORD_NOT_FOUND', "No Status was tracked");
            }
        } catch (Exception $e) {
            return $this->serverErrorResponse($e);
        }
    }

    public function setReminder(Request $request)
    {
        try {
            DB::beginTransaction();
            $trackerReminder =  new TrackerReminder();
            $trackerReminder->remind_me = $request->remind_me;
            $trackerReminder->from_time = $request->from_time;
            $trackerReminder->to_time = $request->to_time;
            $trackerReminder->weekdays = $request->weekdays;
            $trackerReminder->reminder_me_time = $request->reminder_me_time;
            $trackerReminder->created_by = CommonUtil::getRedisUserID();
            if ($trackerReminder->save()) {
                DB::commit();
                return $this->response('SUCCESS', "Reminder set successfully", json_encode($trackerReminder));
            } else {
                DB::rollBack();
                return $this->response('FAILURE', "something went wrong");
            }
        } catch (Exception $e) {
            DB::rollBack();
            return $this->serverErrorResponse($e);
        }
    }

    public function acceptScreenshot(Request $request)
    {
        if ($request->has('project_id') && $request->project_id != '') {
            $request->merge(['project_id' => $this->decode($request->project_id)]);
        }

        $validator = Validator::make($request->all(), [
            "file_url" => 'required'
        ]);

        if ($validator->fails()) {
            return $this->response('VALIDATION_ERROR', $validator->errors()->first());
        }

        try {
            DB::beginTransaction();
            $url_saved = $screenshots = [];
            if (is_array($request->file_url)) {
                foreach ($request->file_url as $url) {
                    $lastActivityId = $this->getLastActivityId($request->project_id);
                    if ($lastActivityId) {
                        $screenshot = new TrackerScreenshot();
                        $screenshot->tracker_activity_id = $lastActivityId;
                        $screenshot->url = $url;
                        if ($screenshot->save()) {
                            array_push($url_saved, 1);
                            array_push($screenshots, $screenshot);
                        } else {
                            array_push($url_saved, 0);
                        }
                    }
                }
            } else {
                $lastActivityId = $this->getLastActivityId($request->project_id);
                if ($lastActivityId) {
                    $screenshot = new TrackerScreenshot();
                    $screenshot->tracker_activity_id = $lastActivityId;
                    $screenshot->url = $request->file_url;
                    if ($screenshot->save()) {
                        array_push($url_saved, 1);
                    } else {
                        array_push($url_saved, 0);
                    }
                }
            }

            if (in_array(0, $url_saved)) {
                DB::rollBack();
                return $this->response('FAILURE', "something went wrong");
            } else {
                DB::commit();
                $screenshot_data = !is_array($request->file_url) ? /* json_encode */($screenshot) : /* json_encode */($screenshots);
                return $this->response('SUCCESS', "Screeshot accepted successfully", $screenshot_data);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return $this->serverErrorResponse($e);
        }
    }

    public function rejectScreenshot(Request $request, $type = true)
    {
        if ($request->has('project_id') && $request->project_id != '') {
            $request->merge(['project_id' => $this->decode($request->project_id)]);
        }

        $validator = Validator::make($request->all(), [
            "project_id" => 'required|exists:projects,id,deleted_at,NULL',
            "start_date" => "required"
        ]);

        if ($validator->fails()) {
            return $this->response('VALIDATION_ERROR', $validator->errors()->first());
        }

        try {
            DB::beginTransaction();
            $activityId = $this->getLastActivityId($request->project_id);
            $activity = $activityId ? TrackerActivity::find($activityId) : null;
            if ($activity && $activity->delete()) {
                $newActivity = new TrackerActivity();
                $newActivity->user_id  = Auth::user()->id;
                $newActivity->project_id = $request->project_id;
                $newActivity->tracker_memo_id = $request->project_id ? $this->getLastMemo($request->project_id) : null;
                $newActivity->start_date = $request->start_date ? date("Y-m-d H:i:s", strtotime($request->start_date)) : null;
                $newActivity->created_by = Auth::user()->id;
                if ($newActivity->save()) {
                    DB::commit();
                    if ($type) {
                        return $this->response('SUCCESS', "Screeshot rejected successfully", json_encode($newActivity));
                    } else {
                        return;
                    }
                } else {
                    DB::rollBack();
                    return $this->response('FAILURE', "something went wrong");
                }
            } else {
                return $this->response('FAILURE',  "Something went wrong, please try again.");
            }
        } catch (Exception $e) {
            return $this->serverErrorResponse($e);
        }
    }

    public function getLastScreenshot($project_id)
    {
        try {
            $activity = TrackerActivity::where("user_id", Auth::user()->id)->where("project_id", $project_id)->WhereNotNull("end_date");
            $activity = $activity->whereHas("screenshots")->orderBy('id', "DESC")->first();
            if ($activity) {
                $lastScreenshot = TrackerScreenshot::where("tracker_activity_id", $activity->id)->orderBy('id', "DESC")->first();
                return empty($lastScreenshot) ? null : $lastScreenshot;
            }

            return null;
        } catch (Exception $e) {
            return $this->serverErrorResponse($e);
        }
    }
    // public function getLastScreenshot($project_id)
    // {
    //     try {
    //         $activity = TrackerActivity::where("user_id", CommonUtil::getRedisUserID())->where("project_id", $project_id)->WhereNotNull("end_date");
    //         $activity = $activity->whereHas("screenshots")->orderBy('id', "DESC")->first();
    //         if ($activity) {
    //             $lastScreenshot = TrackerScreenshot::where("tracker_activity_id", $activity->id)->orderBy('id', "DESC")->first();
    //             return empty($lastScreenshot) ? null : $lastScreenshot;
    //         }

    //         return null;
    //     } catch (Exception $e) {
    //         return $this->serverErrorResponse($e);
    //     }
    // }

    public function getLastActivityId($project_id)
    {
        try {
            $activity = TrackerActivity::where("user_id", Auth::user()->id)->where("project_id", $project_id)->orderBy("id", "DESC")->orderBy("created_at", "DESC")->first();
            return empty($activity) ? null : $activity->id;
        } catch (Exception $e) {
            return $this->serverErrorResponse($e);
        }
    }

    public function convertBase64Image($encodedData)
    {
        try {
            $fileImg_parts = explode(";base64,", $encodedData);
            $image_type_aux = explode("image/", $fileImg_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($fileImg_parts[1]);
            $results =  public_path("abcd" . rand() . ".png");
            file_put_contents($results, $image_base64);
            return $results;
        } catch (Exception $e) {
            return $this->serverErrorResponse($e);
        }
    }

    public function offlineTracker(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "offline_data" => "required",
        ]);

        if ($validator->fails()) {
            return $this->response('VALIDATION_ERROR', $validator->errors()->first());
        }

        try {
            foreach ($request->offline_data as $data) {
                foreach ($data['data']as $value) {
                    if ($value["type"] == "accept_ss") {
                        try {
                            DB::beginTransaction();
                            foreach ($value->file as $image) {
                                $screenshot = new TrackerScreenshot();
                                $screenshot->tracker_activity_id = $this->getLastActivityId($this->decode($value->project_id));
                                $uploadPhoto = $this->convertBase64Image($image);
                                $public_link = $this->uploadImage($uploadPhoto, $request, $this->decode($value->project_id));
                                $screenshot->url = $public_link ?? null;
                                if ($screenshot->save()) {
                                    DB::commit();
                                    unlink($uploadPhoto);
                                } else {
                                    DB::rollBack();
                                }
                            }
                        } catch (Exception $e) {
                            DB::rollBack();
                        }
                    } else if ($value["type"] == "stop_tracker") {
                        $request->merge(["project_id" => $value["project_id"]]);
                        $request->merge(["keyboard_mouse_count" => $value["keyboard_mouse_count"]]);
                        $request->merge(["duration" => $value["duration"]]);
                        $request->merge(["end_date" => $value["end_date"]]);
                        $this->stopActivity($request, false);
                    } else if ($value["type"] == "start_tracker") {
                        $request->merge(["project_id" => $value["project_id"]]);
                        $request->merge(["start_date" => $value["start_date"]]);
                        $this->startActivity($request, false);
                    } else if ($value["type"] == "first_memo") {
                        $request->merge(["project_id" => $value["project_id"]]);
                        $request->merge(["tracker_status_id" => $value["tracker_status_id"]]);
                        $request->merge(["description" => $value["description"]]);
                        $this->addMemo($request, false);
                    } else if ($value["type"] == "restart_activity") {
                        $request->merge(["project_id" => $value["project_id"]]);
                        $request->merge(["keyboard_mouse_count" => $value["keyboard_mouse_count"]]);
                        $request->merge(["duration" => $value["duration"]]);
                        $request->merge(["start_date" => $value["start_date"]]);
                        $this->restartActivity($request, false);
                    } else if ($value["type"] == "reject_ss") {
                        $request->merge(["project_id" => $value["project_id"]]);
                        $request->merge(["start_date" => $value["start_date"]]);
                        $this->rejectScreenshot($request, false);
                    }
                }
            }
            $lastActivityId = $this->getLastActivityId($this->decode($value["project_id"]));
            return $this->response("SUCCESS", "Offline data added successfully", /* json_encode */($this->encode($lastActivityId)));
        } catch (Exception $e) {
            return $this->serverErrorResponse($e->getMessage());
        }
    }

    public function uploadImage($file, $request, $projectID)
    {
        try {
            $s3 = \Storage::disk('s3');
            $client = $s3->getDriver()->getAdapter()->getClient();

            $userID = CommonUtil::getRedisUserID();
            $bucketName = CommonUtil::getRedisBucketName();

            $fileName = Str::random(5) . time();
            $path = "tracker/$projectID/$userID/$fileName.png";
            $command = $client->getCommand('PutObject', ['Bucket' => $bucketName, 'Key' => $path]);
            $uploadLink = (string) $client->createPresignedRequest($command, "+5 minutes")->getUri();
            $publicLink = 'https://' . $bucketName . '.' . env('AWS_REGION_URL', 's3.' . env('AWS_DEFAULT_REGION', 'ap-south-1') . '.amazonaws.com') . '/' . $path . '?t=' . time();
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $uploadLink,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'PUT',
                CURLOPT_POSTFIELDS => file_get_contents($file),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: image/png'
                ),
            ));

            curl_exec($curl);
            curl_close($curl);

            return $publicLink;
        } catch (Exception $e) {
            return $this->serverErrorResponse($e);
        }
    }

    public function getTrackerS3Links(Request $request)
    {
        try {
            $request->merge(['project_id' => $this->decode($request->project_id)]);
            $validator = Validator::make($request->all(), [
                'image' => 'required',
                'project_id' => 'required|exists:projects,id,deleted_at,NULL',
                'file_count' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return $this->response('VALIDATION_ERROR', $validator->errors()->first());
            }

            $s3 = \Storage::disk('s3');
            $client = $s3->getDriver()->getAdapter()->getClient();
            
            // $redisData = CommonUtil::getRedisData();
            $userID = Auth::user()->id;
            // $bucketName = CommonUtil::getRedisBucketName();
            $bucketName = 'Laravel';
            
            $projectID = $request->get('project_id');
            $fileCount = $request->get('file_count');

            $link = [];
            for ($i = 0; $i < $fileCount; $i++) {
                $fileName = Str::random(5) . time();
                $path = "music/images/$projectID/$userID/$fileName.png";
                // $path = "tracker/$projectID/$userID/$fileName.png";

                $command = $client->getCommand('PutObject', ['Bucket' => $bucketName, 'Key' => $path]);
                
                $uploadLink = (string) $client->createPresignedRequest($command, "+10 minutes")->getUri();

                $link[$i]['upload_link'] = $uploadLink;
                $link[$i]['public_link'] = env('AWS_ENDPOINT').'/'.$bucketName.'/'.$path . '?t=' . time();
                // $link[$i]['public_link'] = 'https://' . $bucketName . '.' . env('AWS_REGION_URL', 's3.' . env('AWS_DEFAULT_REGION', 'ap-south-1') . '.amazonaws.com') . '/' . $path . '?t=' . time();

                if ($request->hasFile('image')) {
                    if (is_array($request->image)) {
                        $file = $request->file('image')[$i];
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => $uploadLink,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'PUT',
                            CURLOPT_POSTFIELDS => file_get_contents($file),
                            CURLOPT_HTTPHEADER => array(
                                'Content-Type: image/png'
                            ),
                        ));

                        $response = curl_exec($curl);
                        curl_close($curl);
                    } else {
                        $file = $request->file('image');
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => $uploadLink,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'PUT',
                            CURLOPT_POSTFIELDS => file_get_contents($file),
                            CURLOPT_HTTPHEADER => array(
                                'Content-Type: image/png'
                            ),
                        ));

                        $response = curl_exec($curl);
                        curl_close($curl);
                    }
                }
            }

            return $this->response('SUCCESS', "Successfully Created Screenshot Upload Links", /* json_encode */($link));
        } catch (Exception $e) {
            return $this->response('FAILURE',  "Something went wrong, please try again.", $e);
        }
    }

    public function uploadScreenshot(Request $request)
    {
        try {
            $request->merge(['project_id' => $this->decode($request->project_id)]);

            $validator = Validator::make($request->all(), [
                'project_id' => 'required',
                'image' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->response('VALIDATION_ERROR', $validator->errors()->first());
            }

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $userID = CommonUtil::getRedisUserID();
                $bucketName = CommonUtil::getRedisBucketName();
                $projectID = $request->get('project_id');
                $fileName = Str::random(5) . time();
                $path = "tracker/$projectID/$userID/$fileName.png";
                Storage::disk('s3')->put($path, file_get_contents($file));
            }
        } catch (Exception $e) {
            return $this->serverErrorResponse($e);
        }
    }
}