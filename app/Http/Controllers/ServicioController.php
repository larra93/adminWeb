<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;



class ServicioController extends Controller
{


    public function __construct()
    {
     $this->middleware('auth');   
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servicios = Servicio::all();
        return view('servicio.index')->with('servicios',$servicios);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('servicio.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try{

            $validator = Validator::make($request->all(),[
                'nombre'=>'required|min:3',
                'descripcion'=>'required',
                'imagen'=>'required|image|mimes:jpg,jpeg,png'
                
            ]);

            if($validator->fails()){
                return back()
                ->withInput()
                ->with('ErrorInsert','Favor llenar los datos')
                ->withErrors($validator);
            }

            $imagen = $request->file('imagen');
            $nombreImagen = time().'.'.$imagen->getClientOriginalExtension();
            $destino = public_path('images/servicios');
            $request->imagen->move($destino, $nombreImagen);
            $red = Image::make($destino.'/'.$nombreImagen);
            $red->resize(200,null, function($constraint){
                $constraint->aspectRatio();
            });
            $red->save($destino.'/thumbs/'.$nombreImagen);
            
            $servicio = Servicio::create([
                'nombre'=>$request->nombre,
                'descripcion'=>$request->descripcion,
                'imagen'=>$nombreImagen
            ]); 
    
            return redirect('/servicios')->with('Result',[
                'status' => 'success',
                'content' => 'Servicio registrado con exito'
            ]);

    }catch(\Exception $e){

        return back()
            ->withInput()
            ->with('ErrorInsert','Error en al registrar' . $e->getMessage())
            ->withErrors($validator);
    }

       /* $servicios = new Servicio();
        $servicios->nombre = $request->get('nombre');
        $servicios->descripcion = $request->get('descripcion');
        $servicios->imagen = $request->get('imagen');
        $servicios->save();

        return redirect('/servicios')->with('Result',[
            'status' => 'success',
            'content' => 'Servicio registrado con exito'
        ]);
        */
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
        
        $servicio = Servicio::find($id);
        $imagenPrevia = $servicio->imagen;
       
        $validator = Validator::make($request->all(),[
            'nombre'=>'required|min:3',
            'imagen'=>'image|mimes:jpg,jpeg,png',
            'descripcion'=>'required'
        ]);
        if($validator->fails()){
            return back()
            ->withInput()
            ->with('ErrorInsert','Favor llenar los datos')
            ->withErrors($validator);
        }else{


            if ($request->hasFile('imagen')){
                $imagen = $request->file('imagen');
                $nombreFoto = time().'.'.$imagen->getClientOriginalExtension();
                $destino = public_path('images/servicios');
                $request->imagen->move($destino, $nombreFoto);
                $red = Image::make($destino.'/'.$nombreFoto);
                $red->resize(200,null, function($constraint){
                $constraint->aspectRatio();
            });
            $red->save($destino.'/thumbs/'.$nombreFoto);
                unlink($destino.'/'.$imagenPrevia);
                unlink($destino.'/thumbs/'.$imagenPrevia);
                $servicio->imagen=$nombreFoto; 
    
              }
              $servicio->nombre= $request->nombre;
              $servicio->descripcion= $request->descripcion;
              $servicio->save();

              return redirect('/servicios')->with('Result',[
                'status' => 'success',
                'content' => 'Servicio modificado con exito'
            ]);
    }
    
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $servicio = Servicio::find($id);
        $imagenPrevia = $servicio->imagen;
        if($servicio->delete()){
            $destino = public_path('images/servicios');
            unlink($destino.'/'.$imagenPrevia);
            unlink($destino.'/thumbs/'.$imagenPrevia);
            return redirect('/servicios')->with('Result',[
                'status' => 'success',
                'content' => 'Servicio eliminado con exito'
            ]);
        }
    }
}
