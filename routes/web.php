<?php

use Illuminate\Http\Request;
use App\Http\Resources\JadwalResource;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/key', function () use ($router) {
    return str_random(32);
});

$router->group(['prefix' => 'api'], function() use ($router) {

	// Latihan Diskon
	$router->get('/asupkeunjadwal/{periode}', function($periode){

	        // Truncate the table
			$periodena = $periode;
	        $requestJadwal = App\Master_Jadwal::where('periode', $periodena)->pluck('id_jadwal')->toArray();
	        $delete = App\Master_Jadwal::whereIn('id_jadwal', $requestJadwal)->delete();
	        $url = 'http://115.124.86.218/aiw/jadwal/'. $periodena;
	        $json = file_get_contents($url);
	        $jadwals = collect(json_decode($json, true));
	        
	        // dd($jadwals['data'][1]['jadwal']); // Ieu bisa
	        // return view('test-api', compact('jadwals'));
	        $test = $jadwals['data'];
	        $count = count($test);
	        if (!empty($test)) {    
	            for ($i=0; $i < $count ; $i++) { 
	                foreach ($jadwals['data'][$i]['jadwal'] as $key => $diskon) {
	                    $data['id_jadwal'] = $diskon['id'];
	                    $data['promo'] = $diskon['promo'];
	                    $data['tgl_berangkat'] = $diskon['tgl_berangkat'];
	                    $data['jam_berangkat'] = $diskon['jam_berangkat'];
	                    $data['rute_berangkat'] = $diskon['rute_berangkat'];
	                    $data['pesawat_berangkat'] = $diskon['pesawat_berangkat'];
	                    $data['tgl_pulang'] = $diskon['tgl_pulang'];
	                    $data['jam_pulang'] = $diskon['jam_pulang'];
	                    $data['rute_pulang'] = $diskon['rute_pulang'];
	                    $data['pesawat_pulang'] = $diskon['pesawat_pulang'];
	                    $data['maskapai'] = $diskon['maskapai'];
	                    $data['jml_hari'] = $diskon['jml_hari'];
	                    $data['seat_total'] = $diskon['seat_total'];
	                    $data['seat_terpakai'] = $diskon['seat_terpakai'];
	                    $data['sisa'] = $diskon['sisa'];
	                    $data['passpor'] = $diskon['passpor'];
	                    $data['moffa'] = $diskon['moffa'];
	                    $data['visa'] = $diskon['visa'];
	                    $data['status'] = $diskon['status'];
	                    $data['tgl_manasik'] = $diskon['tgl_manasik'];
	                    $data['jam_manasik'] = $diskon['jam_manasik'];
	                    $data['itinerary'] = $diskon['itinerary'];
	                    $data['paket'] = json_encode($diskon['paket']);
	                    $data['periode'] = $periodena;
	                    $validator = DB::table('master_jadwals')->where('id_jadwal', '=', $diskon['id'])->first();
	                    if ($validator) {
	                        DB::table('master_jadwals')->where('id_jadwal', $validator->id)->update($data);
	                    }else{
	                        DB::table('master_jadwals')->insert($data);
	                    }
	                }
	            }
	        }

	});

	$router->get('/testCron', function(){

	        $followup = DB::table('master_reminder')->where('notifikasi', 'followup')->first();
	        $jamaahBerangkat = DB::table('master_reminder')->where('notifikasi', 'jamaah_berangkat')->first();
	        $jamaahPulang = DB::table('master_reminder')->where('notifikasi', 'jamaah_pulang')->first();
	        $sinkronisasi = DB::table('master_reminder')->where('notifikasi', 'sinkronisasi')->first();

	        echo 'ini '. $followup->cron .'<br>';
	        echo 'ini '. $jamaahBerangkat->cron .'<br>';
	        echo 'ini '. $jamaahPulang->cron .'<br>';
	        echo 'ini '. $sinkronisasi->cron .'<br>';
	});

	$router->get('/diskonkantor', function(){
	    
	        $url = 'http://115.124.86.218/aiw/pendaftaran/1440';
	        $json = file_get_contents($url);
	        $diskons = collect(json_decode($json, true));
	        
	        // dd($diskons['data'][1]['jadwal']); // Ieu bisa
	        // return view('test-api', compact('diskons'));
	        $test = $diskons['data'];
	        $count = count($test);
	        // $itungPaket = $diskons['data'][0]['jadwal'][0]['paket'];
	        // $countPaket = count($test);
	        echo "<a href='/api/sync'>Sync to database</a>";
	        echo $count;
	        echo "<table border='1'>
	                    <tr>
	                            <td>Pax</td>
	                            <td>Tgl Daftar</td>
	                            <td>Id Umrah</td>
	                            <td>Id Jamaah</td>
	                            <td>Tgl Keberangkatan</td>
	                            <td>Nama jamaah</td>
	                            <td>Staff</td>
	                            <td>Id Marketing</td>
	                            <td>Diskon Kantor</td>
	                            <td>Diskon Marketing</td>
	                            <td>Fee koordinator</td>
	                            <td>Fee marketing</td>
	                    </tr>";
	        for ($i=0; $i < $count ; $i++) { 
	            $itung = count($diskons['data'][$i]['pendaftaran']);
	            foreach($diskons['data'][$i]['pendaftaran'] as $key => $diskon)
	                {
	                    
	                    echo "
	                    <tr>
	                        <td>". $itung ."</td>
	                        <td>". $diskon['tgl_pendaftaran'] ."</td>
	                        <td>". $diskon['id_umrah'] ."</td>
	                        <td>". $diskon['id_jamaah'] ."</td>
	                        <td>". $diskon['tgl_keberangkatan'] ."</td>
	                        <td>". $diskon['nama_jamaah'] ."</td>
	                        <td>". $diskon['staf_kantor'] ."</td>
	                        <td>". $diskon['id_marketing'] ."</td>
	                        <td>". $diskon['diskon_kantor'] ."</td>
	                        <td>". $diskon['diskon_marketing'] ."</td>
	                        <td>". $diskon['fee_koordinator'] ."</td>
	                        <td>". $diskon['fee_marketing'] ."</td>
	                    </tr>";   
	                }
	        }
	        echo "</table>";

	        // $itungPaket = $diskons['data'][0]['jadwal'][0]['paket']; 
	        // for ($i=0; $i < $count ; $i++) { 
	        //     foreach ($diskons['data'][$i]['pendaftaran'] as $key => $diskon) {
	        //         echo json_encode($i);
	        //         echo json_encode($diskon['id_marketing']);
	        //         echo json_encode($diskon['diskon_marketing']);
	        //         echo json_encode($diskon['diskon_kantor']);
	        //     }
	        // }
	});

	// Latihan Diskon
	$router->get('/sync', function(){
	        $url = 'http://115.124.86.218/aiw/pendaftaran/1440';
	        $json = file_get_contents($url);
	        $diskons = collect(json_decode($json, true));
	        
	        // dd($diskons['data'][1]['jadwal']); // Ieu bisa
	        // return view('test-api', compact('diskons'));
	        $test = $diskons['data'];
	        $count = count($test);

	        for ($i=0; $i < $count ; $i++) { 
	            foreach ($diskons['data'][$i]['pendaftaran'] as $key => $diskon) {
	                $data['tgl_pendaftaran'] = $diskon['tgl_pendaftaran'];
	                $data['id_umrah'] = $diskon['id_umrah'];
	                $data['id_jamaah'] = $diskon['id_jamaah'];
	                $data['nama_jamaah'] = $diskon['nama_jamaah'];
	                $data['tgl_keberangkatan'] = $diskon['tgl_keberangkatan'];
	                $data['staf_kantor'] = $diskon['staf_kantor'];
	                $data['id_marketing'] = $diskon['id_marketing'];
	                $data['diskon_kantor'] = $diskon['diskon_kantor'];
	                $data['diskon_marketing'] = $diskon['diskon_marketing'];
	                $data['fee_koordinator'] = $diskon['fee_koordinator'];
	                $data['fee_marketing'] = $diskon['fee_marketing'];
	                $validator = DB::table('master_pendaftaran')->where('id_jamaah', '=', $diskon['id_jamaah'])->first();
	                if ($validator) {
	                    DB::table('master_pendaftaran')->where('id', $validator->id)->update($data);
	                }else{
	                    DB::table('master_pendaftaran')->insert($data);
	                //     DB::table('master_pendaftaran')->insert([   
	                //     'tgl_pendaftaran' => $diskon['tgl_pendaftaran'],
	                //     'id_umrah' => $diskon['id_umrah'],
	                //     'id_jamaah' => $diskon['id_jamaah'],
	                //     'nama_jamaah' => $diskon['nama_jamaah'],
	                //     'tgl_keberangkatan' => $diskon['tgl_keberangkatan'],
	                //     'staf_kantor' => $diskon['staf_kantor'],
	                //     'id_marketing' => $diskon['id_marketing'],
	                //     'diskon_kantor' => $diskon['diskon_kantor'],
	                //     'diskon_marketing' => $diskon['diskon_marketing'],
	                //     'fee_koordinator' => $diskon['fee_koordinator'],
	                //     'fee_marketing' => $diskon['fee_marketing']
	                // ]);
	                }
	            }
	        }
	        return redirect()->back();

	});

	//test api jadwal
	$router->get('/test-api', 'API\JadwalController@test');

	// // List users 
	// $router->get('users', 'UserController@index');

	// // list users by id
	// $router->get('users/{id}', 'UserController@show');

	// // post users
	// $router->post('users', 'UserController@store');
	// $router->delete('users/delete/{id}', 'UserController@destroy');

	// Agen/Anggota API Route
	$router->get('/agen', 'API\AgenControllerAPI@index');
	$router->post('/agen', 'API\Auth\AnggotaControllerAPI@register');
	$router->post('/agen/login', 'API\Auth\AnggotaControllerAPI@login');
	$router->get('/agen/{id}/show', 'API\AgenControllerAPI@show');
	$router->put('/agen/{id}/edit', 'API\AgenControllerAPI@update');
	$router->post('/agen/{id}/updatephoto', 'API\AgenControllerAPI@profile');
	// $router->post('/post', 'API\AgenControllerAPI@profile');
	$router->delete('/agen/{id}/delete', 'API\AgenControllerAPI@destroy');
	$router->get('/agen/{id}/subagen', 'API\AgenControllerAPI@retrieveMySubAgen');

	// Agen Retrieving by approved's account.
	$router->get('/agen/approved', 'API\AgenControllerAPI@retrieveByApproved');

	// Jamaah API Route
	$router->get('/jamaah', 'API\JamaahControllerAPI@index');
	$router->post('/jamaah', 'API\JamaahControllerAPI@store');
	$router->get('/jamaah/{id}/agen/{tahun}/periode', 'API\JamaahControllerAPI@retrieveByAgen');
	$router->get('/jamaah/{id}/agenfee/potensi/{tahun}/periode', 'API\JamaahControllerAPI@feeByAgenPotensi');
	$router->get('/jamaah/{id}/agenfee/komisi/{tahun}/periode', 'API\JamaahControllerAPI@feeByAgenKomisi');
	$router->get('/jamaah/{id}/koordinatorfee/potensi/{tahun}/periode', 'API\JamaahControllerAPI@feeByKoordinatorFeePotensi');
	$router->get('/jamaah/{id}/koordinatorfee/komisi/{tahun}/periode', 'API\JamaahControllerAPI@feeByKoordinatorKomisi');
	$router->get('/jamaah/{id}/koordinator', 'API\JamaahControllerAPI@retrieveByKoordinator');

	$router->get('/jamaah/{id}/koordinator/potensi/{tahun}/periode', 'API\JamaahControllerAPI@koordinatorPotensi');
	$router->get('/jamaah/{id}/koordinator/komisi/{tahun}/periode', 'API\JamaahControllerAPI@koordinatorKomisi');
	$router->get('/jamaah/{id}/agen/potensi/{tahun}/periode', 'API\JamaahControllerAPI@agenPotensi');
	$router->get('/jamaah/{id}/agen/komisi/{tahun}/periode', 'API\JamaahControllerAPI@agenKomisi');
	$router->get('/jamaah/{id}/agen/total/{tahun}/periode', 'API\JamaahControllerAPI@totalJamaahByAgen');
	$router->get('/jamaah/{id}/agen/berangkat/{tahun}/periode', 'API\JamaahControllerAPI@retrieveJamaahBerangkatByAgen');
	$router->get('/jamaah/{id}/agen/pulang/{tahun}/periode', 'API\JamaahControllerAPI@retrieveJamaahPulangByAgen');
	$router->get('/jamaah/{id}/agen/bulan/{tahun}/periode', 'API\JamaahControllerAPI@totalJamaahByTheMonth');
	$router->get('/jamaah/{id}/agenfee/bulan/{tahun}/periode', 'API\JamaahControllerAPI@feeAgenByTheMonth');
	$router->get('/jamaah/{id}/koordinatorfee/bulan/{tahun}/periode', 'API\JamaahControllerAPI@feeByKoordinatorFeeKomisi');
	$router->get('/jamaah/totalByPeriode/{idperiode}', 'API\JamaahControllerAPI@totalByPeriode');

	// Retrieve Jadwal
	$router->get('/jadwal/{periode}', function($request){
		$requestna = $request;
	    return JadwalResource::collection(App\Master_Jadwal::orderBy('tgl_berangkat', 'ASC')->where('periode', $requestna)->get());
	});

	// Prospek API Route
	$router->get('/prospek', 'API\ProspekControllerAPI@index');
	$router->get('/prospek/{id}/agen', 'API\ProspekControllerAPI@retrieveByAgen');
	$router->post('/prospek', 'API\ProspekControllerAPI@store');
	$router->get('/prospek/{id}/show', 'API\ProspekControllerAPI@show');
	$router->delete('/prospek/{id}/delete', 'API\ProspekControllerAPI@destroy');
	$router->put('/prospek/{id}/edit', 'API\ProspekControllerAPI@update');
	$router->put('/prospek/{id}/bayar', 'API\ProspekControllerAPI@bayar');
	$router->get('/prospek/{id}/agen/total', 'API\ProspekControllerAPI@totalProspekByAgen');
	// $router->get('/prospek/{id}/koordinator/total', 'API\ProspekControllerAPI@totalProspekByKoordinator');

	// Kalkulasi API Route
	$router->get('/kalkulasi', 'API\MasterKalkulasiControllerAPI@index');
	$router->put('/kalkulasi/{id}/edit', 'API\MasterKalkulasiControllerAPI@update');

	// Master Brosur API Route with resource
	// $router->resource('brosur', 'API\MasterBrosurControllerAPI'); // DEPRECIATED

	// FAQ's Route
	$router->get('/faq', 'API\FAQControllerAPI@index');

	// Galleriess' Route
	$router->get('/gallery', 'API\GalleryControllerAPI@index');
	$router->get('/gallery/dashboard', 'API\GalleryControllerAPI@retrieveByDashboard');
	$router->get('/gallery/foto', 'API\GalleryControllerAPI@retrieveByFoto');
	$router->get('/gallery/video', 'API\GalleryControllerAPI@retrieveByVideo');

	// Hotel's API's Route 
	$router->get('/hotel/{kota}', 'API\MasterHotelControllerAPI@retrieveHotelByKota');
	$router->get('/hotel/{id}/show', 'API\MasterHotelControllerAPI@retrieveHotelByKotaDetail');
	$router->get('/hotel/{id}/foto', 'API\MasterHotelControllerAPI@retrieveFotoByHotel');
	$router->get('/hotel/{id}/video', 'API\MasterHotelControllerAPI@retrieveVideoByHotel');

	// Master Notifikasi's API Route
	$router->get('/notif/{id}/delivered', 'API\MasterNotifikasiControllerAPI@retrieveByDelivered');
	$router->get('/notif/{id}/read', 'API\MasterNotifikasiControllerAPI@retrieveByRead');
	$router->put('/notif/{id}/edit', 'API\MasterNotifikasiControllerAPI@markAsRead');
	$router->put('/notif/{id}/clear', 'API\MasterNotifikasiControllerAPI@markAsReadAll');

	// Master Periode API
	$router->get('/periode', 'API\PeriodeControllerAPI@index');

	// Master Sapaan API
	$router->get('/sapaan', 'API\SapaanControllerAPI@index');

	// Login API
	$router->post('login', 'API\Auth\AnggotaControllerAPI@login');
	$router->post('register', 'API\Auth\AnggotaControllerAPI@register');

	// Check Auth
	$router->post('details', 'API\Auth\AnggotaControllerAPI@details');


	// Logout
	$router->post('logout', 'API\Auth\AnggotaControllerAPI@logout');

	$router->group(['middleware' => 'auth:api'], function(){
	});

	// Reset Password API

	$router->post('/password/email', 'API\Auth\ForgotPasswordControllerAPI@getResetToken');
	$router->post('/password/reset', 'API\Auth\ResetPasswordControllerAPI@reset');

});
