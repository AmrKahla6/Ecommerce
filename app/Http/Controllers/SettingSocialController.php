<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SocialSetting;

class SettingSocialController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:index_social')->only('index');
        $this->middleware('permission:create_social')->only(['create', 'store']);
        $this->middleware('permission:view_social')->only('show');
        $this->middleware('permission:edit_social')->only(['edit', 'update']);
        $this->middleware('permission:delete_social')->only('destroy');
    }
    public function index()
    {
        $socials = SocialSetting::latest()->get();
        return view('dashboard.social_settings.index', compact('socials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.social_settings.create');
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
            'icon'          => 'nullable|string||max:50',
            'url'           => "nullable|required_with:icon|string|url|max:100",
        ]);
        $social             = new SocialSetting;
        $social->url        = $request->url;
        $social->icon       = $request->icon;
        $social->save();
        return redirect()->route('social_settings.index')->with(['status' => 'success', 'message' => __('Stored successfully')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $social = SocialSetting::findOrFail($id);
        return view('dashboard.social_settings.view', compact('social'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $social = SocialSetting::findOrFail($id);
        return view('dashboard.social_settings.edit', compact('social'));
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
            'icon'          => 'nullable|string|in:facebook-f,twitter,instagram,youtube,google-plus,vimeo,skype,linkedin,tumblr|max:50',
            'url'           => 'nullable|required_with:icon|string|url|max:100',
        ]);
        $social             = SocialSetting::findOrFail($id);
        $social->url        = $request->url;
        $social->icon       = $request->icon;
        $social->save();
        return redirect()->route('social_settings.index')->with(['status' => 'success', 'message' => __('Updated successfully')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $social = SocialSetting::findOrFail($id);
        $social->delete();
        return redirect()->route('social_settings.index')->with(['status' => 'success', 'message' => __('Deleted successfully')]);
    }
}
