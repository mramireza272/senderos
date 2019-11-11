<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    private $event;
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create_roles')->only(['create', 'store']);
        $this->middleware('permission:index_roles')->only('index');
        $this->middleware('permission:edit_roles')->only(['edit', 'update']);
        $this->middleware('permission:show_roles')->only('show');
        $this->middleware('permission:delete_roles')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $permissions = Permission::all();
        return view('permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $permissions = Permission::orderBy('created_at', 'desc')->get();
        return view('permissions.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //create role
        $permission = Permission::create($request->all());

        return redirect()->route('permisos.edit', $permission->id)->with('info', 'Permiso guardado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(permission $permission)
    {

        return view('permissions.show', compact('permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::where('id',$id)->get();

        $permissions = Permission::orderBy('created_at', 'desc')->get();
        $permission = $permission->first();
        //dd($role->permissions->toArray());
        return view('permissions.edit', compact('permission', 'permissions'));
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
    public function destroy(permission $permission)
    {
        $permission->delete();
        return back()->with('info', 'Permiso eliminado Correctamente');
    }
}
