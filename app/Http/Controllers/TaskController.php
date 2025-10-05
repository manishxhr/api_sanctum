<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class TaskController extends Controller
{
    public function index(){
       $tasks= Task::all();
        if(count($tasks)>0){
            $data=[
                'message'=>count($tasks).' tasks found',
                'status'=>1,
                'data'=>$tasks
            ];
            return response()->json($data,200);
        }
        else{
            $data=[
                'message'=>'no task found',
                'status'=>0,

            ];
            return response()->json($data,200);
        }
    }


     public function create(Request $request){
          $validator = Validator::make($request->all(),[
            'title'=>'required',
            'description'=>'required|string',
        ]);
            if($validator->fails()){
                return response()->json([
                    'message'=>$validator->messages(),
                    'status'=>0,
                ],400); 
                    // $validator->messages(),400);
            }
            else{
               $data=  $validator->validated();
                try{
                    $task=Task::create($data);
                    return response()->json([
                        'message'=>'task created successfully',
                        'status'=>1,
                        'data'=>$task
                    ],200);
                }
                catch(\Exception $error){
                    return response()->json([
                        'message'=>'internal server error',
                        'status'=>0
                    ],500);
                }
            }

    }



    public function show($id){
        $task= Task::find($id);
        
        if(is_null($task)){
            $data=[
                'message'=>'no task found with this id',
                'status'=>0
            ];
        }
        else{
            $data=[
                'message'=>'Task found',
                'status'=>1,
                'data'=>$task
            ];
        }
        return response()->json($data,200);

    }


    public function delete($id){
        $task = Task::find($id);
        if(is_null($task)){
            $data=[
                'message'=>'task not found',
                'status'=>0
            ];
            $code=404;
        }
        else{
            try {
                $task->delete();
                $data=[
                    'message'=>'task deleted successfully',
                    'status'=>1
                ];
                $code=200;
            } catch (\Exception $error) {
                $data=[
                    "message"=>'internal server error',
                    'status'=>0
                ];
                $code=500;

            }
        }
        return response()->json($data,$code);
    }

}
