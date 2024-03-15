<?php

namespace App\Http\Controllers;
use Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

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
}
