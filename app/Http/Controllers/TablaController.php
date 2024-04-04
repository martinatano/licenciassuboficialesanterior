<?php

namespace App\Http\Controllers;
use Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\Settings;

class TablaController extends Controller
{
    function index(){
        try{
            $client = new Client(['verify' => false]);
            //aca podria llamar a una api para usar
            // $request = $client -> get(url);
            // $response = json_decode($request-> getBody()->getContents())
            return view('form');
        } catch(RequestException $e){
            return null;
        }
    }
    function tabla(){
        try{
            return view('tabla');
        } catch(RequestException $e){
            return null;
        }
    }
    function envio(){
        try{
            $client = new Client(['verify' => false]);
            $request = $client -> get('http://localhost:5800/');
            $response = json_decode($request->getBody()->getContents(), true);

            return view('tabla', ['licencias' => ['licencias' => $response['licencias']]]);
        } catch(RequestException $e){
        return null ;
        }
    }

    /*function procesarForm(Request $request){
        $dni = Request::input('dni');
        $id = Request::input('id');
        $fechaInicio = Request:: input('fechaInicio');
        $fechaFin = Request:: input('fechaFin');
        $tipo = Request:: input('tipoLicencia');
        $provincia = Request:: input('provincia');
        $direccion = Request:: input('direccion');
        $localidad = Request:: input('localidad');
        $ordenDia = Request:: input('ordenDia');

        try{
            $client  = new Client(['verify' => false]);
            $request = $client -> get('http://localhost:5800/insert/');
            $response = json_decode($request->getBody()->getContents(), true);
            return json_encode($response);
        }catch(RequestException $e){
            return $e->getMessage();
        }
    }*/
}