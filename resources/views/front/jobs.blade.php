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
                                        <input class="form-check-input" id="job-type{{$jobtype->id}}" name="job_type" type="checkbox" value="{{$jobtype->id}}" id="job-type">
                                        <label class="form-check-label" for="job-type{{$jobtype->id}}">{{$jobtype->name}}</label>
                                    </div>
                                @endforeach
                        @endif
                        </div>

                        <div class="mb-4">
                            <h2>Experience</h2>
                            <select class="form-control" name="experience" id="experience">
                                <option value="">Select a Year</option>
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
                        <button type="button" id="searchButton" onclick="show_data()" class="btn btn-primary">Search</button>
                    </div>
            </form>
            </div>
            <div class="col-md-8 col-lg-9 ">
                <div class="job_listing_area">
                    <div class="job_lists">
                    <div class="row" id="jobmain">
                                
                                    </div>
                       {{-- <div class="col-md-12">
                          Job not found
                            </div> --}}
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
    show_data()
	function show_data() {
    var keywords = $("#keywords").val();
    var location = $("#location").val();
    var category = $("#category").val();
    var experience = $("#experience").val();
    var sort = $("#sort").val();
    var checkJobTypes = $("input:checkbox[name='job_type']:checked").map(function() {
    return $(this).val();
}).get();
var job_type = checkJobTypes.join(',');
    $.ajax({
		method:'post',
        url: "{{ route('job.fillters') }}",
		data:{
            keywords:keywords,
            location:location,
            category:category,
            experience:experience,
            job_type:job_type,
            sort:sort,
        },
        dataType: 'json',
        success: function(resonse) {
         var jobs = resonse.jobs.data;
         var html = '';
         for (var i = 0; i < jobs.length; i++) {
             var job = jobs[i];
             var shortDescription = job.description.slice(0, 100)+'...';
             var detailsUrl = '/job/details/'+ job.id;
    html += `<div class="col-md-6">
                <div class="card border-0 p-3 shadow mb-4">
                    <div class="card-body">
                        <h3 class="border-0 fs-5 pb-2 mb-0">${job.title}</h3>
                        <p>${shortDescription}</p>
                        <div class="bg-light p-3 border">
                            <p class="mb-0">
                                <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                <span class="ps-1">${job.location}</span>
                            </p>
                            <p class="mb-0">
                                <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                <span class="ps-1">${job.created_at}</span>
                            </p>
                            <p class="mb-0">
                                <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                <span class="ps-1">${job.salary}</span>
                            </p>
                        </div>
                        <div class="d-grid mt-3">
                            <a href="${detailsUrl}" class="btn btn-primary btn-lg">Details</a>
                        </div>
                    </div>
                </div>
            </div>`;
}
$('#jobmain').html(html);
        },
        error: function(error) {
            alert(error.name);
        }

    });
}
$("#sort").change(function() {
    var sort = $("#sort").val();
    if (sort) {
        show_data()
    }
});

</script>
@endsection
