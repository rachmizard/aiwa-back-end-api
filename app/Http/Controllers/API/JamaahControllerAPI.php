<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jamaah;
use App\User;
use App\Periode;
use App\Http\Resources\JamaahResource;
use App\Http\Resources\CountOfMarketingFeeResource;
use DB;
use Carbon\Carbon;
use Input;  

class JamaahControllerAPI extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Jamaah $jamaah)
    {
        return JamaahResource::collection(Jamaah::orderBy('id', 'DESC')->with('anggota')->paginate(25));
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

    public function retrieveByAgen(Request $request, $id, $tahun)
    {   
        $varJay = Periode::where('judul', $tahun)->first();
        $startDateJing = $varJay['start'];
        $endDateJing = $varJay['end'];
        $futureJamaah = Jamaah::orderBy('tgl_berangkat', 'asc')->where('marketing', $id)->whereDate('tgl_berangkat', '>', Carbon::now()->format('Y-m-d'))->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->get();
        $pastJamaah = Jamaah::orderBy('tgl_berangkat', 'desc')->where('marketing', $id)->whereDate('tgl_berangkat', '<', Carbon::now()->format('Y-m-d'))->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->get();
        $jamaah = $futureJamaah->merge($pastJamaah);
        return JamaahResource::collection($jamaah);
    }

    public function feeByAgenPotensi(Request $request, $id, $tahun)
    {
        $varJay = Periode::where('judul', $tahun)->first();
        $startDateJing = $varJay['start'];
        $endDateJing = $varJay['end'];
        $countTopPotensi =  DB::table('jamaah')->where(['top' => $id, 'status' => 'POTENSI'])->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('top_fee');
        $countFee = DB::table('jamaah')->where(['marketing' => $id, 'status' => 'POTENSI'])->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('marketing_fee');
        $countFeeByKoordinatorPotensi = DB::table('jamaah')->where('koordinator', $id)->where('status', '=', 'POTENSI')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('koordinator_fee');
         $success['nama'] =  'potensi';
         $success['total'] =  $countFee + $countFeeByKoordinatorPotensi + $countTopPotensi;
        return response()->json(['response' => $success]); 
    }

    public function feeByAgenKomisi(Request $request, $id, $tahun)
    {
        $varJay = Periode::where('judul', $tahun)->first();
        $startDateJing = $varJay['start'];
        $endDateJing = $varJay['end'];
        $countTopKomisi =  DB::table('jamaah')->whereRaw("status != 'POTENSI' and top = ? ", [$id])->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('top_fee');
        $endDateJing = $varJay['end'];
        $countFeeByAgenKomisi = DB::table('jamaah')->where('marketing', $id)->where('status', '!=', 'POTENSI')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('marketing_fee');
        $countFeeByKoordinatorKomisi = DB::table('jamaah')->where('koordinator', $id)->where('status', '!=', 'POTENSI')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('koordinator_fee');
         $success['nama'] =  'komisi';
         $success['total'] =  $countFeeByAgenKomisi + $countFeeByKoordinatorKomisi + $countTopKomisi;
        return response()->json(['response' => $success]);   
    }

    public function retrieveByKoordinator(Request $request, $id)
    {
        return JamaahResource::collection(Jamaah::where('koordinator', $id)->get());
    }

    public function feeByKoordinatorFeePotensi(Request $request, $id, $tahun)
    {
        $varJay = Periode::where('judul', $tahun)->first();
        $startDateJing = $varJay['start'];
        $endDateJing = $varJay['end'];
        // $countFeeByKoordinatorPotensi = DB::table('jamaah')->where('top', $id)->where('status', '=', 'POTENSI')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('top_fee');
        $countFeeByKoordinatorPotensi = DB::table('jamaah')->whereRaw("status = 'POTENSI' and top = ? ",[$id])->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('top_fee');
         $success['nama'] =  'potensi';
         $success['total'] =  $countFeeByKoordinatorPotensi;
        return response()->json(['response' => $success]);  
    }

    public function feeByKoordinatorKomisi(Request $request, $id, $tahun)
    {
        $varJay = Periode::where('judul', $tahun)->first();
        $startDateJing = $varJay['start'];
        $endDateJing = $varJay['end'];
        $countFeeByKoordinatorKomisi = DB::table('jamaah')->whereRaw("status != 'POTENSI' and top = ? ",[$id])->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('top_fee');
         $success['nama'] =  'komisi';
         $success['total'] =  $countFeeByKoordinatorKomisi;
        return response()->json(['response' => $success]); 
    }

    public function koordinatorPotensi(Request $request, $id, $tahun)
    {
        $varJay = Periode::where('judul', $tahun)->first();
        $startDateJing = $varJay['start'];
        $endDateJing = $varJay['end'];
        // return JamaahResource::collection(Jamaah::where('top', $id)->where('status', '=', 'POTENSI')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->get()); // teu jalan
        return JamaahResource::collection(Jamaah::whereRaw("status = 'POTENSI' and top = ?",[$id])->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->orderBy('updated_at', 'DESC')->get());    

    }

    public function koordinatorKomisi(Request $request, $id, $tahun)
    {
        $varJay = Periode::where('judul', $tahun)->first();
        $startDateJing = $varJay['start'];
        $endDateJing = $varJay['end'];
        // return JamaahResource::collection(Jamaah::where('top', $id)->where('status', '!=', 'POTENSI')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->get()); // teu jalan
        return JamaahResource::collection(Jamaah::whereRaw("status != 'POTENSI' and top = ?",[$id])->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->orderBy('updated_at', 'DESC')->get());    

    }

    public function agenPotensi(Request $request, $id, $tahun)
    {
        $varJay = Periode::where('judul', $tahun)->first();
        $startDateJing = $varJay['start'];
        $endDateJing = $varJay['end'];    
        return JamaahResource::collection(Jamaah::whereRaw("status = 'POTENSI' and (marketing = ? or koordinator = ?)",[$id, $id])->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->orderBy('updated_at', 'DESC')->get());    
    }

    public function agenKomisi(Request $request, $id, $tahun)
    {
        $varJay = Periode::where('judul', $tahun)->first();
        $startDateJing = $varJay['start'];
        $endDateJing = $varJay['end'];
        return JamaahResource::collection(Jamaah::whereRaw("status != 'POTENSI' and (marketing = ? or koordinator = ?)",[$id, $id])->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->orderBy('updated_at', 'DESC')->get());      
    }

    public function totalJamaahByAgen(Request $request, $id, $tahun)
    {
        $varJay = Periode::where('judul', $tahun)->first();
        $startDateJing = $varJay['start'];
        $endDateJing = $varJay['end'];
        $countTotalJamaahByAgen = DB::table('jamaah')->where('marketing', $id)->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->count();
        $success['nama'] =  'jamaah';
        $success['total'] =  $countTotalJamaahByAgen;
        return response()->json(['response' => $success]);
    }

    public function totalJamaahByTheMonth(Request $request, $id, $tahun)
    {
        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;
        $day = $now->day;

        $varJay = Periode::where('judul', $tahun)->first();
        $startDateJing = $varJay['start'];
        $endDateJing = $varJay['end'];
        // Count of each month
        $countJanuary = DB::table('jamaah')->where('marketing', $id)->whereMonth('tgl_berangkat', '01')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->get();
        $countFebruary = DB::table('jamaah')->where('marketing', $id)->whereMonth('tgl_berangkat', '02')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->get();
        $countMarch = DB::table('jamaah')->where('marketing', $id)->whereMonth('tgl_berangkat','03')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->get();
        $countApril = DB::table('jamaah')->where('marketing', $id)->whereMonth('tgl_berangkat','04')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->get();
        $countMei = DB::table('jamaah')->where('marketing', $id)->whereMonth('tgl_berangkat','05')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->get();
        $countJune = DB::table('jamaah')->where('marketing', $id)->whereMonth('tgl_berangkat', '06')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->get();
        $countJuly = DB::table('jamaah')->where('marketing', $id)->whereMonth('tgl_berangkat', '07')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->get();
        $countAugust = DB::table('jamaah')->where('marketing', $id)->whereMonth('tgl_berangkat', '08')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->get();
        $countSeptember = DB::table('jamaah')->where('marketing', $id)->whereMonth('tgl_berangkat', '09')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->get();
        $countOctober = DB::table('jamaah')->where('marketing', $id)->whereMonth('tgl_berangkat', '10')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->get();
        $countNovember = DB::table('jamaah')->where('marketing', $id)->whereMonth('tgl_berangkat', '11')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->get();
        $countDecember = DB::table('jamaah')->where('marketing', $id)->whereMonth('tgl_berangkat', '12')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->get();
        $success['january'] =  $countJanuary->count();
        $success['february'] =  $countFebruary->count();
        $success['march'] =  $countMarch->count();
        $success['april'] =  $countApril->count();
        $success['mei'] =  $countMei->count();
        $success['june'] =  $countJune->count();
        $success['july'] =  $countJuly->count();
        $success['august'] =  $countAugust->count();
        $success['september'] =  $countSeptember->count();
        $success['october'] =  $countOctober->count();
        $success['november'] =  $countNovember->count();
        $success['december'] =  $countDecember->count();
        return response()->json(['response' => $success]);

    }

    public function feeAgenBytheMonth(Request $request, $id, $tahun)
    {
        $varJay = Periode::where('judul', $tahun)->first();
        $startDateJing = $varJay['start'];
        $endDateJing = $varJay['end'];
        $countFeeByKoordinatorJanuary = DB::table('jamaah')->where('marketing', $id)->where('status', '!=', 'POTENSI')->whereMonth('tgl_berangkat', '01')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('marketing_fee');
        $countFeeByKoordinatorFebruary = DB::table('jamaah')->where('marketing', $id)->where('status', '!=', 'POTENSI')->whereMonth('tgl_berangkat', '02')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('marketing_fee');
        $countFeeByKoordinatorMarch = DB::table('jamaah')->where('marketing', $id)->where('status', '!=', 'POTENSI')->whereMonth('tgl_berangkat', '03')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('marketing_fee');
        $countFeeByKoordinatorApril = DB::table('jamaah')->where('marketing', $id)->where('status', '!=', 'POTENSI')->whereMonth('tgl_berangkat', '04')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('marketing_fee');
        $countFeeByKoordinatorMei = DB::table('jamaah')->where('marketing', $id)->where('status', '!=', 'POTENSI')->whereMonth('tgl_berangkat', '05')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('marketing_fee');
        $countFeeByKoordinatorJune = DB::table('jamaah')->where('marketing', $id)->where('status', '!=', 'POTENSI')->whereMonth('tgl_berangkat', '06')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('marketing_fee');
        $countFeeByKoordinatorJuly = DB::table('jamaah')->where('marketing', $id)->where('status', '!=', 'POTENSI')->whereMonth('tgl_berangkat', '07')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('marketing_fee');
        $countFeeByKoordinatorAugust = DB::table('jamaah')->where('marketing', $id)->where('status', '!=', 'POTENSI')->whereMonth('tgl_berangkat', '08')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('marketing_fee');
        $countFeeByKoordinatorSeptember = DB::table('jamaah')->where('marketing', $id)->where('status', '!=', 'POTENSI')->whereMonth('tgl_berangkat', '09')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('marketing_fee');
        $countFeeByKoordinatorOctober = DB::table('jamaah')->where('marketing', $id)->where('status', '!=', 'POTENSI')->whereMonth('tgl_berangkat', '10')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('marketing_fee');
        $countFeeByKoordinatorNovember = DB::table('jamaah')->where('marketing', $id)->where('status', '!=', 'POTENSI')->whereMonth('tgl_berangkat', '11')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('marketing_fee');
        $countFeeByKoordinatorDecember = DB::table('jamaah')->where('marketing', $id)->where('status', '!=', 'POTENSI')->whereMonth('tgl_berangkat', '12')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('marketing_fee');
         $success['january'] =  $countFeeByKoordinatorJanuary;
         $success['february'] =  $countFeeByKoordinatorFebruary;
         $success['march'] =  $countFeeByKoordinatorMarch;
         $success['april'] =  $countFeeByKoordinatorApril;
         $success['mei'] =  $countFeeByKoordinatorMei;
         $success['june'] =  $countFeeByKoordinatorJune;
         $success['july'] =  $countFeeByKoordinatorJuly;
         $success['august'] =  $countFeeByKoordinatorAugust;
         $success['september'] =  $countFeeByKoordinatorSeptember;
         $success['october'] =  $countFeeByKoordinatorOctober;
         $success['november'] =  $countFeeByKoordinatorNovember;
         $success['december'] =  $countFeeByKoordinatorDecember;
        return response()->json(['response' => $success]); 
    }

    public function feeByKoordinatorFeeKomisi(Request $request, $id, $tahun)
    {
        $varJay = Periode::where('judul', $tahun)->first();
        $startDateJing = $varJay['start'];
        $endDateJing = $varJay['end'];
        $countFeeByKoordinatorKomisiJanuary = DB::table('jamaah')->where('marketing', $id)->where('status', '!=', 'POTENSI')->whereMonth('tgl_berangkat', '01')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('koordinator_fee');
        $countFeeByKoordinatorKomisiFebruary = DB::table('jamaah')->where('marketing', $id)->where('status', '!=', 'POTENSI')->whereMonth('tgl_berangkat', '02')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('koordinator_fee');
        $countFeeByKoordinatorKomisiMarch = DB::table('jamaah')->where('marketing', $id)->where('status', '!=', 'POTENSI')->whereMonth('tgl_berangkat', '03')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('koordinator_fee');
        $countFeeByKoordinatorKomisiApril = DB::table('jamaah')->where('marketing', $id)->where('status', '!=', 'POTENSI')->whereMonth('tgl_berangkat', '04')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('koordinator_fee');
        $countFeeByKoordinatorKomisiMei = DB::table('jamaah')->where('marketing', $id)->where('status', '!=', 'POTENSI')->whereMonth('tgl_berangkat', '05')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('koordinator_fee');
        $countFeeByKoordinatorKomisiJune = DB::table('jamaah')->where('marketing', $id)->where('status', '!=', 'POTENSI')->whereMonth('tgl_berangkat', '06')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('koordinator_fee');
        $countFeeByKoordinatorKomisiJuly = DB::table('jamaah')->where('marketing', $id)->where('status', '!=', 'POTENSI')->whereMonth('tgl_berangkat', '07')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('koordinator_fee');
        $countFeeByKoordinatorKomisiAugust = DB::table('jamaah')->where('marketing', $id)->where('status', '!=', 'POTENSI')->whereMonth('tgl_berangkat', '08')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('koordinator_fee');
        $countFeeByKoordinatorKomisiSeptember = DB::table('jamaah')->where('marketing', $id)->where('status', '!=', 'POTENSI')->whereMonth('tgl_berangkat', '09')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('koordinator_fee');
        $countFeeByKoordinatorKomisiOctober = DB::table('jamaah')->where('marketing', $id)->where('status', '!=', 'POTENSI')->whereMonth('tgl_berangkat', '10')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('koordinator_fee');
        $countFeeByKoordinatorKomisiNovember = DB::table('jamaah')->where('marketing', $id)->where('status', '!=', 'POTENSI')->whereMonth('tgl_berangkat', '11')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('koordinator_fee');
        $countFeeByKoordinatorKomisiDecember = DB::table('jamaah')->where('marketing', $id)->where('status', '!=', 'POTENSI')->whereMonth('tgl_berangkat', '12')->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->sum('koordinator_fee');
         $success['january'] =  $countFeeByKoordinatorKomisiJanuary;
         $success['february'] =  $countFeeByKoordinatorKomisiFebruary;
         $success['march'] =  $countFeeByKoordinatorKomisiMarch;
         $success['april'] =  $countFeeByKoordinatorKomisiApril;
         $success['mei'] =  $countFeeByKoordinatorKomisiMei;
         $success['june'] =  $countFeeByKoordinatorKomisiJune;
         $success['july'] =  $countFeeByKoordinatorKomisiJuly;
         $success['august'] =  $countFeeByKoordinatorKomisiAugust;
         $success['september'] =  $countFeeByKoordinatorKomisiSeptember;
         $success['october'] =  $countFeeByKoordinatorKomisiOctober;
         $success['november'] =  $countFeeByKoordinatorKomisiNovember;
         $success['december'] =  $countFeeByKoordinatorKomisiDecember;
        return response()->json(['response' => $success]); 
    }

    // public function totalJamaahByKoordinator(Request $request, $id, $tahun)
    // {
    //     $varJay = Periode::where('judul', $tahun)->first();
    //     $startDateJing = $varJay['start'];
    //     $endDateJing = $varJay['end'];
    //     $validator = User::where('status', '=', 1)->where('koordinator', $id)->first();
    //     $countTotalJamaahByKoordinator = DB::table('jamaah')->where('marketing', $validator['id'])->whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])->count();
    //     $success['nama'] =  '';
    //     $success['total'] =  $countTotalJamaahByKoordinator;
    //     return response()->json(['response' => $success]);

    // }

    public function retrieveJamaahBerangkatByAgen(Request $request, $id, $tahun)
    {
        $now = Carbon::now();
        $now->addDays(3);
        $year = $now->year;
        $month = $now->month;
        $day = $now->day;
        $varJay = Periode::where('judul', $tahun)->first();
        $startDateJing = $varJay['start'];
        $endDateJing = $varJay['end'];
        $ref = Jamaah::all();
        foreach ($ref as $value) {
            $hariH = Carbon::now();
            return $retrieveJamaahBerangkatByAgenHariH = JamaahResource::collection(Jamaah::where('marketing', $id)->whereBetween('tgl_berangkat', [$hariH->format('Y').'-'.$hariH->format('m').'-'.$hariH->format('d'), $now->format('Y').'-'.$now->format('m').'-'.$now->format('d')])->whereBetween('created_at', [$startDateJing, $endDateJing])->get());
        }
    }

    public function retrieveJamaahPulangByAgen(Request $request, $id, $tahun)
    {
        $now = Carbon::now();
        $now->addDays(3);
        $year = $now->year;
        $month = $now->month;
        $day = $now->day;
        $varJay = Periode::where('judul', $tahun)->first();
        $startDateJing = $varJay['start'];
        $endDateJing = $varJay['end'];
        $ref = Jamaah::all();
        foreach ($ref as $value) {
            $hariH = Carbon::now();
            return $retrieveJamaahBerangkatByAgenHariH = JamaahResource::collection(Jamaah::where('marketing', $id)->whereBetween('tgl_pulang', [$hariH->format('Y').'-'.$hariH->format('m').'-'.$hariH->format('d'), $now->format('Y').'-'.$now->format('m').'-'.$now->format('d')])->whereBetween('created_at', [$startDateJing, $endDateJing])->get());
        }
    }

    // CHART DASHBOARD
    public function totalByPeriode(Request $request, $idperiode)
    { 
        if ($idperiode) {
            $varJay = Periode::find($idperiode);
            $startDateJing = $varJay->start;
            $endDateJing = $varJay->end;
            $stats = Jamaah::whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])
              ->groupBy(['month', 'number_month'])
              // ->orderBy(DB::raw('DATE_FORMAT(tgl_berangkat, "%M")', 'DESC'))
              ->orderBy('number_month')
              ->get([
                DB::raw('DATE_FORMAT(tgl_berangkat, "%M") as month'),
                DB::raw('MONTH(tgl_berangkat) as number_month'),
                DB::raw('COUNT(*) as value')
              ])
              ->toJSON();
        
        return $stats;
        }else{
            $now = Carbon::now();
            $year = $now->year;
            $month = $now->month;
            $day = $now->day;
            $tahunNow = Carbon::create($year, $month, $day);
            $period = Periode::whereBetween('start', [$tahunNow->copy()->startOfYear(), $tahunNow->copy()->endOfYear()])->first();
            $varJay = Periode::find($period->id);
            $startDateJing = $varJay->start;
            $endDateJing = $varJay->end;
            $stats = Jamaah::whereBetween('tgl_berangkat', [$startDateJing, $endDateJing])
              ->groupBy(['month', 'number_month'])
              // ->orderBy(DB::raw('DATE_FORMAT(tgl_berangkat, "%M")', 'DESC'))
              ->orderBy('number_month')
              ->get([
                DB::raw('DATE_FORMAT(tgl_berangkat, "%M") as month'),
                DB::raw('MONTH(tgl_berangkat) as number_month'),
                DB::raw('COUNT(*) as value')
              ])
              ->toJSON();
            
            return $stats;
        }
    }

    // public function totalPotensi(Request $request)
    // {
        

    //     return $stats;
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $jamaah = $request->isMethod('put') ? Jamaah::findOrFail($request->id) : new Jamaah;
        // $jamaah->id_umrah = $request->input('id_umrah');
        // $jamaah->id_jamaah = $request->input('id_jamaah');
        // $jamaah->tgl_berangkat = $request->input('tgl_berangkat');
        // $jamaah->nama = $request->input('nama');
        // $jamaah->tgl_berangkat = $request->input('tgl_berangkat');
        // $jamaah->tgl_pulang = $request->input('tgl_pulang');
        // $jamaah->maskapai = $request->input('maskapai');
        // $jamaah->marketing = $request->input('marketing');
        // $jamaah->staff = $request->input('staff');
        // $jamaah->no_telp = $request->input('no_telp');
        // $jamaah->fee = $request->input('fee');
        // $jamaah->jumlah_fee = $request->input('jumlah_fee');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }
}
