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


use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


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
        /* try {     
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
        return $result; */
        try {     
            $result = ["status" => "success"];
            $result["message"] =
                "Place success"; 

            $atributes = collect($request);

            if (Place::where('name', '=', $atributes['name'])->where('idcity', '=', $atributes['idcity'])->exists()) { 
                $result = ["status" => "warning"];
                $result["message"] =
                    "Place already exists";
            } 
            else{
                $place = new Place();
                $place->name = $atributes['name'];            
                $place->idcity = $atributes['idcity'];            
                $place->save(); 
                $result["data"] = $place;
            }  
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
            
            $img = $request->file('file');  
             
            $filename = $img->getClientOriginalName();
            $img->storeAs('app/txt/', $filename);             
            
            if ($file = fopen(storage_path('app\\txt\\'.$filename), "r")) {
                $idcountry = '';
                $idcity = '';
                while(!feof($file)) {
                    $lines = fgets($file); 
                    $line = str_replace('+', ':', $lines);
                    
                    if(Str::startsWith($line, 'COUNTRY'))
                    {
                        $line1 = Str::of($line)->explode(':');
                        $val = substr($line1[1], 0, strlen($line1[1])-2);
                        if (Country::where('name', '=', $val)->exists()) {                            
                            $country = Country::where('name', '=', $val)->first();
                            $idcountry = $country->idcountry;
                        } 
                        else{
                            $country = new Country();                        
                            $country->name = $val;            
                            $country->save(); 
                            $idcountry = $country->idcountry; 
                        }                        
                    }
                   if(Str::startsWith($line, 'CITY'))
                    {
                        $line1 = Str::of($line)->explode(':');
                        $val = substr($line1[1], 0, strlen($line1[1])-2);
                        if (City::where('name', '=', $val)->exists()) {                            
                            $city = City::where('name', '=', $val)->first();
                            $idcity = $city->idcity;
                        } 
                        else{
                            $city = new City();
                            $city->name = $val;          
                            $city->idcountry = $idcountry;            
                            $city->save();
                            $idcity = $city->idcity; 
                        }                          
                    }

                    if(Str::startsWith($line, 'LOCATION'))
                    {
                        $line1 = Str::of($line)->explode(':');
                        $val = substr($line1[1], 0, strlen($line1[1])-2);
                        if (Place::where('name', '=', $val)->exists()) {                            
                            $place = Place::where('name', '=', $val)->first();
                            $idplace = $place->idplace;                            
                        } 
                        else{
                            $place = new Place();
                            $place->name = $val;          
                            $place->idcity = $idcity;            
                            $place->save(); 
                        }                                             
                    }  
                }
                fclose($file);
            }  

            
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
