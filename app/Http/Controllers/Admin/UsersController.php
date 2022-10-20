<?php

namespace App\Http\Controllers\Admin;

use App\Permission;
use App\Role;
use App\User;
use App\Zone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $navbar = ['name' => 'مدیریت کاربران', 'description' => 'مدیریت کاربران'];
        $users = User::orderby('id','desc')->get();
        return view('admin.users.index',['navbar' => $navbar,'users' => $users]);
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
        $user = User::find($id);
        $navbar = ['name' => 'ویرایش کاربر', 'description' => $user->first_name.' '.$user->last_name];
        $roles = Role::all();
        $permissions = Permission::all();
        $zones = Zone::all();
        return view('admin.users.edit',[
            'navbar' => $navbar,
            'user' => $user,
            'roles' => $roles,
            'permissions' => $permissions,
            'zones' => $zones
        ]);
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
        $user = User::find($id);
        $validator = Validator::make($request->all(), [
            'username' => 'required|melli_code'
        ])->validate();

        $user->update([
            'first_name' => $request->first_name,
            'last_name' =>  $request->last_name,
            'role' =>  $request->role,
            'mobile' =>  $request->mobile,
            'username' =>  $request->username,
            'codemeli' => (int)$request->username,
            'email' =>  $request->email,
            'sex' =>  $request->sex,
        ]);

        $user->roles()->sync($request->input('roles_id'));
        $user->zones()->sync($request->input('zones_id'));

        alert()->success('موفق','بروزرسانی صورت گرفت');
        return redirect('admin/users');
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
