<?php

namespace App\Http\Controllers;

use App\Exports\Buildings\MultiSheetTemplate;
use App\Exports\Reportes\Reporte;
use App\Models\Buildings;
use App\Models\Clients;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class BuildingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Conjuntos/Index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cargarConjuntos(Request $request)
    {   
        $buscar=$request->id; 
        $conjuntos=Buildings::select('*')
                            ->join('users','buildings.administrator_id', '=', 'id')
                            ->get();
                            $conjuntos->makeHidden(['password']);
        return response()->json($conjuntos);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cargarAdministradores()
    {    
        $administradores=User::role('AdminConjunto')->get(); 
        return response()->json($administradores);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Conjuntos/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $this->validate($request, [ 
            'nombre' => 'required|regex:/^[\pL\s\-]+$/u',
            'direccion' => 'required',
            'telefono' => 'required',
            'administracion' => 'required',
            'gastos' => 'required',
            'admin' => 'required',

        ]);

        $flight = Buildings::create([ 
            'name_building'=>$request->nombre,
            'address_building'=> $request->direccion, 
            'phone_building'=>$request->telefono,
            'valor_administracion'=>$request->administracion,
            'gastos_cobranzas'=>$request->gastos,
            'administrator_id'=>$request->admin,
        ]);
 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $buscar=$id;
 
        $conj=Buildings::
                            where('id_building',$buscar)
                            ->get();
        $conjunto=$conj[0]; 
        
        $conju=User::where('id','=',$conjunto->administrator_id)->get();

        $clients=DB::select("SELECT id,name,email,client_code,contract_number,state_id,user_id,building_id,description
            FROM clients 
            INNER JOIN state
            on state.id_state=clients.state_id
            INNER JOIN users
            on users.id=clients.user_id
            WHERE `building_id`=".$buscar);
        $num=sizeof($clients);  

        return Inertia::render('Admin/Conjuntos/Show',[
            'conjunto' => $conjunto,
            'clientes' => $clients,
            'conjuntoinfo'=>$conju[0],
            'num' => $num,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $buscar=$id; 

        $conjunto=Buildings::find($buscar);  

        return Inertia::render('Admin/Conjuntos/Edit',[
            'conjunto' => $conjunto,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //  


        $this->validate($request, [ 
            'nombre' => 'required|regex:/^[\pL\s\-]+$/u',
            'direccion' => 'required',
            'telefono' => 'required',
            'administrador' => 'required',
            'gastos' => 'required',
            'admin' => 'required',

        ]);

        $conjunto = Buildings::find($id);


        $conjunto->name_building = $request->nombre;
        $conjunto->address_building = $request->direccion;
        $conjunto->phone_building = $request->telefono;
        $conjunto->administrator_id = $request->administrador;
        $conjunto->valor_administracion = $request->admin;
        $conjunto->gastos_cobranzas = $request->gastos;

        $conjunto->save();

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reporte($id)
    {
        $buscar=$id; 

        $conjunto=Buildings::find($buscar);  

        return Inertia::render('Extractos/Reporte',[
            'conjunto' => $conjunto,
            'id' => $id,
        ]); 

    }

    public function exportReporte($id)
    {
        
        return Excel::download(new Reporte($id), 'reporte.xlsx');
    }

    public function exportTemplate()
    {
        
        return Excel::download(new MultiSheetTemplate, 'plantilla.xlsx');
    }
}
