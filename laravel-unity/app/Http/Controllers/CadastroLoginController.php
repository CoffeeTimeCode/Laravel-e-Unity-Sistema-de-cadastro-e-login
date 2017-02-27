<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Validator;

class CadastroLoginController extends Controller
{
    public function cadastro(Request $request)
    {
      $validator = Validator::make($request->all(),[
        'name' =>     'required',
        'email' =>    'required|email|unique:users',
        'password' => 'required|min:6',
      ]);

      if($validator->fails()){
        return response()->json(['status'=>false,'errors'=>$validator->errors()->all()]);
      }else{
        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();
        return response()->json(['status'=>true,'user'=>$user]);
      }
    }

    public function login()
    {
      # code...
    }
}
