<?php

namespace App\Http\Controllers;
use App\Models\Like;
use App\Modeels\User;
use App\Models\Picture;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class PictureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $param=$request->query('search');
        if($param)
        {
            $picture=Picture::where('title','like','%' . $param . '%')
            ->orWhere('description','like','%' . $param . '%')->get();
            return response()->json($picture, 200);
        }else {
        $picture=Picture::All();
         return response()->json($picture, 200);
        }
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
      //  return response()->json(Auth::user());


    $validator = Validator::make($request->all(), [
        'title' => 'required|max:255',
        'description' => 'required|max:1000',
        'image' => 'required|image|mimes:jpeg,png,jpg,|max:2048',
    ],

    ['title.required'=>'Vous devez saisir un titre',
    'description.required'=>'Vous devez saisir une description',
    'image.required'=>'Vous devez ajouter une image',
    'image.image'=>'la photo n\'a pas eu etre telechargees ',
    'image.mimes'=>'Seuls les formats jpeg, png sont autorisés',
    'image.max'=>'Votre photo doit faire maximum 2048 ko',
 ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 401);
    }
        $picture= new Picture();
        $picture->title=$request->title;
        $picture->description=$request->description;

        $fileName = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $request->file('image')->getClientOriginalExtension();
        $file = $fileName.'_'.time().'.'.$extension;
        $filePath = $request->file('image')->storeAs('public/uploads', $file);
        $picture->image = basename($filePath);
     //   $picture->image = $request->file('image')->storeAs('public/uploads', basename($file));
        $picture->user_id =Auth::user()->id;
        //Auth::user()->id;
        // Auth::user()->id;
        $picture->save();
        if( $picture->save()){
            return response()->json(['message' => 'Ajouter avec succes.'], 200);
    } else{
        return response()->json(['message' => 'echec d\'envois'], 401);
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
        $picture = Picture::findOrFail($id);

        return response()->json($picture,200);


    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    $picture = Picture::findOrFail($id);
    $picture->title = $request->title;
    $picture->description = $request->description;
   // $picture->image = $request->file('image')->store('public/uploads');
    $picture->user_id = 2;
    $picture->save();

         return response()->json(['message' => 'Mise à jour effectuée avec succès.'], 200);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $picture = Picture::findOrFail($id);
             $picture->delete();
        return response()->json("supprimer avec succes",200);
    }




    public function checklike($id){
        $picture=Picture::findOrFail($id);
             if(Auth::user()){
               $like=Like::where('picture_id',$picture->id)->where('user_id',Auth::user()->id)->first();
                 if($like)
                 {

                     return response()->json(true,200);
                    }else{


                   return response()->json(false,200);
                    }
    }

    }
     public function handlelike($id){
        $picture=Picture::findOrFail($id);
             if(Auth::user()){
               $like=Like::where('picture_id',$picture->id)->where('user_id',Auth::user()->id)->first();
                 if($like)
                 {
                    $like->delete();
                     return response()->json([ 'success'=>'Picture Unliked'],200);
                    }else{

                        $like=new Like();
                        $like->picture_id=$picture->id;
                        $like->user_id=Auth::user()->id;
                        $like->save();
                        return response()->json(['success'=>'Picture like'],200);
                    }
         }

    }
}
