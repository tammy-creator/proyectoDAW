<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    public function index(){
        
        abort_if(Gate::denies('user_index'), 403);

        $users= User::paginate(8);
        
        foreach($users as $user) {
            if(is_null($user->terapeuta_id))
                $user->terapeuta = "";
            else
                $user->terapeuta = User::getTherapistName($user->terapeuta_id);
            
        }
        
        return view('users.index', compact('users'));
    }

    public function create(){
        abort_if(Gate::denies('user_create'), 403);
        
        $users = User::all();        
              
        $terapeutas=User::getTherapistList();

        $roles = Role::all()->pluck('name', 'id');
        
        return view('users.create', compact('roles','users','terapeutas'));
    }

    public function store(Request $request){
        
        $request->validate([
            'name'=>'required|max:15',
            'apellidos'=>'required|min:3|max:50',
            'direccion'=>'required|max:50',
            'telefono'=>'required|numeric|digits:9',
            'email'=>'required|email|unique:users',
            'password'=>'required',
            'role_id'=>'required|exists:roles,id'
        ]);
        $user = User::create($request->only('name', 'apellidos', 'direccion', 'telefono', 'email', 'terapeuta_id')
                    + [
                        'password' => bcrypt($request->input('password')),
                    ]);                    
                            
        $roles = $request->input('roles', [$request['role_id']]);
        $user->syncRoles($roles);
        return redirect()->route('users.show', $user->id)->with('success','Usuario creado correctamente');
    }

    public function show(User $user){
        abort_if(Gate::denies('user_show'), 403);
        $user->load('roles');
        return view('users.show', compact('user'));
    }

    public function edit(User $user){
        abort_if(Gate::denies('user_edit'), 403);
        $terapeutas=User::getTherapistList();
        $roles = Role::all()->pluck('name', 'id');
        $user->load('roles');
        
        return view('users.edit', compact('user','roles','terapeutas'));
    }

    public function update(Request $request, User $user){
        
        $this->validate($request, [
            'name' => 'required',
            'apellidos'=>'required|min:3|max:50',
            'direccion'=>'required|max:50',
            'telefono'=>'required|numeric|digits:9',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'sometimes',
            'role_id' => 'required',
            'terapeuta_id' => 'nullable|exists:users,id'           
        ]);
        
        $input = $request->all();
        
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($user->id);
        $user->update($input);

        $roles = $request->input('roles', [$input['role_id']]);
        $user->syncRoles($roles);
        return redirect()->route('users.index')->with('success','Usuario actualizado correctamente');
    }

    public function destroy(User $user){
     
        abort_if(Gate::denies('user_destroy'), 403);
     
        if(auth()->user()->id == $user->id){
            return prResponseJson('No se pudo eliminar el usuario');
        }        

        $user->delete();
        return prResponseJson('Usuario eliminado correctamente', 1);
    }
    
    
}
