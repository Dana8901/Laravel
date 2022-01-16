<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\City; 
use App\Models\Country; 
use App\Models\Place; 

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class PlaceController extends Controller
{
    private $place;

    public function __construct(Place $place)
    {
        $this->place = $place;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {            
            $result['data'] = DB::select('SELECT co.name AS nameCountry, ci.name AS nameCity, pl.name AS nameLocation,
            co.idcountry, ci.idcity, pl.idplace
            FROM country co
            INNER JOIN city ci ON co.idcountry = ci.idcountry
            INNER JOIN place pl ON pl.idcity = ci.idcity
            ORDER BY co.name, ci.name, pl.name');
        } catch (\Exception $e) {
            $result['status'] = 'error';
            $result['error'] = $e->getMessage();
        }
        return $result;
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {     
            $result = ["status" => "success"];
            $result["message"] =
                "Place success"; 
            
            $atributes = collect($request);
            $place = new Place();
            $place->name = $atributes['name'];            
            $place->idcity = $atributes['idcity'];            
            $place->save(); 
            $result["data"] = $place;
        } catch (\Exception $e) {
            $result["status"] = "error";
            $result["error"] = $e->getMessage();
        }
        return $result;
    }

    public function storeFile(Request $request)
    {
        try {     
            $result = ["status" => "success"];
            $result["message"] =
                "Place success";  
            
            $atributes = collect($request);
            
            echo($atributes);
            
        } catch (\Exception $e) {
            $result["status"] = "error";
            $result["error"] = $e->getMessage(); 
        }
        return $result;
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
