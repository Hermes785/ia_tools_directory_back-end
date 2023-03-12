<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function redirect($provider){
        return Socialite::driver($provider)->redirect();
     }

    public function callback($provider)
    {
        // Récupère les informations utilisateur à partir du fournisseur d'authentification tiers
       $getInfo=Socialite::driver($provider)->user();
        // Appelle la méthode createuser pour créer un nouvel utilisateur ou récupérer un utilisateur existant
           $user = $this->createuser($getInfo, $provider);

           // Connecte l'utilisateur et redirige vers la page d'accueil
              auth()->login($user);
         return redirect()->to('http://localhost:3000/login/google'.$user->api_token);
    }

     // Vérifie si un utilisateur avec cet ID existe déjà
         function creatuser($getInfo,$provider){
            $user=User::where('provider_id',$getInfo->id)-first();
            if(!$user){
                $user=new User();
                $user->name=$getInfo->name;
                 $user->email=$getInfo->email;
                 $user->provider=$getInfo->provider;
                 $user->api_token=Str::random(60);
                 $user->save();
            }
              return $user;
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
        //
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
