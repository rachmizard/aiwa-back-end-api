<?php

namespace App\Http\Controllers\API;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
Use App\Http\Resources\User as UserResource;
use Illuminate\Support\Collection;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get users
        $users = User::paginate(15);

        // return collection of users
        return UserResource::collection($users);
    }

    public function test(Request $request)
    {
        $url = 'http://115.124.86.218/aiw/jadwal/1440';
        $json = file_get_contents($url);
        $jadwals = collect(json_decode($json, true));
        
        // dd($jadwals['data'][1]['jadwal']); // Ieu bisa
        // return view('test-api', compact('jadwals'));
        $test = $jadwals['data'];
        $count = count($test);
        $itungPaket = $jadwals['data'][0]['jadwal'][0]['paket'];
        $countPaket = count($itungPaket);
        // for ($i=0; $i < $countPaket ; $i++) { 
        //     foreach ($jadwals['data'][$i] as $key) {
        //         dd($key);
        //     }
        // }
        // $itungPaket = $jadwals['data'][0]['jadwal'][0]['paket'];
        // foreach ($itungPaket as $hasilPaket) {
        //     // dd($hasilPaket['kamar']);
        // }
        return view('test-api', compact('jadwals', 'test', 'count','countPaket'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->isMethod('put') ? User::find($request->user_id) : new User;
        $user->id = $request->input('user_id');
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        $user->remember_token = str_random(10);

        if ($user->save()) {
            return new UserResource($user);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return new UserResource($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user->delete()) {
            return new UserResource($user);
        }
    }
}
