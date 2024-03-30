<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Job;
use App\Models\jobType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use App\Models\Scopes\AuthScope;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Drivers\Gd\Driver;

class AccountController extends Controller
{
    public $user;
    public function __construct()
    {
        $this->user =Auth::user();
    }

    // This method will show user registeraton page
    public function registration()
    {
        return view('front.account.registration');
    }

    public function processRegistration(Request  $request)
    {
        try{
            $validator = validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email:unique:users,email',
                'password' => 'required|min:5|same:confirm_password',
                'confirm_password' => 'required',

            ]);
            if ($validator->passes()) {
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->save();
                session()->flash('success', 'You have Register Successfully.');
                return response()->json([
                    'status' => true,
                    'errors' => []
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ]);
            }
        }catch (\Exception $e) {
            return response()->json(['error' =>  $e->getMessage(),'line'=> $e->getLine(),'File'=> $e->getFile()], 500);
        }
    }
    // This method will show user registeration page
    public function login()
    {
        return view('front.account.login');
    }
    public function authenticate(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('account.login')->withErrors($validator)
                ->withInput($request->only('email'));
        } else {
            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                return redirect()->route('account.profile');
            } else {
                return redirect()->route('account.login')->with('error', 'Invalid Credentials');
            }
        }
    }
    public function profile()
    {
        $user = User::find($this->user->id);
        return view('front.account.profile', [
            'user' => $user
        ]);
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login');
    }

    public function updateProfile(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user->id)],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $user = User::find($this->user->id);

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'errors' => ['User not found.'],
                ]);
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->designation = $request->designation;

            $user->save();

            session()->flash('success', 'Account Profile Updated Successfully');

            return response()->json([
                'status' => true,
                'errors' => [],
            ]);
        }catch (\Exception $e) {
            return response()->json(['error' =>  $e->getMessage(),'line'=> $e->getLine(),'File'=> $e->getFile()], 500);
        }
    }
    public function updateProfilepic(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|mimes:jpeg,png,jpg',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ]);
        }

        $image = $request->image;
        $imageName = $this->user->id . '-' . time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('/profile_image/'), $imageName);
        $sourcePath = public_path('/profile_image/' . $imageName);
        $manager = new ImageManager(Driver::class);
        $image = $manager->read($sourcePath);
        $image->cover(200, 200);
        $image->toPng()->save(public_path('/profile_image/thum/' . $imageName));
        File::delete(public_path('/profile_image/thum/' . $this->user->image));
        File::delete(public_path('/profile_image' . $this->user->image));
        $user = User::where('id', $this->user->id)->update(['image' => $imageName]);
        session()->flash('success', 'Account Profile image Updated Successfully');
        return response()->json([
            'status' => true,
            'errors' => [],
        ]);
    }

    public function createJob()
    {
        try{
            $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
            $jobTypes = JobType::orderBy('name', 'ASC')->where('status', 1)->get();
            return view('front.job.create', [
                'categories' => $categories,
                'jobTypes' => $jobTypes
            ]);
        }catch (\Exception $e) {
            return response()->json(['error' =>  $e->getMessage(),'line'=> $e->getLine(),'File'=> $e->getFile()], 500);
        }
    }

    public function saveJob(Request $request)
    {
        try{
            $rules = [
                'title' => 'required|min:5|max:100',
                'description' => 'required|string|min:5',
                'category' => 'required',
                'jobType' => 'required|integer',
                'vacancy' => 'required|integer',
                'location' => 'required|string',
                'salary' => 'required|max:50',
                'company_name' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ]);
            }
            $data = [
                'user_id' => $this->user->id,
                'title' => $request->title,
                'salary' => $request->salary,
                'description' => $request->description,
                'category_id' => $request->category,
                'job_type_id' => $request->jobType,
                'vacancy' => $request->vacancy,
                'responsibility' => $request->responsibility,
                'benefits' => $request->benefits,
                'qualifications' => $request->qualifications,
                'experience' => $request->experience,
                'keywords' => $request->keywords,
                'company_name' => $request->company_name,
                'location' => $request->location,
                'company_location' => $request->company_location,
                'website' => $request->website,
            ];

            Job::create($data);

            session()->flash('success', 'Job Create Successfully');
            return response()->json([
                'status' => true,
                'message' => 'Job created successfully',
            ]);
        }catch (\Exception $e) {
            return response()->json(['error' =>  $e->getMessage(),'line'=> $e->getLine(),'File'=> $e->getFile()], 500);
        }
    }

    public function updateJob(Request $request, $id)
    {
        try {
                $rules = [
                    'title' => 'required|min:5|max:100',
                    'description' => 'required|string|min:5',
                    'category' => 'required',
                    'jobType' => 'required|integer',
                    'vacancy' => 'required|integer',
                    'location' => 'required|string',
                    'salary' => 'required|max:50',
                    'company_name' => 'required',
                ];
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json([
                        'status' => false,
                        'errors' => $validator->errors(),
                    ]);
                }

                $job = Job::find($id);

                if (!$job) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Job not found'
                    ], 404);
                }

                $job->title = $request->title;
                $job->description = $request->description;
                $job->category_id = $request->category;
                $job->job_type_id = $request->jobType;
                $job->vacancy = $request->vacancy;
                $job->salary = $request->salary;
                $job->responsibility = $request->responsibility;
                $job->benefits = $request->benefits;
                $job->qualifications = $request->qualifications;
                $job->experience = $request->experience;
                $job->keywords = $request->keywords;
                $job->company_name = $request->company_name;
                $job->location = $request->location;
                $job->company_location = $request->company_location;
                $job->company_website = $request->website;
                $job->save();

                session()->flash('success', 'Job update Successfully');
                return response()->json([
                    'status' => true,
                    'message' => 'Job update successfully',
                ]);
        }catch (\Exception $e) {
            return response()->json(['error' =>  $e->getMessage(),'line'=> $e->getLine(),'File'=> $e->getFile()], 500);
        }

    }
    public function myJobs()
    {
        $jobs = Job::with('jobtype')->paginate(5);
        return view('front.job.my-job', [
            'jobs' => $jobs
        ]);
    }
    public function editJob(Request $request, $id)
    {
     try{
            $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
            $jobTypes = JobType::orderBy('name', 'ASC')->where('status', 1)->get();

            $job = Job::find($id);
            if ($job == null) {
                abort(404);
            }
            return view('front.job.edit', [
                'categories' => $categories,
                'jobTypes' => $jobTypes,
                'job' => $job
            ]);
    }catch (\Exception $e) {
        return response()->json(['error' =>  $e->getMessage(),'line'=> $e->getLine(),'File'=> $e->getFile()], 500);
    }

    }

    public function deleteJob(Request $request)
    {
        try{
                $validator = Validator::make($request->all(), [
                    'id' => 'required|integer',
                ]);
                if ($validator->fails()) {
                    return response()->json([
                        'status' => false,
                        'errors' => $validator->errors(),
                    ], 422);
                }
                    $job = Job::find($request->id);
                    if (!$job) {
                    return  session()->flash('error', 'Job not found Successfully');
                    }
                    $job->delete();
                    session()->flash('success', 'Job deleted Successfully');
                    return response()->json([
                        'status' => true,
                        'message' => 'Job deleted successfully',
                    ]);
        }catch (\Exception $e) {
            return response()->json(['error' =>  $e->getMessage(),'line'=> $e->getLine(),'File'=> $e->getFile()], 500);
        }

    }
}
