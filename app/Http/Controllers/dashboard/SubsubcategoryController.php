<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Subcategory;
use App\Subsubcategory;
use LaravelLocalization;
use Intervention\Image\ImageManagerStatic as Image;

class SubsubcategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:index_subsubcategory')->only('index');
        $this->middleware('permission:create_subsubcategory')->only(['create', 'store']);
        $this->middleware('permission:view_subsubcategory')->only('show');
        $this->middleware('permission:edit_subsubcategory')->only(['edit', 'update']);
        $this->middleware('permission:delete_subsubcategory')->only('destroy');
    }
    public function index()
    {
        $subsubcategories=Subsubcategory::all();
        return view('dashboard.subsubcategories.index',compact('subsubcategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::all();
        return view('dashboard.subsubcategories.create',compact('categories'));
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
            'order'     => 'required|integer',
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'category'  => 'required|exists:categories,id',
            'subcategory'  => 'required|exists:subcategories,id',
        ]);
        $this->validate_trans($request, [
            ['name', 'required|string|max:255'],
            ['description', 'required|string|max:255'],
        ]);
        $subsubcategory = new Subsubcategory;
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $subsubcategory->{"name:$localeCode"}               = $request->name["$localeCode"];
            $subsubcategory->{"description:$localeCode"}        = $request->description["$localeCode"];
        }
        $subsubcategory->order         = $request->order;
        $subsubcategory->category_id   = $request->category;
        $subsubcategory->subcategory_id   = $request->subcategory;

        if($request->hasFile('image')){
            $image = $request->image;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('/app/public/' . $filename);
            Image::make($image->getRealPath())->resize(300, 300)->save($path);
            $subsubcategory->image        =$filename;
        }
     
        $subsubcategory->save();
        return redirect()->route('subsubcategories.index')->with(['status' => 'success', 'message' => __('Stored successfully')]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subsubcategory = Subsubcategory::find($id);
        return view('dashboard.subsubcategories.view', compact('subsubcategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subsubcategory = Subsubcategory::find($id);
        $categories=Category::all();
        return view('dashboard.subsubcategories.edit', compact('subsubcategory','categories'));
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
        $request->validate([
            'order'     => 'required|integer',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'category'  => 'required|exists:categories,id',
            'subcategory'  => 'required|exists:subcategories,id',
        ]);
        $this->validate_trans($request, [
            ['name', 'required|string|max:255'],
            ['description', 'required|string|max:255'],
        ]);
        $subsubcategory = Subsubcategory::find($id);
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $subsubcategory->{"name:$localeCode"}               = $request->name["$localeCode"];
            $subsubcategory->{"description:$localeCode"}        = $request->description["$localeCode"];
        }
        $subsubcategory->order         = $request->order;
        $subsubcategory->category_id   = $request->category;
        $subsubcategory->subcategory_id   = $request->subcategory;

        if($request->hasFile('image')){
            $image = $request->image;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('app/public/' . $filename);
            Image::make($image->getRealPath())->resize(300, 300)->save($path);
            $subsubcategory->image        =$filename;
        }
     
        $subsubcategory->save();
        return redirect()->route('subsubcategories.index')->with(['status' => 'success', 'message' => __('Updated successfully')]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subsubcategory = Subsubcategory::find($id);
        $subsubcategory->delete();
        return redirect()->route('subsubcategories.index')->with('status', 'Subscribe Deleted suucssefully');
    }

    public function subcategories(Request $request) {
        return Category::findOrFail($request->id)->subcategories()->get();
    }

    public function subsubcategories(Request $request) {
        return Subcategory::findOrFail($request->id)->subsubcategories()->get();
    }
}
