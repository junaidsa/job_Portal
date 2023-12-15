@extends('front.layout.app')
@section('main')
<section class="section-5">
    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-5">
                    <h1 class="h3">Register</h1>
                    <form action="" name="registrationForm" id="registrationForm">
                        <div class="mb-3">
                            <label for="" class="mb-2">Name<span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name">
                        </div>
                        <div class="mb-3">
                            <label for="" class="mb-2">Email<span class="text-danger">*</span></label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="Enter Email">
                        </div>
                        <div class="mb-3">
                            <label for="" class="mb-2">Password<span class="text-danger">*</span></label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password">
                        </div>
                        <div class="mb-3">
                            <label for="" class="mb-2">Confirm Password<span class="text-danger">*</span></label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password">
                        </div>
                        <button class="btn btn-primary mt-2">Register</button>
                    </form>
                </div>
                <div class="mt-4 text-center">
                    <p>Have an account? <a  href="login.html">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('customJs')
<script>
    $('#registrationForm').submit(function(e){
e.preventDefault();
$.ajax({
    url: '{{route("account.processRegistration")}}',
    type: 'post',
    data: $("registrationForm").serializeArray(),
    dataType: 'json',
    success: function(response){

    }

})
    })
</script>
@endsection
