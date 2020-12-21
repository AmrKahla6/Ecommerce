<?php

namespace App\Http\Controllers\site;
use App\Blog;
use App\Status;
use App\Commentblog;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function search_blogs(Request $request)
    {
        $request->validate([
            'search'             => 'required|string|max:255',
        ]);
       
        $status         =Status::where('slug','active')->firstOrFail()->id;
        $status_inactive=Status::where('slug','inactive')->firstOrFail()->id;

        $blogs_inactive = Blog::where('status_id',$status_inactive)->get();
        $blogs_active   = Blog::whereTranslationLike('description', '%'. $request->search .'%')->where('status_id',$status)->orWhereTranslationLike('title', '%'. $request->search .'%')->where('status_id',$status)->get();
        return view('site.blogs',compact('blogs_active','blogs_inactive'));
    }

    public function search_archived_blogs(Request $request)
    {
        $request->validate([
            'search'             => 'required|string|max:255',
        ]);
       
        $status           =Status::where('slug','inactive')->firstOrFail()->id;
        $blogs_inactive   = Blog::whereTranslationLike('description', '%'. $request->search .'%')->where('status_id',$status)->orWhereTranslationLike('title', '%'. $request->search .'%')->where('status_id',$status)->get();
        return view('site.blogs',compact('blogs_inactive'));
    }

    public function blogs()
    {
        $status_active=Status::where('slug','active')->firstOrFail()->id;
        $status_inactive=Status::where('slug','inactive')->firstOrFail()->id;

        $blogs_active = Blog::where('status_id',$status_active)->get();
        $blogs_inactive = Blog::where('status_id',$status_inactive)->get();
        return view('site.blogs',compact('blogs_active','blogs_inactive'));
    }

    public function blog($id)
    {
        $status_active=Status::where('slug','active')->firstOrFail()->id;
        $blogs_active = Blog::where('status_id',$status_active)->get();

        $blog=Blog::find($id);
   
        return view('site.blog',compact('blog','blogs_active'));
    }

    public function archived_blogs()
    {
        $status_inactive=Status::where('slug','inactive')->firstOrFail()->id;
        $blogs_inactive = Blog::where('status_id',$status_inactive)->get();
        return view('site.blogs',compact('blogs_inactive'));
    }

    public function comment(Request $request)
    {
        // return $request;
        if(auth()->check()){
            $request->validate([
                'comment'  => 'required|string',
            ]);
        }else{
            $request->validate([
                'name'     => 'required|string|max:60',
                'email'    => 'required|string|email',
                'comment'  => 'required|string',
            ]);
        }
      
        $status                 = Status::where('slug','pending')->firstOrFail()->id;
        $commentblog            = new Commentblog; 
        $commentblog->comment   = $request->comment;
        $commentblog->name      = $request->name;
        $commentblog->email     = $request->email;
        $commentblog->blog_id   = $request->blog;
        $commentblog->status_id = $status;
        auth()->check() ? $commentblog->user_id=Auth()->user()->id : '' ;
        $commentblog->save();

        session()->flash('success', 'comment is pending even approved'  );
        return redirect()->back();
    }
}
