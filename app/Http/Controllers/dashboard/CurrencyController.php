<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Currency;
use LaravelLocalization;
use Intervention\Image\ImageManagerStatic as Image;

class CurrencyController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:index_currency')->only('index');
        $this->middleware('permission:create_currency')->only(['create', 'store']);
        $this->middleware('permission:view_currency')->only('show');
        $this->middleware('permission:edit_currency')->only(['edit', 'update']);
        $this->middleware('permission:delete_currency')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currencies=Currency::all();
        return view('dashboard.currencies.index',compact('currencies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.currencies.create');
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
            'contain_in_dollar'     => 'required',
            'short_code'            => 'required|string|max:255',
        ]);
        $this->validate_trans($request, [
            ['name', 'required|string|max:255'],
        ]);
        $currency = new Currency;
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $currency->{"name:$localeCode"}        = $request->name["$localeCode"];
        }
        $currency->short_code                = $request->short_code;
        $currency->is_default                = 0;
        $currency->contain_in_dollar         = $request->contain_in_dollar;

        $currency->save();
        return redirect()->route('currencies.index')->with(['status' => 'success', 'message' => __('Stored successfully')]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $currency = Currency::find($id);
        return view('dashboard.currencies.view', compact('currency'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $currency = Currency::find($id);
        return view('dashboard.currencies.edit', compact('currency'));
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
        if($request->is_default==1){
            // return 'hhh';
            foreach(Currency::where('is_default',1)->get() as $currency){
                $currency->is_default=0;
                $currency->save();
            }
        }
        $request->validate([
            'contain_in_dollar'     => 'required',
            'short_code'            => 'required|string|max:255',
        ]);
        $this->validate_trans($request, [
            ['name', 'required|string|max:255'],
        ]);
        $currency = Currency::find($id);
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $currency->{"name:$localeCode"}        = $request->name["$localeCode"];
        }
        $currency->short_code                = $request->short_code;
        $currency->is_default                = (boolean)$request->is_default;
        $currency->contain_in_dollar         = $request->contain_in_dollar;

        $currency->save();
        return redirect()->route('currencies.index')->with(['status' => 'success', 'message' => __('Stored successfully')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $currency      = Currency::find($id);
        $main_currency = Currency::where('short_code','USD')->firstOrFail();
        if($currency->is_default == 1){
            $main_currency->is_default = 1;
            $main_currency->save();
        }
        foreach($currency->users as $user){
            $user=\App\User::find($user->id);
            $user->currency->id = $main_currency->id;
            $user->save();
        }
        $currency->delete();
        return redirect()->route('currencies.index')->with('status', 'Subscribe Deleted suucssefully');
    }
}
