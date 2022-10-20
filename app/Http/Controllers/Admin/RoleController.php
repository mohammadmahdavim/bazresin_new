<?php

namespace App\Http\Controllers\admin;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $navbar = ['name' => 'نقش ها', 'description' => 'مدیریت'];
        $roles = Role::latest()->paginate(25);
        return view('admin.roles.index',['roles' => $roles , 'navbar' => $navbar]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $navbar = ['name' => 'نقش ها', 'description' => 'ایجاد نقش'];
        $permissions = Permission::latest()->pluck('label','id')->toArray();
        return view('admin.roles.create',['permissions' => $permissions ,'navbar' => $navbar]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request , [
            'permission_id' => 'required',
            'name' => 'required',
            'label' => 'required'
        ]);
        $role = Role::create($request->all());
        $role->permissions()->sync($request->input('permission_id'));
        alert()->success('موفق','ثبت گردید');
        return redirect('/admin/roles');
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
        $role = Role::find($id);
        $navbar = ['name' => 'ویرایش نقش', 'description' => 'ویرایش نقش'.$role->labe];
        $permissions = Permission::latest()->pluck('label','id')->toArray();
        return view('admin.roles.edit',[
            'navbar' => $navbar,
            'role' => $role,
            'permissions' => $permissions
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
        $this->validate($request , [
            'permission_id' => 'required',
            'name' => 'required',
            'label' => 'required'
        ]);

        $role = Role::find($id);
        $role->permissions()->sync($request->input('permission_id'));
        alert()->success('موفق','ثبت گردید');
        return redirect('/admin/roles');
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
