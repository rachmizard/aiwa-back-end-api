<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Periode;
use App\Http\Resources\PeriodeResource;

class PeriodeControllerAPI extends Controller
{
    public function index()
    {
    	return PeriodeResource::collection(Periode::all());
    }
}
