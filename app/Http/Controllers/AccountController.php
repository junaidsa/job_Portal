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
use Intervention\Image\Drivers\Gd\Driver;

class AccountController extends Controller
{

    // This method will show user registeraton page
    public function registration(){
        return view('front.account.registration');

    }

    public function processRegistration(Request  $request)
    {
$validator = validator::make($request->all(),[
    'name' => 'required',
    'email' => 'required|email:unique:users,email',
    'password' => 'required|min:5|same:confirm_password',
    'confirm_password' => 'required',

]);
if($validator->passes()){
    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);
    $user->save();
     session()->flash('success','You have Register Successfully.');
    return response()->json([
        'status' => true,
        'errors' => []
    ]);

} else{
    return response()->json([
        'status' => false,
        'errors' => $validator->errors()
    ]);
}
    }
    // This method will show user registeration page
    public function login(){
        return view('front.account.login');

    }
    public function authenticate(Request $request){
        $email = $request->email;
        $password = $request->password;
        $validator = Validator::make($request->all(),[
            'email' =>'required|email',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return redirect()->route('account.login')->withErrors($validator)
            ->withInput($request->only('email'));
    }else{
if(Auth::attempt(['email' => $email, 'password' => $password])){
    return redirect()->route('account.profile');

}else{
    return redirect()->route('account.login')->with('error','Invalid Credentials');
}
    }

}
    public function profile(){
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('front.account.profile',[
            'user' => $user
        ]);
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('account.login');
    }

    public function updateProfile(Request $request){
        try {

            $id = Auth::user()->id;
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($id)],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ],422);
            }

                $user = User::find($id);

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

        } catch (\Exception $e) {
            // Handle the exception as needed
            return response()->json([
                'status' => false,
                'errors' => ['An error occurred while updating the user profile.'],
            ]);
        }

        }
        public function updateProfilepic(Request $request){
        $id = Auth::user()->id;
            $validator = Validator::make($request->all(), [
                'image' => 'required|mimes:jpeg,png,jpg',
            ]);

            if($validator->fails()){
            return response()->json([
            'status' => false,
            'error' => $validator->errors()
            ]);
            }

            $image = $request->image;
            $imageName = $id.'-'.time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('/profile_image/'),$imageName);


          // Create the thumbnail
// create a new image instance (800 x 600)
$sourcePath = public_path('/profile_image/'.$imageName);
$manager = new ImageManager(Driver::class);
$image = $manager->read($sourcePath);
// resize and fit the image to 200x200 maintaining the aspect ratio
$image->cover(200, 200);
$image->toPng()->save(public_path('/profile_image/thum/'.$imageName));
File::delete(public_path('/profile_image/thum/'.Auth::user()->image));
File::delete(public_path('/profile_image'.Auth::user()->image));
// File::delete(public_path('/profile_image/'.Auth::user()->image));
            $user = User::where('id',$id)->update(['image'=>$imageName]);
            session()->flash('success', 'Account Profile image Updated Successfully');
            return response()->json([
              'status' => true,
                'errors' => [],
            ]);
        }

        public function createJob(){
          $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
          $jobTypes = JobType::orderBy('name', 'ASC')->where('status', 1)->get();
            return view('front.job.create',[
                'categories' => $categories,
                'jobTypes' => $jobTypes
            ]);

        }

        public function saveJob(Request $request){
             $rules = [
                'title' =>'required|min:5|max:100',
                'description' =>'required|string|min:5|max:100',
                'category' =>'required',
                'jobType' =>'required|integer',
                'vacancy' =>'required|integer',
                'location' =>'required|string',
                'salary' =>'required|max:50',
                'company_name' =>'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ]);
            }
            $data = [
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
                'website' => $request->website,
            ];

            Job::create($data);

            return response()->json([
                'status' => true,
                'message' => 'Job created successfully',
            ]);
            }


        }
