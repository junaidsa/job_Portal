@extends('front.layout.app')
@section('main')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Account Settings</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('front.account.sidebar')
                </div>
                <div class="col-lg-9">
                    @include('front.message')
                    <div class="card border-0 shadow mb-4 p-3">
                        <div class="card-body card-form">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3 class="fs-4 mb-1">My Save Jobs</h3>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table ">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col">Title</th>
                                            <th scope="col">Applicants</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-0">
                                        @if ($savejobs->isNotEmpty())
                                            @foreach ($savejobs as $savejob)
                                                <tr class="active">
                                                    <td>
                                                        <div class="job-name fw-500">{{$savejob->job->title }}</div>
                                                        <div class="info1">{{$savejob->job->jobType->name }} . {{ $savejob->job->location }}
                                                        </div>
                                                    </td>
                                                    <td>{{$savejob->job->appications->count()}} Applications</td>
                                                    <td>
                                                        @if ($savejob->job->status == 1)
                                                            <div class="job-status text-capitalize text-success">Active
                                                            </div>
                                                        @else
                                                            <div class="job-status text-capitalize text-danger">Block</div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a  href="{{route('jobDetails',$savejob->job_id)}}"> <i
                                                            class="fa fa-eye" aria-hidden="true"></i>
                                                    </a>
                                                    &nbsp;&nbsp;
                                                    <a href="#" onclick="deleteJob({{$savejob->id}})"> <i
                                                        class="fa fa-trash" aria-hidden="true"></i>
                                                </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{ $savejobs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('customJs')
    <script type="text/javascript">
        function deleteJob(id) {
            if (confirm('Are you sure you want to delete this record?')) {
                $.ajax({
                    url: "{{ route('account.deletetSaveJob') }}",
                    type: 'post',
                    data:{id:id},
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == true) {
                            location.reload();
                        }
                    }
                });
            }

        }
    </script>
@endsection
