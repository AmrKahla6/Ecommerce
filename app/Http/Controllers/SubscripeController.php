<?php

namespace App\Http\Controllers;
use App\Subscripe;


use Illuminate\Http\Request;

class SubscripeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:index_subscripe')->only('index');
        $this->middleware('permission:view_subscripe')->only('show');
        $this->middleware('permission:delete_subscripe')->only('destroy');
    }
    public function index()
    {
        $subscripes = Subscripe::latest()->get();
        return view('dashboard.subscripes.index', compact('subscripes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subscripe    = Subscripe::findOrFail($id);
        return view('dashboard.subscripes.view', compact('subscripe'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(404);
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
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subscripe = Subscripe::findOrFail($id);
        $subscripe->delete();
        return redirect()->route('subscripes.index');
    }
}
