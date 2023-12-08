@extends('layouts.user')

@section('content')
    <section class="vh-100 d-flex justify-content-center align-items-center">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                         class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <form action="{{route('register')}}" method="POST">
                        @csrf
                        <div class="mb-4 fs-4">Register</div>
                        <div class="form-outline mb-4">
                            <input type="email" id="email" name="email" class="form-control" value="{{old('email')}}"/>
                            <label class="form-label" for="email">Email address</label>
                            @error('email')
                            <div class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="form-outline mb-4">
                            <input type="password" id="password" name="password" class="form-control"
                                   value="{{old('password')}}"/>
                            <label class="form-label" for="password">Password</label>
                            @error('password')
                            <div class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>

                        <!-- 2 column grid layout for inline styling -->
                        <div class="row mb-4">
                            <div class="col d-flex justify-content-start">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="remember"
                                           name="remember" checked/>
                                    <label class="form-check-label" for="remember"> Remember me </label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block mb-4">Sign up</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
