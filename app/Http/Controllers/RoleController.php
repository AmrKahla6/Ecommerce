<?php

namespace App\Http\Controllers;
use App\Permission;
use App\Role;
use App\CategoryPermission;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

use Illuminate\Http\Request;

class RoleController extends Controller
{

    public function __construct(){
        $this->middleware('permission:index_role')->only('index');
        $this->middleware('permission:create_role')->only(['create', 'store']);
        $this->middleware('permission:view_role')->only('show');
        $this->middleware('permission:edit_role')->only(['edit', 'update']);
        $this->middleware('permission:delete_role')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles      = Role::latest()->get();
        return view('dashboard.roles.index', compact('roles'));    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category_permissions    = CategoryPermission::latest()->get();
        return view('dashboard.roles.create', compact('category_permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255|unique:roles,name',
            'description'   => 'required|string|max:255',
            'permissions.*' => 'required|exists:permissions,id'
        ]);
        foreach(LaravelLocalization::getSupportedLocales() as $locale => $prop) {
            $this->validate($request,[
                ['display_name', 'required|string|max:255'],
            ]);
        }
       
        $role               = new Role;
        $role->name         = $request->name;
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $role->{"display_name:$localeCode"}     = $request->display_name["$localeCode"];
        }
        $role->description  = $request->description;
        $role->save();
        $role->permissions()->attach($request->permissions);
        return redirect()->route('roles.index')->with(['status' => 'success', 'message' => __('Stored successfully')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role               = Role::findOrFail($id);
        return view('dashboard.roles.view', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category_permissions   = CategoryPermission::latest()->get();
        $role                   = Role::findOrFail($id);
        $selected               = $role->permissions()->pluck('id')->toArray();
        return view('dashboard.roles.edit', compact('category_permissions', 'role', 'selected'));
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
        // return $request;
        $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'required|string|max:255',
            'permissions.*' => 'required|exists:permissions,id'
        ]);
        foreach(LaravelLocalization::getSupportedLocales() as $locale => $prop) {
            $this->validate($request,[
                ['display_name'=> 'required|string|max:255'],
            ]);
        }
        $role               = Role::findOrFail($id);
        $role->name  = $request->name;
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $role->{"display_name:$localeCode"}     = $request->display_name["$localeCode"];
        }
        $role->description  = $request->description;
        $role->save();
        $role->permissions()->detach();
        $role->attachPermissions($request->permissions);
        return redirect()->route('roles.index')->with(['status' => 'success', 'message' => __('Updated successfully')]);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role   = Role::findOrFail($id);
        if($role->name == 'admin' ) {
            return redirect()->route('roles.index')->with(['status' => 'error', 'message' => __('You can\'t delete this role')]);
        }
        $role->delete();
        return redirect()->route('roles.index')->with(['status' => 'success', 'message' => __('Deleted successfully')]);
    }
}
