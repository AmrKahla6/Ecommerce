<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\Status;

use Intervention\Image\ImageManagerStatic as Image;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('permission:index_user')->only('index');
        $this->middleware('permission:create_user')->only(['create', 'store']);
        $this->middleware('permission:view_user')->only('show');
        $this->middleware('permission:edit_user')->only(['edit', 'update']);
        $this->middleware('permission:delete_user')->only('destroy');
    }
    public function index()
    {
        $users      = User::where('is_company',0)->latest()->get();
        return view('dashboard.users.index', compact('users'));
    }
    public function create(){
        return view('dashboard.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_of_owner'     => 'required|string',
            'phone'             => 'required|string',
            'address'           => 'required|string',
            'email'             =>'required|string|email|max:255|unique:users' ,
            'image'             => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'password'          => ['required', 'string', 'min:6', 'confirmed'],
            'roles.*'           => 'exists:roles,id',
        ]);

        $user                = new User();
        $status              =Status::where('slug','active')->firstOrFail();
        $user->status_id     = $status->id;
        $user->name_of_owner = $request->name_of_owner;
        $user->address       = $request->address;
        $user->is_company    = 0;
        $user->phone         = $request->phone;
        $user->email        = $request->email;
        $user->city_id      = $request->city;

        $user->password     = bcrypt($request->password);
        if($request->hasFile('image')){
            $image = $request->image;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('app/public/' . $filename);
            Image::make($image->getRealPath())->resize(100, 100)->save($path);
            $user->image        =$filename;
        }
        $user->save();
        $user->roles()->attach($request->roles);
        return redirect()->route('users.index')->with(['status' => 'success', 'message' => __('Stored successfully')]);
    }

    public function show($id)
    {
        $user       = User::where('id', $id)->firstOrFail();
        return view('dashboard.users.view', compact('user'));
    }

    public function edit($id)
    {
        $roles              = Role::latest()->get();
        $user               = User::where('id', $id)->firstOrFail();
        $selected           = $user->roles()->pluck('id')->toArray();
        return view('dashboard.users.edit', compact('roles','user','selected'));
    }

    public function update(Request $request , $id)
    {
        $user                = User::find($id);
        $request->validate([
            'name_of_owner'     => 'required|string',
            'phone'             => 'required|string',
            'address'           => 'required|string',
            'email'             => 'unique:users,email,'.$user->id,
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'roles.*'             => 'exists:roles,id',
        ]);

        $status=Status::where('slug',$request->status)->firstOrFail()->id;
        $user->status_id      =$status;
        $user->name_of_owner = $request->name_of_owner;
        $user->address       = $request->address;
        $user->is_company    = 0;
        $user->phone         = $request->phone;
        $user->email         = $request->email;
        $user->city_id       = $request->city;
        if($request->image){
           if($request->hasFile('image')){
                $image = $request->image;
                $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
                $path = storage_path('app/public/' . $filename);
                Image::make($image->getRealPath())->resize(100, 100)->save($path);
                $user->image        =$filename;
            }
        }
        $user->save();
        $user->roles()->detach();
        $user->roles()->attach($request->roles);
        return redirect()->route('users.index')->with(['status' => 'success', 'message' => __('Stored successfully')]);
    }
}
