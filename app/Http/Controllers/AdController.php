<?php

namespace App\Http\Controllers;

use App\Ad;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class AdController extends Controller
{
    /*
     * @return Response
     */
    public function listAds()
    {
        $ads = Ad::all()->sortBy('created_at');
        return response()->json($ads, 200);
    }

    /**
     * Store a new ad.
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function storeAd(Request $request)
    {
        $ad = new Ad;
        $ad->user_id = $this->getUserId($request);
        $ad->title = $request->input('title');
        $ad->description = $request->input('description');
        $ad->price = $request->input('price');

        $ad->save();
        return response()->json(['ad_id'=> $ad->id], 200);
    }

    /**
     * Update the specified user.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function updateAd(Request $request, $id)
    {
        $userId = $this->getUserId($request);
        $update = Ad::where('user_id', $userId)
            ->where('id', $id)
            ->update(
                [
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'price' => $request->input('price')
                ]
            );

        if ($update) {
            return response()->json(['Ad updated'], 200);
        }

        return response()->json(['there has been an error'], 404);
    }

    private function getUserId(Request $request)
    {
        $token = $request->header('Authorization');
        $user = User::where('api_token', $token)->first();
        return $user->id;
    }
}
