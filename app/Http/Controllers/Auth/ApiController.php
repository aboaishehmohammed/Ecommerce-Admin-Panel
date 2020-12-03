<?php


namespace App\Http\Controllers\Auth;

use App\models\User;
use App\UserFcm;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiController
{
    public $successStatus = 200;

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();

            $success['token'] = $user->createToken('MyApp')->accessToken;
            return response()->json($success, $this->successStatus);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function validateEmail(Request $request)
    {
        // هاي بتقدر تستخدمها وهو بعمل register تشيك اذا الايميل متخدم او لا
        $users = User::where("email", '=', $request->email)->get();
        if (sizeof($users) > 0) {
            $re = [
                "valid" => false,
                "data" => [
                    "message" => "Email",
                ]
            ];
        } else {
            $re = [
                "valid" => true,
                "data" => [
                    "message" => "Email",
                ]
            ];
        }
        return $re;
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',


            'password' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 403);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);


        $success['token'] = $user->createToken('MyApp')->accessToken;

        return response()->json($success, $this->successStatus);
    }
    public function logout(Request $request)
    {
        if ($request->has("fcmToken")) {
            UserFcm::where('user_id', '=', auth()->user()->id)->where('token', '=', $request->fcmToken)->delete();
        }

        $user = Auth::user()->token();
        $user->revoke();
        //auth()->logout();

    }
}
