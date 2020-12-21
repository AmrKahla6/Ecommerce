<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use LaravelLocalization;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:index_category')->only('index');
        $this->middleware('permission:create_category')->only(['create', 'store']);
        $this->middleware('permission:view_category')->only('show');
        $this->middleware('permission:edit_category')->only(['edit', 'update']);
        $this->middleware('permission:delete_category')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories=Category::all();
        return view('dashboard.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate_trans($request, [
            ['name', 'required|string|max:255'],
        ]);
        $category = new Category;
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $category->{"name:$localeCode"}        = $request->name["$localeCode"];
        }
        $category->save();
        return redirect()->route('categories.index')->with(['status' => 'success', 'message' => __('Stored successfully')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        return view('dashboard.categories.view', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('dashboard.categories.edit', compact('category'));
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

        $this->validate_trans($request, [
            ['name', 'required|string|max:255'],
        ]);
        $category = Category::find($id);
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $category->{"name:$localeCode"}             = $request->name["$localeCode"];
        }
        $category->save();
        return redirect()->route('categories.index')->with(['status' => 'success', 'message' => __('Updated successfully')]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $category = Category::find($subscribe);
        // $category->delete();
        // return redirect()->route('categories.index')->with('status', 'Subscribe Deleted suucssefully');

    }
}
