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
    public function index()
    {
    try {
            $categories = Category::where('status',1)
            ->orderBy('name', 'ASC')
             ->get();
            $jobtypes = JobType::where('status',1)
            ->orderBy('name', 'ASC')
            ->get();
            $findjobs = Job::withoutGlobalScope(AuthScope::class)
            ->where('status',1)
            ->with('jobType')
            ->orderBy('created_at', 'ASC')
            ->paginate(6);
            return view('front.jobs',[
                'categories' => $categories,
                'jobtypes' => $jobtypes,
                'findjobs' => $findjobs,
            ]);
      }catch (\Exception $e) {
        return response()->json(['error' =>  $e->getMessage(),'line'=> $e->getLine(),'File'=> $e->getFile()], 500);
    }
    }
}
