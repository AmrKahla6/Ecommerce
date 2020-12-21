<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Position;
use LaravelLocalization;

class PositionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:index_position')->only('index');
        $this->middleware('permission:create_position')->only(['create', 'store']);
        $this->middleware('permission:view_position')->only('show');
        $this->middleware('permission:edit_position')->only(['edit', 'update']);
        $this->middleware('permission:delete_position')->only('destroy');
    }
    public function index()
    {
        $positions=Position::latest()->get();
        return view('dashboard.positions.index',compact('positions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.positions.create');
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
        $position                 =new Position;
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $position->{"name:$localeCode"}               = $request->name["$localeCode"];
        }
        $position->save();
        return redirect()->route('positions.index')->with(['status' => 'success', 'message' => __('Stored successfully')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $position=Position::find($id);
        return view('dashboard.positions.view',compact('position'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $position=Position::find($id);
        return view('dashboard.positions.edit',compact('position'));
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
        $position=Position::find($id);
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $position->{"name:$localeCode"}               = $request->name["$localeCode"];
        }
        $position->save();
        return redirect()->route('positions.index')->with(['status' => 'success', 'message' => __('Stored successfully')]);
    }

    public function destroy($id)
    {
        // $position=Position::find($id);
        // $position->delete();
        // return redirect()->route('positions.index')->with('status', 'position Deleted suucssefully');;
    }

}
