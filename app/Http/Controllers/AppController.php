<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppController extends Controller
{
    public function getCommuneOfProvince()
    {
        $province = $_POST['province'];
        $communes = DB::select("SELECT distinct district from burundizipcodes where region='" . $province . "'");
        return response()->json($communes);
    }

    public function quartierOfCommune()
    {
        $commune = $_POST['commune'];
        $communes = DB::select("SELECT distinct city from burundizipcodes where district='" . $commune . "'");
        return response()->json($communes);
    }
}
