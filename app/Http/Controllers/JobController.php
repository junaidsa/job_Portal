<?php

namespace App\Http\Controllers;

use App\Mail\JobNotificationEmail;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobType;
use App\Models\SaveJob;
use App\Models\Scopes\AuthScope;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class JobController extends Controller
{
    public function __construct()
    {
        // $this->user_id =Auth::user()->id;
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
        $details = Job::withoutGlobalScope(AuthScope::class)
        ->with('jobType','category')
        ->where(['id' => $id
        ,'status' => 1])->first();
        if(!$details)
        {
            return abort(404);
        }
        $savejob = 0;
        if(Auth::user()){
            $savejob = SaveJob::where('job_id',$id)->exists();
            return view('front.jobdetails',[
                'details' => $details,
                'savejob' => $savejob,
            ]);
        }
    }

    public function applyJob(Request $request){
        try{
                $validator = Validator::make($request->all(), [
                    'id' => 'required|int|digits_between:1,11',
                ]);
                if ($validator->fails()) {
                    return response()->json([
                        'status' => false,
                        'error' => $validator->errors()
                    ]);
                }
                    $job = Job::withoutGlobalScope(AuthScope::class)->find($request->id);
                    if(!$job)
                    {
                        session()->flash('error','Job not found');
                        return response()->json([
                        'status' => false,
                            'error' => 'Job not found'
                        ]);

                    }
                    $employer_id = $job->user_id;
                    if ($employer_id == Auth::user()->id)
                    {
                        session()->flash('success','You can not Apply your own Job');
                        return response()->json([
                        'status' => true,
                            'error' => 'You can not Apply your own Job'
                        ]);
                    }
                    $jobApplication = JobApplication::where('job_id', $request->id)
                                        ->where('user_id', Auth::user()->id)
                                        ->exists();
                                        if($jobApplication){
                                            session()->flash('error','You have already applied for this job');
                                            return response()->json([
                                            'status' => false,
                                                'error' => 'You have already applied for this job'
                                            ]);
                                        }
                    JobApplication::Create(
                        [
                            'user_id' => Auth::user()->id,
                            'job_id' => $job->id,
                            'employer_id' => $employer_id,
                            'applied_date' => now(),
                        ]
                    );
                    session()->flash('success','Job applied  job successfully');
                    $employes = User::find($employer_id);
                    $mailData =[
                        'employes' => $employes,
                        'user' => Auth::user(),
                        'job' => $job,
                    ];
                    Mail::to($employes->email)->send(new JobNotificationEmail($mailData));

                    return response()->json([
                    'status' => true,
                        'success' => 'Job applied  job successfully'
                    ]);
        }catch (\Exception $e) {
            return response()->json(['error' =>  $e->getMessage(),'line'=> $e->getLine(),'File'=> $e->getFile()], 500);
        }
    }
    public function savejob(Request $request){
        $job = Job::withoutGlobalScope(AuthScope::class)->find($request->id);
        
        if(!$job) {
            session()->flash('error', 'Job not found');
            return response()->json([
                'status' => false,
                'error' => 'Job not found'
            ]);
        }
        
        $employer_id = $job->user_id;
        
        if ($employer_id == Auth::user()->id) {
            session()->flash('success', 'You cannot save your own job');
            return response()->json([
                'status' => true,
                'error' => 'You cannot save your own job'
            ]);
        }
         $savejob = SaveJob::where('job_id',$request->id)->exists();
         if ($savejob) {
            # code...
            session()->flash('error', 'This job already exists');
            return response()->json([
                'status' => true,
                'error' => 'This job already exists'
            ]);
         }
        
        // Insert the record if conditions are met
        SaveJob::create([
            'job_id' => $request->id,
            'user_id' => Auth::user()->id
        ]);
    
        session()->flash('success', 'Job saved successfully');
        return response()->json([
            'status' => true,
            'success' => 'Job saved successfully'
        ]);
    }
    
}
