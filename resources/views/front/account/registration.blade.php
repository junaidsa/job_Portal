@extends('front.layout.app')
@section('main')
<section class="section-5">
    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-5">
                    <h1 class="h3">Register</h1>
                    <form  name="registrationForm" id="registrationForm">
                        {{-- @csrf --}}
                        @csrf
                        <div class="mb-3">
                            <label for="" class="mb-2">Name<span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name">
                            <p></p>
                        </div>
                        <div class="mb-3">
                            <label for="" class="mb-2">Email<span class="text-danger">*</span></label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="Enter Email">
                            <p></p>
                        </div>
                        <div class="mb-3">
                            <label for="" class="mb-2">Password<span class="text-danger">*</span></label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password">
                            <p></p>
                        </div>
                        <div class="mb-3">
                            <label for="" class="mb-2">Confirm Password<span class="text-danger">*</span></label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password">
                            <p></p>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Register</button>
                    </form>
                </div>
                <div class="mt-4 text-center">
                    <p>Have an account? <a  href="{{route('account.login')}}">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('customJs')
<script>
    $('#registrationForm').submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: '{{ route("account.processRegistration") }}',
        method: 'POST',
        data: $("#registrationForm").serializeArray(), // Use #registrationForm here
        dataType: 'json',
        success: function(response) {
            // Your success handling logic here
            if (response.status == false) {
                // Your error handling logic here
                var errors = response.errors;
            if (errors.name) {

                $("#name").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.name)
            }else{
                $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')
            }

            if (errors.email) {

                $("#email").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.email)
            }else{
                $("#email").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')
            }

            if (errors.password) {
                $("#password").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.password)
            }else{
                $("#password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')
            }
            window.location.href = "/account/login";
            if (errors.confirm_password) {
                $("#confirm_password").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.confirm_password)
            }else{
                $("#confirm_password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')
            }

            } else {
                // Your success handling logic here
        $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
        $("#email").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
        $("#password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
        $("#confirm_password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
            }
        },
        error: function(error) {
            console.log(error);
            // Handle AJAX errors here
        }
    });
});

</script>
@endsection
