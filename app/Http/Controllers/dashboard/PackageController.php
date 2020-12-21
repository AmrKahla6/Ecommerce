<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Status;
use App\Transferpoints;
use App\User;
use App\Archivepoint;
use App\Package;
use App\Currency;
use App\Requestpoint;
     


class PackageController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:dach_request_points')->only('request_points');
        $this->middleware('permission:dach_archived_requests')->only(['archived_requests']);
        $this->middleware('permission:dach_change_status_0f_request_points')->only('change_status_0f_request_points');
        $this->middleware('permission:dach_archived_transfer_points')->only(['archived_transfer_points']);
        $this->middleware('permission:dach_change_status_0f_request_transfer_points')->only('change_status_0f_request_transfer_points');
        $this->middleware('permission:dach_request_transfer_points')->only('request_transfer_points');
        $this->middleware('permission:dach_edit_price_point')->only('edit','update');      


    }
    public function archive_points() 
    {
        $requestpoints= Requestpoint::all();
        return view('dashboard.packages.archive_points',compact('requestpoints'));
    }

    public function archive_transfer_points() 
      {
        $transferpoints= Transferpoints::all();
        return view('dashboard.packages.archive_transfer_points',compact('transferpoints'));
    }

    public function index()
    {
        $status=Status::where('slug','active')->firstOrFail()->id;
        $packages=Package::where('status_id',$status)->get();
        return view('dashboard.packages.index',compact('packages'));
    }

    public function create()
    {
        // return view('dashboard.packages.create');
    }

    public function store(Request $request)
    {
        // $request->validate([    
        //     'price'                     => 'required|numeric',
        //     'number_of_points'          => 'required|numeric',
        //     'currency'                  => 'required|exists:currencies,id',
        // ]);
   
        // // return $request;
        // $status=Status::where('slug','active')->firstOrFail()->id;
        // $package                          =new Package;
        // $package->price                   = $request->price;
        // $package->number_of_points        =$request->number_of_points;
        // $package->currency_id             =$request->currency;
        // $package->status_id               =$status;
        // $package->save();
        // return redirect()->route('packages.index')->with(['status' => 'success', 'message' => __('Stored successfully')]);

    }

    public function edit($id)
    {
        $package=Package::find($id);
        return view('dashboard.packages.edit',compact('package'));
    }

    public function update(Request $request , $id)
    {
        $request->validate([    
            'price'                     => 'required|numeric',
            'currency'                  => 'required|exists:currencies,id',
        ]);
   
        // return $request;
        $status                           =Status::where('slug','active')->firstOrFail();
        $package                          = Package::find($id);
        $package->price                   = $request->price;
        $package->number_of_points        =1;
        $package->currency_id             =$request->currency;
        $package->status_id               =$status->id;
        $package->save();
        return redirect()->route('dashboard')->with(['status' => 'success', 'message' => __('Stored successfully')]);
    
    }

    public function request_points()
    {
        // return 'ohihi';
        $status=Status::where('slug','pending')->firstOrFail()->id;
        $requestpoints = Requestpoint::where('status_id',$status)->latest()->get();
        return view('dashboard.packages.request_points',compact('requestpoints'));
    }
    public function archived_requests()
    {
        $status=Status::where('slug','active')->firstOrFail()->id;
        $requestpoints = Requestpoint::where('status_id',$status)->latest()->get();
        return view('dashboard.packages.archived_requests',compact('requestpoints'));
    } 

    public function change_status_0f_request_points($id)
    {
        $status=Status::where('slug','active')->firstOrFail()->id;
        $requestpoints = Requestpoint::find($id);
        $requestpoints->status_id=$status;
        
        $user=User::find($requestpoints->user_id);
        $user->active_points += $requestpoints->number_of_points;
        $requestpoints->save();
        $user->save();

        $archive_point= new Archivepoint;
        $archive_point->user_id=$user->id;
        $archive_point->{'description:ar'}           = ' تم شراء '.$requestpoints->number_of_points.'  نقطة  ';
        $archive_point->{'description:en'}           ='you buy '. $requestpoints->number_of_points.'points';
        $archive_point->{'description:ur'}           ='you buy '. $requestpoints->number_of_points .'points';
        $archive_point->save();

        return redirect()->back()->with(['status' => 'success', 'message' => __('Updated successfully')]);
    } 

    public function request_transfer_points()
    {
        $status=Status::where('slug','pending')->firstOrFail()->id;
        $transferpoints = Transferpoints::where('status_id',$status)->latest()->get();
        return view('dashboard.packages.transfer_points',compact('transferpoints'));
    }

    public function archived_transfer_points()
    {
        $status=Status::where('slug','active')->firstOrFail()->id;
        $transferpoints = Transferpoints::where('status_id',$status)->latest()->get();
        return view('dashboard.packages.archived_transfer_points',compact('transferpoints'));
    }
    public function change_status_0f_request_transfer_points($id)
    {
        $status=Status::where('slug','active')->firstOrFail()->id;
        $transferpoint = Transferpoints::find($id);
        $transferpoint->status_id=$status;
        $transferpoint->save();
        $from=User::find($transferpoint->from);
        $from->pending_points -= $transferpoint->number_of_points;
        $from->save();
        $to=User::find($transferpoint->to);
        $to->active_points += $transferpoint->number_of_points;
        $to->save();

        $archive_point= new Archivepoint;
        $archive_point->user_id=$from->id;
        $archive_point->{'description:ar'}           = ' تم تحويل '. $transferpoint->number_of_points .'  نقطة الى ' . $to->email;
        $archive_point->{'description:en'}           ='you transfer '.  $transferpoint->number_of_points .'points to ' .$to->email;
        $archive_point->{'description:ur'}           ='you transfer '.  $transferpoint->number_of_points .'points to ' .$to->email;
        $archive_point->save();

        $archive_point= new Archivepoint;
        $archive_point->user_id=$to->id;
        $archive_point->{'description:ar'}           = ' تم تحويل '.$transferpoint->number_of_points .'  نقطة اليك من ' . $from->email;
        $archive_point->{'description:en'}           ='transfer '. $transferpoint->number_of_points .'points from'. $from->email;
        $archive_point->{'description:ur'}           ='transfer '. $transferpoint->number_of_points .'points from'. $from->email;
        $archive_point->save();

        return redirect()->back()->with(['status' => 'success', 'message' => __('Updated successfully')]);
    }
}
