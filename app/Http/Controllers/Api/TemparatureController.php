<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Http;
use App\Models\TemparatureData;
use Auth;
class TemparatureController extends Controller
{
    //

    public function addTemparature(Request $request){

        $data = $request->all();
    //    dd($data);
    //     // $tempData = HTTP::get("https://api.openweathermap.org/data/2.5/onecall?lat=33.44&lon=-94.04&exclude=hourly,daily&appid=8dc9ba99c4e5fe28f4dc20edbc1848c0");
    
        // $response = HTTP::get('https://api.openweathermap.org/data/2.5/onecall?lat='.$data['lat'].'&lon='.$data['long'].'&exclude=hourly,daily&appid=8dc9ba99c4e5fe28f4dc20edbc1848c0');
        $httpClient = new \GuzzleHttp\Client();
        $request =
            $httpClient
                ->get("https://api.openweathermap.org/data/2.5/onecall?lat=".$data['lat']."&lon=".$data['long']."&exclude=hourly,daily&appid=8dc9ba99c4e5fe28f4dc20edbc1848c0");
                $response = json_decode($request->getBody()->getContents());

        // $user = Auth::user()->id;

        //  return Response::json($user);
        $tempData = new TemparatureData;
        $tempData->temparature = (string)$response->current->temp;
        $tempData->user_id = Auth::user()->id;
        $tempData->save();

        
    }

    public function getTemparatures(Request $request){

        $tempData = TemparatureData::all();


        return response()->json(['allitems'=>$tempData],200);

    }
}
