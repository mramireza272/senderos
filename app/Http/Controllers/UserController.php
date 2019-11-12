<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UserRequest;
use DB;
//log
use App\Events\EventUserLog;
use App\Log;

class UserController extends Controller
{
    private $event;
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create_user')->only(['create', 'store']);
        $this->middleware('permission:index_user')->only('index');
        $this->middleware('permission:edit_user')->only(['edit', 'update']);
        $this->middleware('permission:show_user')->only('show');
        $this->middleware('permission:delete_user')->only('destroy');
        $this->event = collect(['app'=> 'web', 'controller' => 'Usuarios', 'active'=> true, 'host' => url()->current(), 'remote_ip' => \Request::getClientIp(), 'module' => 'Senderos']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->event->put('user_id', auth()->user()->id);
        $this->event->put('type', 'Inicio');
        event(new EventUserLog($this->event));
        
        $users = User::where('active', true);
        
        $users = $users->orderBy('name')
                        ->paginate(12);
        $search = "";
        return view('Users.index', compact('users', 'search'));
    }

    private function getRoles(){
        $roles = Role::pluck('name', 'name');

        if(\Auth::user()->hasRole(['Administrador'])){
            $roles = Role::get();
        }
        $roles = $roles->pluck('name', 'id');
        return $roles;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $roles = $this->getRoles();
        return view('Users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $input = $request->all();
        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('usuarios.create')->with('info', 'Usuario(a) creado(a) satisfactoriamente');
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
        $user = User::findOrFail($id);
        $roles = $this->getRoles();
        $btnText = 'Actualizar';

        return view('Users.edit', compact('user', 'roles', 'btnText'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $input = $request->all();
        $user->update($input);

        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles'));

        return redirect()->route('usuarios.edit', $id)->with('info', 'Usuario(a) actualizado(a) satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('id', $id)->update(['created_by' => \Auth::user()->id, 'active' => false]);

        return redirect()->route('usuarios.index')->with('info', 'Usuario(a) deshabilitado(a) satisfactoriamente.');
    }

    public function search(Request $request) {
        $users = User::where([
            ['active', true],
            ['name', 'ilike', '%'. $request->search .'%'],
        ])->orWhere([
            ['active', true],
            ['email', 'ilike', '%'. $request->search .'%'],
        ])->orWhere([
            ['active', true],
            ['imei', 'ilike', '%'. $request->search .'%'],
        ])->orWhere([
            ['active', true],
            ['phone', 'ilike', '%'. $request->search .'%'],
        ])->orderBy('name')
           ->paginate(12);
        //$userscount = $users->count();
        $search = $request->search;
        return view('Users.index', compact('users', 'search'));
    }
}