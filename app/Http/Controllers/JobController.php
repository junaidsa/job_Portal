<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use App\Models\Scopes\AuthScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public $user;
    public function __construct()
    {
        $this->user =Auth::user();
    }
    public function index(Request $request)
    {
    try {
            $categories = Category::where('status',1)
            ->orderBy('name', 'ASC')
             ->get();
            $jobtypes = JobType::where('status',1)
            ->orderBy('name', 'ASC')
            ->get();
            $findjobs = Job::withoutGlobalScope(AuthScope::class)
            ->where('status',1);
            if(!empty($request->keywords))
            {
                $findjobs = $findjobs->where(function ($query) use ($request) {
                    $query->where('title', 'LIKE', '%'. $request->keywords. '%')
                    ->orWhere('keywords', 'LIKE', '%'. $request->keywords. '%');
                });
           }
           if(!empty($request->location))
           {
            $findjobs = $findjobs->where('location', $request->location);
           }
           if(!empty($request->category))
           {
            $findjobs = $findjobs->where('category_id', $request->category);
           }
           $jobTypeArray = [];
           if(!empty($request->job_type))
           {
            $jobTypeArray = explode(',', $request->job_type);
            $findjobs = $findjobs->whereIn('job_type_id',$jobTypeArray);
           }
           if(!empty($request->experience))
           {
            $findjobs = $findjobs->where('experience', $request->experience);
           }

            $findjobs = $findjobs->with('jobType','category');
            if($request->sort == '1'){
                $findjobs = $findjobs->orderBy('created_at', 'DESC');
            }else{
                $findjobs = $findjobs->orderBy('created_at', 'ASC');
            }
            $findjobs = $findjobs->paginate(6);
            return view('front.jobs',[
                'categories' => $categories,
                'jobtypes' => $jobtypes,
                'findjobs' => $findjobs,
                'jobTypeArray' => $jobTypeArray,
            ]);
      }catch (\Exception $e) {
        return response()->json(['error' =>  $e->getMessage(),'line'=> $e->getLine(),'File'=> $e->getFile()], 500);
    }
}

    public function details($id){

        echo $id;
        // $details = Job::with('jobType','category')->where('id',$id)->first();
        // return view('front.job.details',[
        //     'details' => $details,
        // ]);

    }
}
