<?php

namespace App\Http\Controllers\API;

use App\LIFF\LINEAPI;
use Carbon\Carbon;
use App\Exports\LineExport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Yoyakubi;


class LineController extends Controller
{
    public function __construct() {

    }

    public function line_friends(Request $request)
    {
        $today = Carbon::now()->format('Ymd');
        
        $channelAccessToken = config('services.line.message.channel_token');
        $channelSecret = config('services.line.message.channel_secret');
        $client = new LINEAPI($channelAccessToken, $channelSecret);
        $next = $request->next;
        $data = [];
        $followers = $client->getFollowersIds($next);
        $users = [];
        $chats = [];
        foreach($followers->userIds as $index => $userId) {
            // if($index < 10) {
                $users[] = $client->getProfile($userId);
            // }
        }

        if($request->has('action')) {
            // dd('download');
            $collection = collect($users);

            $excelData = $collection->map(function ($user) {
                return collect($user)
                    ->only(['displayName', 'pictureUrl'])
                    ->all();
            });

            return Excel::download(new LineExport(collect($excelData)), 'Line_Friends.xlsx');
    
        }

        

        $followersCount = $client->getFollowersCount($today);
        return response()->json([
            'status' => 'success',
            'data' => $users,
            'next' => isset($followers->next)?$followers->next:'',
            'followersCount' => $followersCount->followers,
            'chats' => $chats,
            'current' => isset($next)?$next:''
        ], 200);
    }
}
