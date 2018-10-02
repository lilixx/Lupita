<?php

namespace Lupita\Http\Controllers;

use Illuminate\Http\Request;
use Lupita\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Lupita\Role;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['Admin', 'Root']);
        $usuario = User::where('activo', 1)->get();
        return view('users.users',compact('usuario'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['Admin', 'Root']);
        $rol = Role::where(function($query){
          $query->where('nombre', '<>', 'Huesped')
                ->Where('nombre', '<>', 'Cliente');
        })->get();
        return view('users.create',compact('rol'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $this->validator($request->all())->validate();
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);
        $idrol = $request->rol_id;
        $user->roles()->attach(Role::where('id', $idrol)->first());
        return redirect('users')->with('msj', 'Datos guardados');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $request)
    {
        return Validator::make($request, [
            'name' => 'max:255',
            'email' => 'email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    protected function validator2(array $request)
    {
        return Validator::make($request, [
            'email' => 'email|max:255',
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request )
    {
        $request->user()->authorizeRoles(['Admin', 'Root']);
        $id = Auth::id();
        $user = User::find($id);
        //dd($user);
        return view('users.show', compact('id', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function edit($id, Request $request)
     {
         $request->user()->authorizeRoles(['Admin', 'Root']);
         $user = User::find($id);
         $rol = Role::where(function($query){
           $query->where('nombre', '<>', 'Huesped')
                 ->Where('nombre', '<>', 'Cliente');
         })->get();
         return view('users.edit')
         ->with(['edit' => true, 'user' => $user, 'rol' => $rol]);
     }

    public function editprofile($id, Request $request)
    {
        $request->user()->authorizeRoles(['Admin', 'Root']);
        $id = Auth::id();
        $user = User::find($id);
        return view('users.editprofile')
        ->with(['edit' => true, 'user' => $user]);
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
        $request->user()->authorizeRoles(['Admin', 'Root']);
        $this->validator2($request->all())->validate();
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $roleid = $request->rol_id;
      //  $roleid = $request->rol_id;

        if (!empty($request->password)) {
            $this->validator($request->all())->validate();
            $user->password = bcrypt($request->password);
        }
        $user->save();

        DB::table('role_user')->where('user_id', $id)->update(['role_id'=>$roleid]);

       return redirect('users')->with('msj', 'Datos guardados');

    }

    public function updateprofile(Request $request, $id)
    {
        $request->user()->authorizeRoles(['Admin', 'Root']);
        $this->validator($request->all())->validate();
        $id = Auth::id();
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;

        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }

        if($user->save()){
           return redirect('home')->with('msj', 'Datos guardados');
        } else {
           return back()->with('errormsj', 'Los datos no se guardaron');
        }
    }

    public function out(Request $request, $id)
    {
        $request->user()->authorizeRoles(['Admin', 'Root']);
        $user = User::find($id);
        $user->activo = 0;

        if($user->update($request->all())){
            return redirect('users')->with('msj', 'Datos guardados');
         } else {
             return back()->with('errormsj', 'Los datos no se guardaron');
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
        //
    }
}
