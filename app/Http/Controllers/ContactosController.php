<?php

namespace App\Http\Controllers;

use App\Models\Contactos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use JD\Cloudder\Facades\Cloudder;

class ContactosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datos['contactos']=Contactos::paginate(10);
        return view('contactos.index',$datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('contactos.create');
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
 



        //$datosProductos=request()->all();

        $datosContactos=request()->except('_token');

        //------------Cloudinary
        $this->validate($request,[
            'Foto'=>'required|mimes:jpeg,bmp,jpg,png|between:1, 6000',
        ]);

        $image = $request->file('Foto');
        $name = $request->file('Foto')->getClientOriginalName();
        $image_name = $request->file('Foto')->getRealPath();;
        Cloudder::upload($image_name, null);
        list($width, $height) = getimagesize($image_name);
        $image_url= Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height"=>$height]);
        //temporal la de abajo--> obtiene el nombre de la imagen
        $image_name_un= Cloudder::getPublicId();

        //temporal para una consulta de un dato
        //$valoress = contactos::find('Nombre')->where('id','17')->first();
        $valoress = Contactos::where('id',5)
        ->firstOr(['Nombre_foto'],function(){});
        
        //save to uploads directory
        $image->move(public_path("uploads"), $name);
        
        //if ($request->hasfile('Foto')){

        //    $datosProductos['Foto']=$request->file('Foto')->store('uploads','public');
        //}

        //Productos::insert($datosProductos);

        //obetner valores individualmente
        $nombre_nuevo = $request->input('Nombre');
        $apellido_nuevo = $request->input('Apellido');
        $correo_nuevo = $request->input('Correo');
        $fecha_nuevo = $request->input('Fecha');
            //insertar
            Contactos::insert([
        'Nombre'  =>$nombre_nuevo ,
        'Apellido' => $apellido_nuevo,
        'Correo' =>$correo_nuevo ,
        'Fecha' => $fecha_nuevo, 
        'Foto' => $image_url,
        'Nombre_foto'=>$image_name_un]);
        //return response()->json($datosProductos);
        return redirect('contactos')->with('Mensaje','Contacto registrado exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contactos  $contactos
     * @return \Illuminate\Http\Response
     */
    public function show(Contactos $contactos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contactos  $contactos
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $contacto=Contactos::findOrFail($id);

        return view('contactos.edit',compact('contacto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contactos  $contactos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $datosContactos=request()->except(['_token','_method']);

        //---------------img
        $this->validate($request,[
            'Foto'=>'required|mimes:jpeg,bmp,jpg,png|between:1, 6000',
        ]);
        $image = $request->file('Foto');
        $name = $request->file('Foto')->getClientOriginalName();
        $image_name = $request->file('Foto')->getRealPath();;
        Cloudder::upload($image_name, null);
        list($width, $height) = getimagesize($image_name);
        $image_url= Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height"=>$height]);
        $image_name_un= Cloudder::getPublicId();
        $image->move(public_path("uploads"), $name);    
        $nombre_nuevo = $request->input('Nombre');
        $apellido_nuevo = $request->input('Apellido');
        $correo_nuevo = $request->input('Correo');
        $fecha_nuevo = $request->input('Fecha');

        //elimina el dato de cloudinary--------------------------
        $valoress = Contactos::where('id',$id)
        ->firstOr(['Nombre_foto'],function(){});
        //da formato
        $nombre_foto =$valoress->Nombre_foto;
        Cloudder::destroyImages($nombre_foto);

        //elimina----------------------------------------------

        Contactos::where('id','=',$id)->update([
            'Nombre'  =>$nombre_nuevo ,
            'Apellido' => $apellido_nuevo,
            'Correo' =>$correo_nuevo ,
            'Fecha' => $fecha_nuevo, 
            'Foto' => $image_url,
            'Nombre_foto'=>$image_name_un]);


        //if ($request->hasfile('Foto')){

        //    $producto=Productos::findOrFail($id);

        //    Storage::delete('public/'.$producto->Foto);

        //    $datosProductos['Foto']=$request->file('Foto')->store('uploads','public');
        //}

        //Productos::where('id','=',$id)->update($datosProductos);

        $contacto=Contactos::findOrFail($id);
        //return view('productos.edit',compact('producto'));

        return redirect('contactos')->with('Mensaje','Contacto modificado exitosamente');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contactos  $contactos
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

            //recoge el valor de imagen
        $valoress = Contactos::where('id',$id)
        ->firstOr(['Nombre_foto'],function(){});
        //da formato
        $nombre_foto =$valoress->Nombre_foto;
        //eliminacloud
        Cloudder::destroyImages($nombre_foto);

        //elimina DB
        Contactos::destroy($id);

       // $producto=Productos::findOrFail($id);

        //if(Storage::delete('public/'.$producto->Foto)){
        //    Productos::destroy($id);
        //};

        return redirect('contactos')->with('Mensaje','Contacto eliminado exitosamente');;
    }
}
