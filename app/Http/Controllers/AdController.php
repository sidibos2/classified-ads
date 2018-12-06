<?php

namespace App\Http\Controllers;

use App\Ad;
use App\User;
use \Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;

class AdController extends Controller
{
    use ValidatesRequests;

    /*
     * @return Response
     */
    public function listAds()
    {
        $ads = DB::table('ads')->orderBy('id', 'desc')->get();
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
        if (!$this->validInput($request->input())) {
            return response()->json(['response'=> 'there has been an error'], 400);
        }

        $ad = new Ad;
        $ad->user_id = $this->getUserId($request);
        $ad->title = $request->input('title');
        $ad->description = $request->input('description');
        $ad->price = $request->input('price');

        $ad->save();
        return response()->json(['response'=> 'Inserted Id ' . $ad->id], 200);
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
        if (!$this->validInput($request->input())) {
            return response()->json(['response'=> 'there has been an error'], 400);
        }

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
            $this->shareOnSocialMedia();
            return response()->json(['response'=>'Ad updated'], 200);
        }

        return response()->json(['response' => 'there has been an error'], 404);
    }

    private function getUserId(Request $request)
    {
        $token = $request->header('Authorization');
        $user = User::where('api_token', $token)->first();
        return $user->id;
    }

    private function shareOnSocialMedia()
    {
        sleep(1);
    }

    private function validInput(array $input)
    {
        $validationRules = $this->getInputValidationRules();
        $validator = Validator::make($input, $validationRules);

        return !$validator->fails();
        if ($validator->fails()) {
            return response()->json(['response'=> 'there has been an error'], 400);
        }
    }

    private function getInputValidationRules()
    {
        return [
            'title' => 'required|min:5|max:250',
            'description' => 'required|min:5',
            'price'=> 'required|numeric',
        ];
    }
}
