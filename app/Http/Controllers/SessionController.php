<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function index(Request $request){
      echo json_encode($request->session()->all());
      return view('home');
    }

    public function setSingle(Request $request){
      $request->session()->put('name','kmh');
      return redirect('/')->with('status','Successfully Set Single Session.');
    }

    public function getSingle(Request $request){
        // $name=$request->session()->get('name');
        // $name=$request->session()->get('age');
        $name=$request->session()->get('data');
          return redirect('/')->with('status',$name);
    }

    public function delSes(Request $request){
      $request->session()->flush();
      return view('home');
    }

    public function setMultiple(Request $request){
      $data=['1'=>"one",'2'=>"two",'3'=>'three'];
      $request->session()->put('data',json_encode(array($data)));
      // $request->session()->put(['email'=>'kmh@gmail.com','age'=>'18']);
      return redirect('/')->with('status','Successfully Set Multiple Session');
    }
}
