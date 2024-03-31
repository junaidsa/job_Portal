<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use Illuminate\Http\Request;
use App\Models\Scopes\AuthScope;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public $user;
    public function __construct()
    {
        $this->user =Auth::user();
    }
    public function index(){
        try {
                $categories = Category::where('status',1)
                ->orderBy('name', 'ASC')
                ->take(8)
                ->get();
                $featuredjobs = Job::withoutGlobalScope(AuthScope::class)->where('status',1)
                ->where('is_featured',1)
                ->with('jobType')
                ->orderBy('title', 'ASC')
                ->take(10)
                ->get();
                $latestjobs = Job::withoutGlobalScope(AuthScope::class)
                ->where('status',1)
                ->with('jobType')
                ->orderBy('title', 'DESC')
                ->take(16)
                ->get();
                return view('front.home',[
                    'categories' => $categories,
                    'featuredjobs' => $featuredjobs,
                    'latestjobs' => $latestjobs,
                ]);
            }catch (\Exception $e) {
                return response()->json(['error' =>  $e->getMessage(),'line'=> $e->getLine(),'File'=> $e->getFile()], 500);
            }
        }
}
