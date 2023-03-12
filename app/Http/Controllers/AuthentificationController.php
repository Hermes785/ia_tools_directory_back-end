<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class AuthentificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

     $validator= Validator::make($request->all(),[
      'name'=>['required','string','max:150','min:3'],
      'email'=>['required','string','email','max:150','min:8','unique:users'],
      'password'=>['required','string','min:8'],
      'confirm_password'=>['required','same:password']],

      ['name.required'=>'Vous devez saisir un nom',
        'email.required'=>'vous devez saisir votre email',
        'email.unique'=>'cet email existe deja',
        'password.min'=>'votre password doit contenir au moins 8 caractere',
        'confirm_password.required'=>'Vous devez confirmez votre mot de passe',
        'confirm.password.same'=>' Mot de de passe differrent, vous devez saisir un meme mot de passe.'

     ]);
     if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 401);
    }

        $user=new User();
        $user->email=$request->email;
        $user->name=$request->name;
        $user->password=bcrypt($request->password);
        //$user->confirm_password=bcrypt($user->confirm_password);
        $user->api_token=Str::random(60);

        $user->save();

        return response()->json($user);
    }

    public function login(Request $request) {


        $validator= Validator::make($request->all(),[
            'email'=>['required','string','email'],
            'password'=>['required','string'],
           ],

            [
              'email.required'=>'vous devez saisir votre email',
              'password.required'=>'votre devez saisir votre mot de passe',


           ]);
           if ($validator->fails()) {
              return response()->json([
                  'errors' => $validator->errors()
              ], 401);
          }

        $email = $request->input('email');
        $password = $request->input('password');
//
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = User::where('email', $email)->firstOrFail();
            return response()->json($user);
        } else {
            //le second parametre signal au navigateure de considere ceci comme une erreur.....
            return response()->json(['errors' => ' Identifiants_incorectes'], 401);
        }
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
