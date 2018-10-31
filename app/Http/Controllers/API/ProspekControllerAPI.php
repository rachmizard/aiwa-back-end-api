<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin;
use App\Prospek;
use App\Jamaah;
use App\User;
use App\Periode;
use App\Http\Resources\ProspekResource;
use Validator;
use Notification;
use App\Notifications\ProspekNewNotification;

class ProspekControllerAPI extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProspekResource::collection(Prospek::orderBy('id', 'DESC')->with('anggota')->paginate(100000));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function retrieveByAgen($id)
    {
        return ProspekResource::collection(Prospek::orderBy('updated_at', 'DESC')->where(['anggota_id' => $id, 'pembayaran' => 'BELUM'])->get());
    }

    public function totalProspekByAgen(Request $request, $id)
    {
        $totalProspekByAgen = Prospek::where('anggota_id', '=', $id)->where('pembayaran', '!=', '1')->count();
        $success['nama'] =  'prospek';
        $success['total'] =  $totalProspekByAgen;
        return response()->json(['response' => $success]);
    }

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
        // $validator = Validator::make($request->all(), [
        //     'anggota_id' => 'required',
        //     'pic' => 'required',
        //     'no_telp' => 'required',
        //     'jml_dewasa' => 'required',
        //     'jml_infant' => 'required',
        //     'jml_balita' => 'required',
        //     'jml_visa' => 'required',
        //     'jml_balita_kasur' => 'required',
        //     'tgl_keberangkatan' => 'required',
        //     'jenis' => 'required',
        //     'dobel' => 'required',
        //     'triple' => 'required',
        //     'quard' => 'required',
        //     'passport' => 'required',
        //     'meningitis' => 'required',
        //     'pas_foto' => 'required',
        //     'buku_nikah' => 'required',
        //     'fc_akta' => 'required',
        //     'visa_progresif' => 'required',
        //     'diskon' => 'required',
        //     'keterangan' => 'required',
        //     'tanggal_followup' => 'required',
        //     'pembayaran' => 'required',
        //     'perlengkapan_balita' => 'required',
        //     'perlengkapan_dewasa' => 'required',

        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['error'=>$validator->errors()], 401);            
        // }

        $prospek = $request->isMethod('put') ? Prospek::findOrFail($request->id) : new Prospek;
        $prospek->index_paket = $request->input('index_paket');
        $prospek->index_jadwal = $request->input('index_jadwal');
        $prospek->anggota_id = $request->input('anggota_id');
        $prospek->pic = $request->input('pic');
        $prospek->no_telp = $request->input('no_telp');
        $prospek->jml_dewasa = $request->input('jml_dewasa');
        $prospek->jml_infant = $request->input('jml_infant');
        $prospek->jml_balita = $request->input('jml_balita');
        $prospek->jml_visa = $request->input('jml_visa');
        $prospek->jml_balita_kasur = $request->input('jml_balita_kasur');
        $prospek->tgl_keberangkatan = $request->input('tgl_keberangkatan');
        $prospek->jenis = $request->input('jenis');
        $prospek->dobel = $request->input('dobel');
        $prospek->triple = $request->input('triple');
        $prospek->quard = $request->input('quard');
        $prospek->passport = $request->input('passport');
        $prospek->meningitis = $request->input('meningitis');
        $prospek->pas_foto = $request->input('pas_foto');
        $prospek->buku_nikah = $request->input('buku_nikah');
        $prospek->fc_akta = $request->input('fc_akta');
        $prospek->visa_progresif = $request->input('visa_progresif');
        $prospek->diskon = $request->input('diskon');
        $prospek->keterangan = $request->input('keterangan');
        $prospek->tanggal_followup = $request->input('tanggal_followup');
        $prospek->pembayaran = $request->input('pembayaran');
        $prospek->perlengkapan_balita = $request->input('perlengkapan_balita');
        $prospek->perlengkapan_dewasa = $request->input('perlengkapan_dewasa');
        if ($prospek->save()) {
            $admin = Admin::find(1);
            $admin->notify(new ProspekNewNotification($prospek));
            return response()->json(['success' => 'Berhasil di tambahkan!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // $prospek = Prospek::findOrFail($request->id);
        return new ProspekResource(Prospek::findOrFail($request->id));
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
        $prospek = $request->isMethod('put') ? Prospek::findOrFail($id) : new Prospek;
        $prospek->index_paket = $request->input('index_paket');
        $prospek->index_jadwal = $request->input('index_jadwal');
        $prospek->anggota_id = $request->input('anggota_id');
        $prospek->pic = $request->input('pic');
        $prospek->no_telp = $request->input('no_telp');
        $prospek->jml_dewasa = $request->input('jml_dewasa');
        $prospek->jml_infant = $request->input('jml_infant');
        $prospek->jml_balita = $request->input('jml_balita');
        $prospek->jml_visa = $request->input('jml_visa');
        $prospek->jml_balita_kasur = $request->input('jml_balita_kasur');
        $prospek->tgl_keberangkatan = $request->input('tgl_keberangkatan');
        $prospek->jenis = $request->input('jenis');
        $prospek->dobel = $request->input('dobel');
        $prospek->triple = $request->input('triple');
        $prospek->quard = $request->input('quard');
        $prospek->passport = $request->input('passport');
        $prospek->meningitis = $request->input('meningitis');
        $prospek->pas_foto = $request->input('pas_foto');
        $prospek->buku_nikah = $request->input('buku_nikah');
        $prospek->fc_akta = $request->input('fc_akta');
        $prospek->visa_progresif = $request->input('visa_progresif');
        $prospek->diskon = $request->input('diskon');
        $prospek->keterangan = $request->input('keterangan');
        $prospek->tanggal_followup = $request->input('tanggal_followup');
        $prospek->pembayaran = $request->input('pembayaran');
        $prospek->perlengkapan_balita = $request->input('perlengkapan_balita');
        $prospek->perlengkapan_dewasa = $request->input('perlengkapan_dewasa');
        if ($prospek->update()) {
            return response()->json(['success' => 'Berhasil di edit!']);
        }
    }

    public function bayar(Request $request, $id)
    {

        $reference = 2250000;

        $statusPembayaran = 1; // Menyatakan status sudah di DP
        $prospek = $request->isMethod('put') ? Prospek::findOrFail($id) : new Prospek;
        $prospek->pembayaran = $statusPembayaran;
        $prospek->update();
        
        // $pax = $prospek->jml_dewasa+$prospek->jml_infant+$prospek->jml_balita+$prospek->jml_balita_kasur;
        // $pic = $prospek->pic;
        // $anggota_id = $prospek->anggota_id;
        // $findKoordinator = User::find($anggota_id);
        // if ($prospek->update()) {
        //     for ($i=0; $i < $pax ; $i++) { 
        //         if ($findKoordinator->koordinator == 0 ) {
        //             $jamaah = Jamaah::create([
        //                 'nama' => $pic . '_' . $i,
        //                 'marketing' => $anggota_id,
        //                 'marketing_fee' => $reference,
        //                 'koordinator' => 0,
        //                 'koordinator_fee' => 0,
        //                 'top' => 1,
        //                 'top_fee' => $reference,
        //                 'status' => 'POTENSI'
        //             ]);
        //         }else if($findKoordinator->koordinator == 1)
        //         {
        //             $totalLevel2 = $reference - $findKoordinator->fee_reguler;
        //             $jamaah = Jamaah::create([
        //                 'nama' => $pic . '_' . $i,
        //                 'marketing' => $anggota_id,
        //                 'marketing_fee' => $findKoordinator->fee_reguler,
        //                 'koordinator' => $findKoordinator->koordinator,
        //                 'koordinator_fee' => $totalLevel2 ,
        //                 'top' => 1,
        //                 'top_fee' => $totalLevel2 ,
        //                 'status' => 'POTENSI'
        //             ]);                    
        //         }else{
        //             $totalLevel3 = $reference - ($findKoordinator->fee_reguler + 250000);
        //             $jamaah = Jamaah::create([
        //                 'nama' => $pic . '_' . $i,
        //                 'marketing' => $anggota_id,
        //                 'marketing_fee' => $findKoordinator->fee_reguler,
        //                 'koordinator' => $findKoordinator->koordinator,
        //                 'koordinator_fee' => $totalLevel3,
        //                 'top' => 1,
        //                 'top_fee' => 250000,
        //                 'status' => 'POTENSI'
        //             ]);
        //         }
        //     }
        //     return response()->json(['success' => 'Berhasil di edit pembayaran!']);
        // }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $prospek = Prospek::findOrFail($request->id);
        if ($prospek->delete()) {
            return response()->json(['success' => 'Berhasil di hapus!']);
        }
    }
}
