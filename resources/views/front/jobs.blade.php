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
                        <option value="1" {{(Request::get('sort') == '1') ? 'selected' : ''}}>Latest</option>
                        <option value="0" {{(Request::get('sort') == '0') ? 'selected' : ''}}>Oldest</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row pt-5">
            <div class="col-md-4 col-lg-3 sidebar mb-4">
                <form  id="searchform">
                    <div class="card border-0 shadow p-4">
                        <div class="mb-4">
                            <h2 style="display: inline-block">Keywords</h2> &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="text-danger" style="font-size: 12px"><a href="{{route('jobs')}}">Reset</a></span>
                            <input type="text" value="{{Request::get('keywords')}}" name="keywords" id="keywords"  placeholder="Keywords" class="form-control">
                        </div>

                        <div class="mb-4">
                            <h2>Location</h2>
                            <input type="text" value="{{Request::get('location')}}" name="location" id="location" placeholder="Location" class="form-control">
                        </div>

                        <div class="mb-4">
                            <h2>Category</h2>
                            <select name="category" id="category" class="form-control">
                                <option value="">Select a Category</option>
                                @if ($categories->isNotEmpty())
                                    @foreach ($categories as $category)
                                    <option  {{(Request::get('category') == $category->id ? 'selected' : '')}} value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                @endif

                            </select>
                        </div>
                        <div class="mb-4">
                            <h2>Job Type</h2>
                            @if ($jobtypes->isNotEmpty())
                                @foreach ($jobtypes as $jobtype)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" id="job-type{{$jobtype->id}}" {{(in_array($jobtype->id,$jobTypeArray)) ? 'checked' : ''}} name="job_type" type="checkbox" value="{{$jobtype->id}}" id="job-type">
                                        <label class="form-check-label" for="job-type{{$jobtype->id}}">{{$jobtype->name}}</label>
                                    </div>
                                @endforeach
                        @endif
                        </div>

                        <div class="mb-4">
                            <h2>Experience</h2>
                            <select class="form-control" name="experience" id="experience">
                                <option value="">Select a Year</option>
                                <option value="1" {{(Request::get('experience') == 1) ? 'selected' : ''}}>1 Year</option>
                                <option value="2" {{(Request::get('experience') == 2)  ? 'selected' : ''}}>2 Year</option>
                                <option value="3" {{(Request::get('experience') == 3)  ? 'selected' : ''}}>3 Year</option>
                                <option value="4" {{(Request::get('experience') == 4)  ? 'selected' : ''}}>4 Year</option>
                                <option value="5" {{(Request::get('experience') == 5)  ? 'selected' : ''}}>5 Year</option>
                                <option value="6" {{(Request::get('experience') == 6)  ? 'selected' : ''}}>6 Year</option>
                                <option value="7" {{(Request::get('experience') == 7)  ? 'selected' : ''}}>7 Year</option>
                                <option value="8" {{(Request::get('experience') == 8)  ? 'selected' : ''}}>8 Year</option>
                                <option value="9" {{(Request::get('experience') == 9)  ? 'selected' : ''}}>9 Year</option>
                                <option value="10" {{(Request::get('experience') == 10)  ? 'selected' : ''}}>10 Year</option>
                                <option value="10_plus" {{(Request::get('experience') == '10_plus')}}>10+ Year</option>
                            </select>
                        </div>
                        <button type="button" id="searchButton" class="btn btn-primary">Search</button>
                    </div>
            </form>
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
                                                <p>{!!Str::words($findjob->description,$words=10,'...')!!}</p>
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
                                                    <a href="{{route('jobDetails',$findjob->id)}}" class="btn btn-primary btn-lg">Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                            <div class="col-md-12">
                          Job not found
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
<script>
function parseQueryString(url) {
    var params = {};
    var queryString = url.split('?')[1];
    if (queryString) {
        queryString.split('&').forEach(function (pair) {
            pair = pair.split('=');
            params[pair[0]] = decodeURIComponent(pair[1] || '');
        });
    }
    return params;
}
var baseUrl = "{{ route('jobs') }}";
var currentUrl = window.location.href;
var parsedParams = parseQueryString(currentUrl);
var url = new URL(baseUrl);
Object.keys(parsedParams).forEach(function(key) {
    url.searchParams.append(key, parsedParams[key]);
});
$("#searchButton").click(function(e) {
    var params = url.searchParams;

    var keywords = $("#keywords").val();
    var location = $("#location").val();
    var category = $("#category").val();
    var experience = $("#experience").val();
    var checkJobTypes = $("input:checkbox[name='job_type']:checked").map(function() {
        return $(this).val();
    }).get();

    if (keywords) params.set("keywords", keywords);
    if (location) params.set("location", location);
    if (category) params.set("category", category);
    if (experience) params.set("experience", experience);
    if (checkJobTypes.length > 0) params.set("job_type", checkJobTypes.join(","));

    url.search = params.toString();
    window.location.href = url.toString();
});

$("#sort").change(function() {
    var sort = $("#sort").val();
    if (sort) {
        url.searchParams.set("sort", sort);
    } else {
        url.searchParams.delete("sort");
    }
    window.location.href = url.toString();
});
</script>
@endsection
