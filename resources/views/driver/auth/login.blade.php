@extends('layouts.driver')

@section('content')
    <section class="vh-100 d-flex justify-content-center align-items-center">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="{{asset('/asset/utils/taxi.jpeg')}}"
                         class="img-fluid rounded shadow-lg" draggable="false" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <div class="fs-4 mb-4">Driver Login</div>
                    <form action="{{route('driver.check')}}" method="POST">
                        @csrf
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

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>
                            <a class="btn btn-link" href="{{route('driver.register')}}">Create account?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
