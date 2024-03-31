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
                    <form method="post" id="createjobForm">
                        <div class="card border-0 shadow mb-4 ">
                            <div class="card-body card-form p-4">
                                <h3 class="fs-4 mb-1">Job Details</h3>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="" class="mb-2">Title<span class="req">*</span></label>
                                        <input type="text" placeholder="Job Title" id="title" name="title"
                                            class="form-control">
                                        <p></p>
                                    </div>
                                    <div class="col-md-6  mb-4">
                                        <label for="" class="mb-2">Category<span class="req">*</span></label>
                                        <select name="category" id="category" class="form-control">
                                            <option disabled>Select a Category</option>
                                            @if ($categories->count() > 0)
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <p></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="" class="mb-2">Job Nature<span class="req">*</span></label>
                                        <select class="form-select" id="jobType" name="jobType">
                                            <option disabled>Select job</option>
                                            @if ($jobTypes)
                                                @foreach ($jobTypes as $jobType)
                                                    <option value="{{ $jobType->id }}">{{ $jobType->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <p></p>
                                    </div>
                                    <div class="col-md-6  mb-4">
                                        <label for="" class="mb-2">Vacancy<span class="req">*</span></label>
                                        <input type="number" min="1" placeholder="Vacancy" id="vacancy"
                                            name="vacancy" class="form-control">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Salary</label>
                                        <input type="text" placeholder="Salary" id="salary" name="salary"
                                            class="form-control">
                                        <p></p>
                                    </div>

                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Location <span class="req">*</span> </label>
                                        <input type="text" placeholder="location" id="location" name="location"
                                            class="form-control">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Description<span class="req">*</span></label>
                                    <textarea class="form-control" name="description" id="description" cols="5" rows="5"
                                        placeholder="Description"></textarea>
                                    <p></p>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Benefits</label>
                                    <textarea class="form-control" name="benefits" id="benefits" cols="5" rows="5" placeholder="Benefits"></textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Responsibility</label>
                                    <textarea class="form-control" name="responsibility" id="responsibility" cols="5" rows="5"
                                        placeholder="Responsibility"></textarea>
                                </div>
                                <div class="mb-4">
                                    <label class="mb-2">Qualifications</label>
                                    <input type="text" class="form-control" name="qualifications" id="qualifications"
                                        placeholder="Qualifications">
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Experience</label>
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



                                <div class="mb-4">
                                    <label for="" class="mb-2">Keywords</label>
                                    <input type="text" placeholder="keywords" id="keywords" name="keywords"
                                        class="form-control">
                                </div>

                                <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>

                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Name<span class="req">*</span></label>
                                        <input type="text" placeholder="Company Name" id="company_name"
                                            name="company_name" class="form-control">
                                        <p></p>
                                    </div>

                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Location</label>
                                        <input type="text" placeholder="Location" id="company_location"
                                            name="company_location" class="form-control">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="" class="mb-2">Website</label>
                                    <input type="text" placeholder="Website" id="website" name="website"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="card-footer  p-4">
                                <button type="submit" class="btn btn-primary" style="display: none;" id="loader"> <i
                                        class="fa fa-spinner fa-spin"></i>Loading</button>
                                <button type="submit" class="btn btn-primary" id="originalBtn">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    </section>
@endsection
@section('customJs')
    <script type="text/javascript">
        $("#createjobForm").submit(function(e) {
            e.preventDefault();
            $("button[type=submit]").prop('disabled', true);
            $("#originalBtn").hide();
            $("#loader").show();
            try {
                $.ajax({
                    url: '{{ route('account.saveJob') }}', // Update the URL with the correct endpoint
                    method: 'POST',
                    dataType: 'json',
                    data: $("#createjobForm").serializeArray(),
                    success: function(response) {
                        $("button[type=submit]").prop('disabled', false);
                        $("#loader").show();
                        $("#originalBtn").hide();
                        // Your request
                        if (response.status == true) {
                            $("#title").removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').html('');
                            $("#vacancy").removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').html('');
                            $("#salary").removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').html('');
                            $("#location").removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').html('');
                            $("#description").removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').html('');
                            $("#company_name").removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').html('');
                            window.location.href = "/account/my-jobs";
                        } else {
                            var errors = response.errors;
                            if (errors.title) {
                                $("#title").addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback').html(errors.title);
                            } else {
                                $("#title").removeClass('is-invalid').siblings('p').removeClass(
                                    'invalid-feedback').html('');
                            }

                            if (errors.description) {
                                $("#description").addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback').html(errors.description);
                            } else {
                                $("#description").removeClass('is-invalid').siblings('p').removeClass(
                                    'invalid-feedback').html('');
                            }

                            if (errors.vacancy) {
                                $("#vacancy").addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback').html(errors.vacancy);
                            } else {
                                $("#vacancy").removeClass('is-invalid').siblings('p').removeClass(
                                    'invalid-feedback').html('');
                            }

                            if (errors.location) {
                                $("#location").addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback').html(errors.location);
                            } else {
                                $("#location").removeClass('is-invalid').siblings('p').removeClass(
                                    'invalid-feedback').html('');
                            }
                            if (errors.salary) {
                                $("#salary").addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback').html(errors.salary);
                            } else {
                                $("#salary").removeClass('is-invalid').siblings('p').removeClass(
                                    'invalid-feedback').html('');
                                // window.location.href = "/account.myJobs";
                            }
                            if (errors.company_name) {
                                $("#company_name").addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback').html(errors.salary);
                            } else {
                                $("#company_name").removeClass('is-invalid').siblings('p').removeClass(
                                    'invalid-feedback').html('');
                                // window.location.href = "/account.myJobs";
                            }
                        }
                    },
                });
            } catch (error) {
                console.error("An error occurred at line " + error.lineNumber + ": ", error);
            }
        });
    </script>
@endsection
