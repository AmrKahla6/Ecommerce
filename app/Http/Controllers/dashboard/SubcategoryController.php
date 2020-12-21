<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Subcategory;
use LaravelLocalization;

class SubcategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:index_subcategory')->only('index');
        $this->middleware('permission:create_subcategory')->only(['create', 'store']);
        $this->middleware('permission:view_subcategory')->only('show');
        $this->middleware('permission:edit_subcategory')->only(['edit', 'update']);
        $this->middleware('permission:delete_subcategory')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategories=Subcategory::all();
        return view('dashboard.subcategories.index',compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::all();
        return view('dashboard.subcategories.create',compact('categories'));
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
            'category'  => 'required|exists:categories,id',
        ]);
        $this->validate_trans($request, [
            ['name', 'required|string|max:255'],
            ['description', 'required|string|max:255'],
        ]);
        $subcategory = new Subcategory;
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $subcategory->{"name:$localeCode"}               = $request->name["$localeCode"];
            $subcategory->{"description:$localeCode"}        = $request->description["$localeCode"];
        }
        $subcategory->order         = $request->order;
        $subcategory->category_id   = $request->category;

        $subcategory->save();
        return redirect()->route('subcategories.index')->with(['status' => 'success', 'message' => __('Stored successfully')]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subcategory = Subcategory::find($id);
        return view('dashboard.subcategories.view', compact('subcategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subcategory = Subcategory::find($id);
        $categories=Category::all();
        return view('dashboard.subcategories.edit', compact('subcategory','categories'));
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
            'category'  => 'required|exists:categories,id',
        ]);
        $this->validate_trans($request, [
            ['name', 'required|string|max:255'],
            ['description', 'required|string|max:255'],
        ]);
        $subcategory = Subcategory::find($id);
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $subcategory->{"name:$localeCode"}             = $request->name["$localeCode"];
            $subcategory->{"description:$localeCode"}      = $request->description["$localeCode"];
        }
        $subcategory->order         = $request->order;
        $subcategory->category_id   = $request->category;
   
        $subcategory->save();
        return redirect()->route('subcategories.index')->with(['status' => 'success', 'message' => __('Updated successfully')]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subcategory = Subcategory::find($id);
        $subcategory->delete();
        return redirect()->route('subcategories.index')->with('status', 'Subscribe Deleted suucssefully');
    }
}
