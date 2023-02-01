<?php

namespace App\Http\Controllers;

use Centroall\Helper\Models\WebTracking;
use Centroall\Helper\Models\EmployeeDetail;
use Centroall\Helper\Utils\CommonUtil;
use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class WebTrackingController extends Controller
{
    public function getWebTracking(Request $request)
    {
        try {
            // $date = new DateTime("now", new DateTimeZone('Asia/Kolkata'));
            // $localDate = $date->format('Y-m-d h:i:s');

            $today_web_trackings = WebTracking::where('user_id', 1)->whereDate('created_at', date('Y-m-d'))->first();
            // $today_web_trackings = WebTracking::where('user_id', ComonUtil::getRedisUserID())->whereDate('created_at', date('Y-m-d'))->first();

            // if (empty($today_web_trackings)) {
            //     return $this->response('RECORD_NOT_FOUND', "User web clocking data not found");
            // }

            // $activity = json_decode($today_web_trackings->activity);
            // $lastActivityData = empty($activity) ? null : end($activity);

            return $this->response('SUCCESS', "Last activity data get successfully", json_encode($today_web_trackings));
        } catch (Exception $e) {
            return $this->serverErrorResponse($e);
        }
    }

    public function saveWebTracking(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'type' => 'required|in:clock-in,clock-out',
                'latitude' => 'required|regex:/^(-?\d+(\.\d+)?)$/',
                'longitude' => 'required|regex:/^(-?\d+(\.\d+)?)$/',
                'activity_memo' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return $this->response('VALIDATION_ERROR', $validator->errors()->first());
            }

            $type = $request->type;
            $activityMemo = $request->get('activity_memo');
            $currentTime = time();

            $webTracking = WebTracking::where('user_id', CommonUtil::getRedisUserID())->whereDate('created_at', date('Y-m-d'))->first();

            if (empty($webTracking)) {
                if ($type != 'clock-in') {
                    return $this->response('VALIDATION_ERROR', 'You have to be clocked in first.');
                }

                $webTracking = new WebTracking();
                $webTracking->user_id = CommonUtil::getRedisUserID();
                $webTracking->ip_address = $request->ip();
                $webTracking->total = 0;
                $webTracking->latitude = $request->latitude;
                $webTracking->longitude = $request->longitude;

                $activityArray = [
                    "activity" => [
                        [
                            "memo" => $activityMemo,
                            "start" => $currentTime,
                            "end" => null
                        ]
                    ],
                    "recent_activity_type" => $type,
                ];

                $webTracking->activity = json_encode($activityArray);
            } else {
                $oldWebTrackingActivities = json_decode($webTracking->activity, true);
                $oldActivities = $oldWebTrackingActivities['activity'];
                // return $oldActivities;

                if ($type == 'clock-in') {
                    $tPolicy = EmployeeDetail::with('tracker_productivity')->where("user_id", CommonUtil::getRedisUserID())->first();
                    $ignoreOutPunchMins = empty($tPolicy->tracker_productivity) ? 5 : $tPolicy->tracker_productivity->ignore_out_punch_mins;
                    $ignoreOutPunchTime = (empty($ignoreOutPunchMins) ? 5 : $ignoreOutPunchMins) * 60;

                    end($oldActivities);
                    $lastExistingActivityKey = key($oldActivities);
                    reset($oldActivities);

                    if (!empty($oldActivities[$lastExistingActivityKey]['end']) && ($currentTime - ((int)$oldActivities[$lastExistingActivityKey]['end'])) < $ignoreOutPunchTime) {
                        $oldActivities[$lastExistingActivityKey]['end'] = null;
                    } else {
                        $oldActivities[] = [
                            'memo' => $activityMemo,
                            'start' => $currentTime,
                            'end' => null
                        ];
                    }
                } else {
                    end($oldActivities);
                    $startTime = $oldActivities[key($oldActivities)]['start'];
                    $oldActivities[key($oldActivities)]['end'] = $currentTime;
                    reset($oldActivities);
                }

                $timeDiff = 0;
                foreach ($oldActivities as $key => $value) {
                    $value['end'] = empty($value['end']) ? $currentTime : $value['end'];
                    $timeDiff = $timeDiff + (((int)$value['end']) - ((int)$value['start']));
                }

                $webTracking->total = $timeDiff;

                $oldWebTrackingActivities['activity'] = $oldActivities;
                $oldWebTrackingActivities['method'] = 'centroall_web_clock_in_out';
                $oldWebTrackingActivities['recent_activity_type'] = $type;

                $webTracking->activity = json_encode($oldWebTrackingActivities);
            }

            if ($webTracking->save()) {
                $msg = $type == 'clock-in' ? 'User clocked in successfully.' : 'User clocked out successfully.';
                return $this->response('SUCCESS', $msg, json_encode($webTracking));
            }
            return $this->response('FAILURE', 'Something  went wrong, please try again.');
        } catch (Exception $e) {
            return $this->serverErrorResponse($e);
        }
    }
}
