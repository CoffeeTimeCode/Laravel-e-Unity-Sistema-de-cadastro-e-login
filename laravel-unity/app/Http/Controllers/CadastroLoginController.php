<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Validator;

use Auth;

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

    public function login(Request $request)
    {
      $validator = Validator::make($request->all(),[
        'email'=>'required|email',
        'password'=>'required|min:6'
      ]);

      if($validator->fails()){
        return response()->json(['status'=>false,'errors'=>$validator->errors()->all()]);
      }else{
        if(Auth::attempt($request->all())){
          return response()->json(['status'=>true,'user'=>Auth::user()]);
        }else{
          return response()->json(['status'=>false,'errors'=>['Senha ou email incorretos.']]);
        }
      }
    }
}
