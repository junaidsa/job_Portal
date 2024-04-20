@extends('front.layout.app')
@section('main')
<section class="section-4 bg-2">
    <div class="container pt-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{route('jobs')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;Back to Jobs</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="container job_details_area">
        <div class="row pb-5">
            <div class="col-md-8">
                @include('front.message')
                <div class="card shadow border-0">
                    <div class="job_details_header">
                        <div class="single_jobs white-bg d-flex justify-content-between">
                            <div class="jobs_left d-flex align-items-center">

                                <div class="jobs_conetent">
                                    <a href="#">
                                        <h4>{{$details->category->name}}</h4>
                                    </a>
                                    <div class="links_locat d-flex align-items-center">
                                        <div class="location">
                                            <p> <i class="fa fa-map-marker"></i>&nbsp;{{$details->location}}</p>
                                        </div>
                                        <div class="location">
                                            <p> <i class="fa fa-clock-o"></i> {{$details->jobType->name}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="jobs_right">
                                <div class="apply_now">
                                    <a class="heart_mark {{ ($savejob == 1) ? 'save-job' : '' }}" href="javascript:void(0)" onclick="saveJob({{ $details->id }})"> <i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="descript_wrap white-bg">
                        <div class="single_wrap">
                            <h4>Job description</h4>
                            {!!$details->description!!}
                        </div>
                        @if (!empty($details->responsibility))
                        <div class="single_wrap">
                            <h4>Responsibility</h4>
                            {!! nl2br($details->responsibility)!!}
                        </div>
                        @endif

                            @if (!empty($details->qualifications))
                                <div class="single_wrap">
                                    <h4>Qualifications</h4>
                                    {!! nl2br($details->qualifications)!!}
                                </div>
                            @endif

                            @if (!empty($details->benefits))
                            <div class="single_wrap">
                                <h4>Benefits</h4>
                                {!! nl2br($details->benefits)!!}
                            </div>
                            @endif
                        <div class="border-bottom"></div>
                        <div class="pt-3 text-end">
                            <a href="javascript:void(0);" class="btn btn-secondary" onclick="saveJob({{ $details->id }})">Save</a>
                            @auth
                            <a href="#" onclick="applyJob({{ $details->id }})" class="btn btn-primary">Apply</a>
                            @else
                            <a href="{{route('account.login')}}" class="btn btn-primary">Login to Apply</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow border-0">
                    <div class="job_sumary">
                        <div class="summery_header pb-1 pt-4">
                            <h3>Job Summery</h3>
                        </div>
                        <div class="job_content pt-3">
                            <ul>
                                <li>Published on: <span>{{ \Carbon\Carbon::parse($details->create_at)->format('d M,Y') }}</span></li>
                                <li>Vacancy: <span>{{$details->vacancy}} Position</span></li>
                                <li>Salary: <span>{{ rand(1000,5000)}}k - {{$details->salary}}k/y</span></li>
                                <li>Location: <span>{{$details->location}}</span></li>
                                <li>Job Nature: <span>{{$details->jobType->name}}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card shadow border-0 my-4">
                    <div class="job_sumary">
                        <div class="summery_header pb-1 pt-4">
                            <h3>Company Details</h3>
                        </div>
                        <div class="job_content pt-3">
                            <ul>
                                <li>Name: <span>{{$details->company_name}}</span></li>
                                <li>Locaion: <span>{{$details->company_location}}</span></li>
                                <li>Webite: <span>{{$details->company_website}}</span></li>
                            </ul>
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
    function applyJob(id){
        if (confirm('Are you sure you want to apply this job')){
            $.ajax({
                url: "{{ route('applyJob') }}",
                type: 'post',
                data:{id:id},
                dataType: 'json',
                success: function(response){
               // Reload the current page
                    location.reload();
                }
            });
        }

        }
    function saveJob(id){
        if (confirm('Are you sure you want to save this job')){
            $.ajax({
                url: "{{ route('savejob') }}",
                type: 'post',
                data:{id:id},
                dataType: 'json',
                success: function(response){
               // Reload the current page
                    location.reload();
                }
            });
        }

        }
</script>
@endsection
