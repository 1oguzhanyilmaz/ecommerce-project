<?php

namespace App\Http\Controllers\Admin;

use App\Authorizable;
use App\Http\Controllers\Controller;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RoleController extends Controller
{
    use Authorizable;

    public function __construct() {
        parent::__construct();

        $this->data['currentAdminMenu'] = 'role-user';
        $this->data['currentAdminSubMenu'] = 'role';
    }

    public function index(){
        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.roles.index', compact('roles','permissions'));
    }

    public function create(){
        //
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:roles'
        ]);

        $role = new Role();
        $role->name = $request->input('name');

        if ($role->save()){
            Session::flash('success', 'Role has been added');
            return response()->json([
                'status' => true,
                'message' => 'New Role Added.',
                'data' => $role
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'The Role name failed to load!',
            ], 422);
        }
    }

    public function show(Role $role)
    {
        //
    }

    public function edit(Role $role)
    {
        //
    }

    public function update(Request $request, Role $role){
        if ($role->name == 'Admin') {
            $role->syncPermissions(Permission::all());

            return redirect('admin/roles');
        }

        $permissions = $request->get('permissions', []);
        $role->syncPermissions($permissions);

        Session::flash('success', $role->name . ' permissions has been updated.');

        return redirect('admin/roles');
    }

    public function destroy($id){
        $role = Role::findOrFail($id);

        if (strtolower($role->name) == 'admin') {
            Session::flash('error', 'Unable to remove Admin Role');
            return redirect('admin/roles');
        }

        if ($role->delete()) {
            Session::flash('success', $role->name.' has been deleted');
        }

        return response()->json([
            'message' => $role->name . ' deleted successfully!'
        ]);
    }
}
