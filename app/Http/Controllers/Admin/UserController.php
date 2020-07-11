<?php

namespace App\Http\Controllers\Admin;

use App\Authorizable;
use App\Http\Controllers\Controller;
use App\Permission;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    use Authorizable;

    public function __construct(){
        parent::__construct();

        $this->data['currentAdminMenu'] = 'role-user';
        $this->data['currentAdminSubMenu'] = 'user';
    }

    public function index(){
        $users = User::latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create(){
        $roles = Role::pluck('name', 'id');

        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'bail|required|min:2',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'roles' => 'required|min:1'
        ]);

        $request->merge(['password' => bcrypt($request->get('password'))]);

        $user = User::create($request->except('roles', 'permissions'));
        $user->assignRole($request->input('roles'));

        return redirect('admin/users');
    }

    public function show($id)
    {
        //
    }

    public function edit($id){
        $user = User::find($id);
        $userRoleIds = [];
        foreach ($user->roles as $u_role){
            $userRoleIds[] = $u_role->id;
        }
//        $roles = Role::pluck('name', 'id');
        $roles = Role::all();

        return view('admin.users.edit', compact('user','roles','userRoleIds'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'name' => 'bail|required|min:2',
            'email' => 'required|email|unique:users,email,' . $id,
//            'password' => 'same:confirm-password',
            'roles' => 'required|min:1'
        ]);

        $user = User::findOrFail($id); // id 5
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->input('password')){
            $user->password = bcrypt($request->get('password'));
        }
        $user->save();

        $roles = $request->get('roles'); // admin 1     user 2
        $hasRoles = Role::find($roles);
        $user->syncRoles($hasRoles);

        Session::flash('success', 'User has been saved');

        return redirect('admin/users');
    }

    public function destroy($id){
        $user = User::findOrFail($id);

        if ($user->hasRole('Admin')) {
            Session::flash('error', 'Unable to remove an Admin user');
            return redirect('admin/users');
        }

        if ($user->delete()) {
            Session::flash('success', 'User has been deleted');
        }
        return redirect('admin/users');
    }

    private function syncPermissions(Request $request, $user){
        // Get the submitted roles
        $roles = $request->get('roles');
        $permissions = $request->get('permissions');
        // Get the roles
        $hasRoles = Role::find($roles);
        // check for current role changes
        if( ! $user->hasAllRoles( $hasRoles ) ) {
            // reset all direct permissions for user
            $user->permissions()->sync([]);
        } else {
            // handle permissions
            $user->syncPermissions($permissions);
        }

        $user->syncRoles($roles);

        return $user;
    }
}
