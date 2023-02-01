<?php

namespace App\Http\Controllers\Tracker;

use App\Http\Controllers\Controller;
use Centroall\Helper\Models\Project;
use Centroall\Helper\Models\ProjectDeveloper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class ProjectController extends Controller
{
    /**
     * Project List api
     *
     * @return \Illuminate\Http\Response
    */
    public function show()
    {
        try {

            /* Get All ProjectData */
            $project = Project::all();

            return $this->response('SUCCESS','Projects List successfully.',$project);
        } catch (\Exception $e) {
            return $this->serverErrorResponse($e);
        }
    }

    /**
     * Project Get api
     *
     * @return \Illuminate\Http\Response
    */
    public function getProject($project_id)
    {
        try {
            
            /* Id wise Project Get */
            $project = Project::find($project_id);
    
            if (empty($project)) {
                return $this->response('RECORD_NOT_FOUND','Project Not Found.');
            }

            return $this->response('SUCCESS','Project Get successfully.',$project);
        } catch (\Exception $e) {
            return $this->serverErrorResponse($e);
        }
    }


    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'name' => 'required|unique:projects,name',
            ]);

            if($validator->fails()){
                return $this->response('VALIDATION_ERROR',$validator->errors());
            }

            $project = new Project();
            $project->name = $request->name;
            $project->pm_id = $request->pm_id;
            $project->parent_project_id = $request->parent_project_id;
            $project->type = $request->type;
            $project->delivery_date = $request->delivery_date;
            $project->estimated_days = $request->estimated_days;
            $project->status = $request->status;
            $project->created_by = $request->created_by;
            if($project->save()){
                
                // $projectId = explode(',',$request->project_id);
                // foreach ($projectId as $value) {
                // }
                    $project_dev = new ProjectDeveloper();
                    $project_dev->user_id = Auth::user()->id;
                    $project_dev->project_id = $project->id;
                    $project_dev->created_by = Auth::user()->id;
                    
                
                if($project_dev->save()){
                    return $this->response('SUCCESS','Project Store successfully.',$project);
                }else {
                    return $this->response('FAILURE', "Something went wrong");
                }
            }else{
                return $this->response('FAILURE', "Something went wrong");
            }

        } catch (\Exception $e) {
            return $this->serverErrorResponse($e->getMessage());
        }
    }

    public function update(Request $request , $project_id)
    {
        try {
            $validator = Validator::make($request->all(),[
                'name' => 'required|unique:projects,name',
            ]);

            if($validator->fails()){
                return $this->response('VALIDATION_ERROR',$validator->errors());
            }

            $project = Project::find($project_id);
            $project->name = $request->name;
            $project->pm_id = $request->pm_id;
            $project->parent_project_id = $request->parent_project_id;
            $project->type = $request->type;
            $project->delivery_date = $request->delivery_date;
            $project->estimated_days = $request->estimated_days;
            $project->status = $request->status;
            $project->created_by = $request->created_by;
            if($project->save()){
                return $this->response('SUCCESS','Project Update successfully.',$project);
            }else{
                return $this->response('FAILURE', "Something went wrong");
            }

        } catch (\Exception $e) {
            return $this->serverErrorResponse($e->getMessage());
        }
    }

    public function delete($project_id)
    {
        try {
            $project = Project::find($project_id);
            if($project){
                $project->is_delete = 1;
                $project->delete();
                return $this->response('SUCCESS','Project Delete successfully.');
            }
            return $this->response('FAILURE', "Something went wrong");

        } catch (\Exception $e) {
            return $this->serverErrorResponse($e);
        }
    }
}
