<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\City;
use LaravelLocalization;

class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:index_city')->only('index');
        $this->middleware('permission:create_city')->only(['create', 'store']);
        $this->middleware('permission:view_city')->only('show');
        $this->middleware('permission:edit_city')->only(['edit', 'update']);
        $this->middleware('permission:delete_city')->only('destroy');
    }
    public function index()
    {
        $cities=City::latest()->get();
        return view('dashboard.cities.index',compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.cities.create');
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
        $city                 =new City;
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $city->{"name:$localeCode"}               = $request->name["$localeCode"];
        }
        $city->save();
        return redirect()->route('cities.index')->with(['status' => 'success', 'message' => __('Stored successfully')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $city=City::find($id);
        return view('dashboard.cities.edit',compact('city'));
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
        $city=City::find($id);
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $city->{"name:$localeCode"}               = $request->name["$localeCode"];
        }
        $city->save();
        return redirect()->route('positions.index')->with(['status' => 'success', 'message' => __('Stored successfully')]);
    }

    public function destroy($id)
    {
        $city=City::find($id);
        $city->delete();
        return redirect()->route('cities.index')->with('status', 'position Deleted suucssefully');;
    }

}
