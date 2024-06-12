<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class AuthController extends Controller
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required',
            'password'  => 'required'
        ]);
        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        // get credentials from request
        $credentials = $request->only('email', 'password');
        // if auth failed
        if(!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password Anda salah'
            ], 401);
        }
        $user = Auth::guard('api')->user();
        
        if($user->status == 'inactive')
        {
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda Di Nonaktifkan Hubungi Admin'
            ], 401);
        }
        //if auth success
        return response()->json([
            'success' => true,
            'user'    => auth()->guard('api')->user(),    
            'token'   => $token   
        ], 200);
    }

    public function changePassword(Request $request)
    {
        return response()->json($request->all);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nim'       => 'required|min:8|unique:users',
            'name'      => 'required|string',
            'email'     => 'required|string|email|unique:users',
            'password'  => 'required',
            'password_confirmation' => 'required|same:password',
        ]);
        if($validator->fails())
        {
            return response()->json($validator->errors(), 422);
        }
        $data = User::create([
            'uuid'      => Uuid::uuid4()->toString(),
            'nim'       => $request->nim,
            'name'      => $request->name,
            'phone'     => '-',
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
        ]);

        if($data)
        {
            return response()->json([
                'success' => true,
            ], 200);
        }else{
            return response()->json([
                'success' => false,
            ], 500);
        }
    }    
}
