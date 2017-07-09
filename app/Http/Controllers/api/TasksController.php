<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Meta;
use App\User;
use App\Task;
use Auth;
use Redirect;
use Carbon;

class TasksController extends Controller
{
    public function showTasks($gusermail) {
    	
    	try {
    		
    		$provider_id = User::Select('provider_id')
                                    ->orderBy('updated_at', 'desc')
        							->Where('g_username', $gusermail)
        							->first()->toArray();
			$tasks = Task::Select('*')
									->Where('provider_id', $provider_id['provider_id'])
									->get();
            if ($tasks) {
                $tasks = collect($tasks)->map(function ($item) {
                    $data               = $item->toArray();
                    $data['updated_at'] = $item->updated_at->diffForHumans();
                    return $data;
                });
            }
			return ['status'=>'1' , "collection" =>$tasks ];
        }
        catch (Exception $e) {
      		return json(['status'=>'0','error'=>$e]);
      	}
    }

    public function create(Request $r, $gusermail) {	
    	try {
    		
    		$provider_id = User::Select('provider_id')
        							->Where('g_username', $gusermail)
        							->first()->toArray();
            $task = new Task;

    		$task->provider_id = $provider_id['provider_id'];
    		$task->task = $r->task;
            $task->status = 'open';
            $task->save();
            $id = $task->id;
            $time = Carbon\Carbon::now()->diffForHumans();
    		return(['status'=>'1','elm'=>$task, 'updated_at'=>$time]);
    	} catch (Exception $e) {
    		return(['status'=>'0','error'=>$e]);
    	}
    }

    public function delete(Request $r, $gusermail) {    
        try {
            
            $provider_id = User::Select('provider_id')
                                    ->Where('g_username', $gusermail)
                                    ->first()->toArray();
            
           Task::Where("id",$r->id)
                                ->Where("provider_id",$provider_id['provider_id'])
                                ->delete();

            return(['status'=>'1']);
        } catch (Exception $e) {
            return(['status'=>'0','error'=>$e]);
        }
    }

    public function openUpdate(Request $r, $gusermail) {
        try {
            $time = Carbon\Carbon::now()->diffForHumans();
            $provider_id = User::Select('provider_id')
                                    ->Where('g_username', $gusermail)
                                    ->first()->toArray();
            Task::Where("id",$r->id)
                                ->Where("provider_id",$provider_id['provider_id'])
                                ->update(["status" => "open"]);
            return(['status'=>'1' , 'updated_at' => $time]);
        } catch (Exception $e) {
            return(['status'=>'0','error'=>$e]);
        }

    }

    public function helpUpdate(Request $r, $gusermail) {
        
        try {
            $time = Carbon\Carbon::now()->diffForHumans();
            $provider_id = User::Select('provider_id')
                                    ->Where('g_username', $gusermail)
                                    ->first()->toArray();
            Task::Where("id",$r->id)
                                ->Where("provider_id",$provider_id['provider_id'])
                                ->update(["status" => "help"]);
            return(['status'=>'1' , 'updated_at' => $time]);
        } catch (Exception $e) {
            return(['status'=>'0','error'=>$e]);
        }

    }

    public function closedUpdate(Request $r, $gusermail) {
        
        try {
            $time = Carbon\Carbon::now()->diffForHumans();
            $provider_id = User::Select('provider_id')
                                    ->Where('g_username', $gusermail)
                                    ->first()->toArray();
            Task::Where("id",$r->id)
                                ->Where("provider_id",$provider_id['provider_id'])
                                ->update(["status" => "closed"]);
            return(['status'=>'1' , 'updated_at' => $time]);
        } catch (Exception $e) {
            return(['status'=>'0','error'=>$e]);
        }

    }

}
