<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Post;

class LogsController extends Controller
{
    public function index($gusermail)
    {
        try {
            $user = User::where('g_username', $gusermail)->first();
            if (isset($user->provider_id)) {
                $logs = Post::where('provider_id', $user->provider_id)
                    ->where('is_latest', '1')
                    ->where('delete', '0')
                    ->orderBy('updated_at', 'desc')
                    ->get();

                if ($logs) {
                    $logs = collect($logs)->map(function ($item) {
                        $data               = $item->toArray();
                        $data['updated_at'] = $item->updated_at->diffForHumans();
                        return $data;
                    });
                   
                }
             return ['status' => '1', "collection" => $logs];
            }
            return ['status' => '0', "error" => '404'];
        } catch (Exception $e) {
            return json(['status' => '0', 'error' => $e]);
        }

    }
}
