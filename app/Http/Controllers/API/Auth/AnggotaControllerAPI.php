<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Admin;
use App\Periode;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Notifications\ApproveAgenNotification;
use Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AnggotaControllerAPI extends Controller
{    

    public $successStatus = 200;

    public function login(Request $request)
    {
        $user = User::where('username', $request->input('username'))->first();
        if (Hash::check($request->input('password'), $user->password)) {
            $user = User::where(['username' => $request->input('username')])->first();
            $getId = $user['id'];
            if (!$user->status == 0) {
                // Default value for now periode as defined.
                // $nowJing = Carbon::now()->format('Y-m-d');
                // $tahunNow = Carbon::create(2018, 1, 31);$now = Carbon::now();
                // $tahunAyeuna = Carbon::now();
                // $year = $tahunAyeuna->year;
                // $month = $tahunAyeuna->month;
                // $day = $tahunAyeuna->day;
                // $tahunNow = Carbon::create($year, $month, $day);
                // $period = Periode::whereBetween('start', [$tahunNow->copy()->startOfYear(), $tahunNow->copy()->endOfYear()])->first();
                $tahunActive = Periode::where('status_periode', 'active')->first();
                $success['token'] =  $tahunActive['judul'];
                // $user->createToken('nApp')->accessToken
                $refreshDeviceToken = User::findOrFail($getId);
                $refreshDeviceToken->update(['device_token' => $request->input('device_token')]);
                $success['status'] =  'success';
                return response()->json(['response' => $success,
                                        'user' => $user], $this->successStatus);        
            }else{
                $response['token'] = null;
                $response['status'] = 'unverified';
                return response()->json(['response' => $response]);
            }
        }
        else{
            $response['token'] = null;
            $response['status'] = 'failed';
            return response()->json(['response'=> $response]);
        }
    } 

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required|email',
            'username' => 'required',
            'password' => 'required',
            'jenis_kelamin' => 'required',
            'no_ktp' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'status' => 'required',
            'koordinator' => 'required',
        ]);

        if ($validator->fails()) {
            $success['status'] = 'invalid';
            return response()->json(['response' => $success]);            
        }

        // $toAdmins = Admin::all();
        // $admin = $toAdmin->id;
        // $anggota = Admin::find(2);
        // $anggota->notify(new ApproveAgenNotification($anggota->id));
        
        // Validator of email
        $emailValidation = User::where('email', request('email'))->get();
        $usernameValidation = User::where('username', request('username'))->get();
        if (count($emailValidation) > 0) {
            $success['token'] = null;
            // $success['nama'] =  null;
            $success['status'] =  'email';
            return response()->json(['response'=>$success]);
        }else if(count($usernameValidation) > 0)
        {       
            $success['token'] = null;
            $success['status'] =  'user';
            return response()->json(['response'=> $success]);
        }else
        {
            $length = 10;
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $input = $request->all();
            $input['id'] = $randomString;
            $input['password'] = bcrypt($input['password']);
            $input['device_token'] = $request->input('device_token');
            $user = User::create($input);
            
            $admin = Admin::find(1);
            $admin->notify(new ApproveAgenNotification($user));
            // $success['token'] =  $user->createToken('nApp')->accessToken;
            // $success['nama'] =  $user->nama;
            $success['device_token'] = $request->input('device_token');
            $success['status'] =  'success';

            return response()->json(['response'=>$success], $this->successStatus);
        }
    }

    public function details()
    {
        $user = Auth::user();
        $success['status'] = 'You are Authorized!';
        return response()->json(['response' => $success,
                                'user' => $user], $this->successStatus);
    }

    public function logout(Request $request)
    {
        // $setNull = User::find($request->input('id'));
        //  if ($setNull) {
        //     $setNull->update(['device_token' => null]);
        //     $status['token'] =  null;
        //     $status['status'] =  'success';
        //  }else{
        //     $user = 'failed';
        //  }
        $status['token'] =  null;
        $status['status'] =  'success';
        return response()->json(['response' => $status]);   
    }

}
