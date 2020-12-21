<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Companyimag;
use App\Status;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:index_company')->only('index');
        $this->middleware('permission:create_company')->only(['create', 'store']);
        $this->middleware('permission:view_company')->only('show');
        $this->middleware('permission:edit_company')->only(['edit', 'update']);
        $this->middleware('permission:delete_company')->only('destroy');

        $this->middleware('permission:dash_all_suspend_companies')->only('destroy');
    }
    public function index()
    {
        $companies=User::where('is_company',1)->get();
        return view('dashboard.companies.index',compact('companies'));
    }

   
    public function create()
    {
        return view('dashboard.companies.create');
    }

    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'name_of_company'      => 'required|string|max:255',    
            'name_of_owner'        => 'required|string|max:255',      
            'address'              => 'nullable|string|max:255',      
            'desc'                 => 'required|string|max:255',      
            'url'                  => 'nullable|string|url|max:255',  
            'phone'                => 'required|string',     
            'commercial_number'    => 'required|integer|min:0',                
           'image'                 => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',         
           'email'                 => 'required|string|email|unique:users,email|unique:companies,email|max:255',
           'pdf'                   => 'nullable',                
        ]);
      
        $company=new User;
        $active                      = Status::where('slug', 'active')->firstOrFail();
        $company->name_of_company    =$request->name_of_company;
        $company->name_of_owner      =$request->name_of_owner;
        $company->email              =$request->email;
        $company->phone              =$request->phone;
        $company->url                =$request->url;
        $company->commercial_number  =$request->commercial_number;
        $company->desc               =$request->desc;
        $company->address            =$request->address;
        $company->password           =bcrypt($request->password);
        $company->name_of_company    =$request->name_of_company;
        $company->status_id          =$active ->id;
        $company->is_company         =1;
        if($request->hasFile('pdf')){
            $pdf = $request->pdf;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$pdf->getClientOriginalExtension();
            $request->file('pdf')->storeAs(
                'public', $filename
            ); 
            $company->pdf        =$filename;
        }
        
        if($request->hasFile('image')){
            $image = $request->image;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('app/public/' . $filename);
            Image::make($image->getRealPath())->resize(100, 100)->save($path);
            $company->image        =$filename;
        }
        $company->save();
        if(isset($request->images)){
            foreach ($request->images as  $image) {
                $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
                $path = storage_path('app/public/' . $filename);
                Image::make($image->getRealPath())->resize(100, 100)->save($path);
                $companyimag = new Companyimag;
                $companyimag->image        =$filename;
                $companyimag->user_id        =$company->id;
                $companyimag->save();
            }
        }
        return redirect()->route('companies.index')->with(['status' => 'success', 'message' => __('Stored successfully')]);
    }

    public function show($id)
    {
        $company = User::find($id);
        return view('dashboard.companies.view', compact('company'));
    }

  
    public function edit($id)
    {
        $company = User::find($id);
        return view('dashboard.companies.edit', compact('company'));
    }
    public function update(Request $request ,$id)
    {
       
        $request->validate([
            'name_of_company'      => 'required|string|max:255',    
            'name_of_owner'        => 'required|string|max:255',      
            'address'              => 'nullable|string|max:255',      
            'desc'                 => 'required|string|max:255',      
            'url'                  => 'nullable|string|url|max:255',  
            'phone'                => 'required|string',     
            'commercial_number'    => 'required|integer|min:0',                
           'image'                 => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  
           'pdf'                   => 'nullable|mimes:pdf',       
           'email'                 => ['required', 'string', 'email', Rule::unique('users')->ignore($id), Rule::unique('companies')->ignore($id), 'max:255'],              
        ]);
        $company                     =User::find($id);
        $status=Status::where('slug',$request->status)->firstOrFail()->id;
        $company->status_id          =$status;
        $company->name_of_company    =$request->name_of_company;
        $company->name_of_owner      =$request->name_of_owner;
        $company->email              =$request->email;
        $company->phone              =$request->phone;
        $company->url                =$request->url;
        $company->commercial_number  =$request->commercial_number;
        $company->desc               =$request->desc;
        $company->address            =$request->address;
        $company->is_company         =1;
        
        if($request->hasFile('image')){
            $image = $request->image;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('app/public/' . $filename);
            Image::make($image->getRealPath())->resize(100, 100)->save($path);
            $company->image        =$filename;
        }
        if($request->hasFile('pdf')){
            $pdf = $request->pdf;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$pdf->getClientOriginalExtension();
            $request->file('pdf')->storeAs(
                'public', $filename
            ); 
            $company->pdf        =$filename;
        }
        $company->save();
        if(isset($request->removed_image)){
            foreach($request->removed_image as $remove){
                foreach($company->companyimages as $img){
                    if($img->image==$remove){
                        $img->delete();
                    }
                }
            }
        }
        if(isset($request->productimage)){
            foreach ($request->productimage as  $image) {
                $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
                $path = storage_path('app/public/' . $filename);
                Image::make($image->getRealPath())->resize(100, 100)->save($path);
                $companyimage = new Companyimag;
                $companyimage->image        =$filename;
                $companyimage->user_id      =$company->id;
                $companyimage->save();
            }
        }
        return redirect()->route('companies.index')->with(['status' => 'success', 'message' => __('updated successfully')]);
    }

    public function all_suspend_companies()
    {
        $status=Status::where('slug','pending')->firstOrFail()->id;
        $companies=User::where('is_company',1)->where('status_id',$status)->get();
        return view('dashboard.companies.suspend_companies',compact('companies'));
    }
    
}

