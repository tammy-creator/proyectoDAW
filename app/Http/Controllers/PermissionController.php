<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Gate;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        abort_if(Gate::denies('permission_index'), 403);

        $permissions = Permission::paginate(5);

        return view('permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        abort_if(Gate::denies('permission_create'), 403);

        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        Permission::create($request->validate([
            'name'=>'required|max:20|unique:permissions',
            'descripcion'=>'required|max:80'
        ]));

        return redirect()->route('permissions.index')->with('success','Permiso creado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission){
        abort_if(Gate::denies('permission_show'), 403);

        return view('permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission){
        abort_if(Gate::denies('permission_edit'), 403);

        return view('permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission){

        $this->validate($request,[ 
            'name'=>'required|max:20|unique:permissions,name,'.$permission->id,
            'descripcion'=>'required|max:80'
        ]);

        $input = $request->all();
        $permission = Permission::find($permission->id);
        $permission->update($input);

        return redirect()->route('permissions.index')->with('success','Permiso actualizado correctamente');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission){
        abort_if(Gate::denies('permission_destroy'), 403);

        $permission->delete();
        return prResponseJson('Permiso eliminado correctamente', 1);
    }
}
