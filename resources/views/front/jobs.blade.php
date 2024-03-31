@extends('front.layout.app')
@section('main')
<section class="section-3 py-5 bg-2 ">
    <div class="container">
        <div class="row">
            <div class="col-6 col-md-10 ">
                <h2>Find Jobs</h2>
            </div>
            <div class="col-6 col-md-2">
                <div class="align-end">
                    <select name="sort" id="sort" class="form-control">
                        <option value="">Latest</option>
                        <option value="">Oldest</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row pt-5">
            <div class="col-md-4 col-lg-3 sidebar mb-4">
                <div class="card border-0 shadow p-4">
                    <div class="mb-4">
                        <h2>Keywords</h2>
                        <input type="text" placeholder="Keywords" class="form-control">
                    </div>

                    <div class="mb-4">
                        <h2>Location</h2>
                        <input type="text" placeholder="Location" class="form-control">
                    </div>

                    <div class="mb-4">
                        <h2>Category</h2>
                        <select name="category" id="category" class="form-control">
                            <option value="">Select a Category</option>
                            @if ($categories->isNotEmpty())
                                @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            @endif

                        </select>
                    </div>

                    <div class="mb-4">
                        <h2>Job Type</h2>
                        @if ($jobtypes->isNotEmpty())
                            @foreach ($jobtypes as $jobtype)
                                <div class="form-check mb-2">
                                    <input class="form-check-input " name="job_type" type="checkbox" value="{{$jobtype->id}}" id="{{$jobtype->id}}">
                                    <label class="form-check-label " for="{{$jobtype->id}}">{{$jobtype->name}}</label>
                                </div>
                            @endforeach
                    @endif
                    </div>

                    <div class="mb-4">
                        <h2>Experience</h2>
                        <select class="form-control" name="experience" id="experience">
                            <option value="1">1 Year</option>
                            <option value="2">2 Year</option>
                            <option value="3">3 Year</option>
                            <option value="4">4 Year</option>
                            <option value="5">5 Year</option>
                            <option value="6">6 Year</option>
                            <option value="7">7 Year</option>
                            <option value="8">8 Year</option>
                            <option value="9">9 Year</option>
                            <option value="10">10 Year</option>
                            <option value="10_plus">10+ Year</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-lg-9 ">
                <div class="job_listing_area">
                    <div class="job_lists">
                    <div class="row">
                        @if ($findjobs->isNotEmpty())
                                @foreach ($findjobs as $findjob)
                                    <div class="col-md-6">
                                        <div class="card border-0 p-3 shadow mb-4">
                                            <div class="card-body">
                                                <h3 class="border-0 fs-5 pb-2 mb-0">{{$findjob->title}}</h3>
                                                <p>{{Str::words($findjob->description,$words=10,'...')}}</p>
                                                <div class="bg-light p-3 border">
                                                    <p class="mb-0">
                                                        <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                                        <span class="ps-1">{{$findjob->location}}</span>
                                                    </p>
                                                    <p class="mb-0">
                                                        <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                                        <span class="ps-1">{{$findjob->jobType->name}}</span>
                                                    </p>
                                                    @if (!is_null($findjob->salary))
                                                    <p class="mb-0">
                                                        <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                                        <span class="ps-1">{{$findjob->salary}}K</span>
                                                    </p>
                                                    @endif
                                                </div>
                                                <div class="d-grid mt-3">
                                                    <a href="job-detail.html" class="btn btn-primary btn-lg">Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                            <div class="col-md-12">
                                <span>Job not found</span>
                            </div>
                        @endif
                    </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
@section('customJs')
@endsection
