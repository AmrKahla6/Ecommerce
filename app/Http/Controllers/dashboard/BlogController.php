<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Blog;
use App\Status;
use App\Commentblog;
use LaravelLocalization;
use Intervention\Image\ImageManagerStatic as Image;

class BlogController extends Controller
{
 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs=Blog::all();
        return view('dashboard.blogs.index',compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses=Status::all();
        return view('dashboard.blogs.create',compact('statuses'));
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
            'status'    => 'required|exists:statuses,id',
        ]);
        $this->validate_trans($request, [
            ['title', 'required|string|max:255'],
            ['description', 'required|string'],
        ]);
        $blog = new Blog;
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $blog->{"title:$localeCode"}              = $request->title["$localeCode"];
            $blog->{"description:$localeCode"}        = $request->description["$localeCode"];
        }
        $blog->order         = $request->order;
        $blog->status_id     = $request->status;

        if($request->hasFile('image')){
            $image = $request->image;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('app/public/' . $filename);
            Image::make($image->getRealPath())->resize(1170, 555)->save($path);
            $blog->image        =$filename;
        }
     
        $blog->save();
        return redirect()->route('blogs.index')->with(['status' => 'success', 'message' => __('Stored successfully')]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blog = Blog::find($id);
        return view('dashboard.blogs.view', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blog = Blog::find($id);
        $statuses=Status::all();
        return view('dashboard.blogs.edit', compact('statuses','blog'));
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
            'status'    => 'required|exists:statuses,id',
        ]);
        $this->validate_trans($request, [
            ['title', 'required|string|max:255'],
            ['description', 'required|string']
        ]);
        $blog = Blog::find($id);
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $blog->{"title:$localeCode"}              = $request->title["$localeCode"];
            $blog->{"description:$localeCode"}        = $request->description["$localeCode"];
        }
        $blog->order         = $request->order;
        $blog->status_id     = $request->status;

        if($request->hasFile('image')){
            $image = $request->image;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('app/public/' . $filename);
            Image::make($image->getRealPath())->resize(1170, 555)->save($path);
        
            $blog->image        =$filename;
        }
     
        $blog->save();
        return redirect()->route('blogs.index')->with(['status' => 'success', 'message' => __('Stored successfully')]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = Blog::find($id);
        $blog->delete();
        return redirect()->route('blogs.index')->with('status', 'blog Deleted suucssefully');;
    }

    public function all_suspend_comments()
    {
        $status=Status::where('slug','pending')->firstOrFail()->id;
        $blogs = Blog::whereHas('commentblogs', function ($query) {
            $query->where('status_id', \App\Status::where('slug','pending')->firstOrFail()->id);
        })->get();

        return view('dashboard.blogs.suspend_comment', compact('blogs','status'));
    }

    public function change_status_0f_comment(Request $request, $id)
    {
        $status=Status::where('slug','pending')->firstOrFail()->id;

        $status_reqest=Status::where('slug',$request->status)->firstOrFail()->id;
        $comment=Commentblog::find($id);
        $comment->status_id=$status_reqest;
        $comment->save();
        $blogs = Blog::whereHas('commentblogs', function ($query) {
            $query->where('status_id', \App\Status::where('slug','pending')->firstOrFail()->id);
        })->get();
        return redirect()->route('all_suspend_comment', compact('blogs','status'))->with(['status' => 'success', 'message' => __('status changed successfully')]);
    }
}
