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
                <div class="card border-0 shadow mb-4">
                    <div class="card-body  p-4">
                        <h3 class="fs-4 mb-1">My Profile</h3>
                        <form action=""  id="updateForm" name="updateForm">
                        <div class="mb-4">
                            <label for="" class="mb-2">Name<span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" placeholder="Enter Name" class="form-control" value="{{$user->name}}">
                            <p></p>
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Email<span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" placeholder="Enter Email" class="form-control" value="{{$user->email}}">
                            <p></p>
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Designation</label>
                            <input type="text" name="designation" id="designation" placeholder="Designation" class="form-control" value="{{$user->designation}}">
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Mobile</label>
                            <input type="text" name="mobile" value="{{$user->mobile}}" name="mobile" placeholder="Mobile" class="form-control">
                        </div>
                    </div>
                    <div class="card-footer  p-4">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                    </div>
                </div>

                <div class="card border-0 shadow mb-4">
                    <div class="card-body p-4">
                        <h3 class="fs-4 mb-1">Change Password</h3>
                        <div class="mb-4">
                            <label for="" class="mb-2">Old Password<span class="text-danger">*</span></label>
                            <input type="password" placeholder="Old Password" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">New Password<span class="text-danger">*</span></label>
                            <input type="password" placeholder="New Password" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Confirm Password<span class="text-danger">*</span></label>
                            <input type="password" placeholder="Confirm Password" class="form-control">
                        </div>
                    </div>
                    <div class="card-footer  p-4">
                        <button type="button" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('customJs')
<script type="text/javascript">
$("#updateForm").submit(function (e) {
        e.preventDefault();
    $.ajax({
        url: '{{ route("account.updateProfile") }}', // Update the URL with the correct endpoint
        method: 'put',
        dataType: 'json',
        data: $("#updateForm").serializeArray(),
        success: function (response) {
            // Your request
            if (response.status == true) {
                $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                // Handle success
                $("#email").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                // Customized alert with options
                Swal.fire({
  title: "Update Profile!",
  icon: "success",
  showCancelButton: false,
  confirmButtonText: "OK",
}).then((result) => {
  if (result.isConfirmed) {
    // Reload the page
    location.reload();
  }
});
            } else {
                // Your error handling logic here
                var errors = response.errors;

                if (errors.name) {
                    $("#name").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.name);
                } else {
                    $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                }

                if (errors.email) {
                    $("#email").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.email);
                } else {
                    $("#email").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                }

                if (errors.password) {
                    $("#password").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.password);
                } else {
                    $("#password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                }

                if (errors.confirm_password) {
                    $("#confirm_password").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.confirm_password);
                } else {
                    $("#confirm_password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                }
            }
        },
        error: function (error) {
            // Handle AJAX error, you can log it to the console for debugging
            console.error("Ajax request failed: ", error);
        }
    });
});

</script>
@endsection
