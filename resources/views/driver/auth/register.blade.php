@extends('layouts.driver')

@section('content')
    <section class="vh-100 d-flex justify-content-center align-items-center mt-5">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="{{asset('/asset/utils/taxi.jpeg')}}"
                         class="img-fluid rounded shadow-lg" draggable="false" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1 mt-5">
                    <form action="{{route('driver.store')}}" method="POST">
                        @csrf
                        <div class="mb-4 fs-4">Register</div>
                        <div class="form-outline mb-4">
                            <input id="name" name="name" class="form-control" value="{{old('name')}}"/>
                            <label class="form-label" for="name">Name</label>
                            @error('name')
                            <div class="text-danger">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="form-outline mb-4">
                            <input type="email" id="email" name="email" class="form-control" value="{{old('email')}}"/>
                            <label class="form-label" for="email">Email address</label>
                            @error('email')
                            <div class="text-danger">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="form-outline mb-4">
                            <select id="location" name="location" class="form-control" value="{{old('location')}}">
                                <option value="Coimbatore">Coimbatore</option>
                                <option value="Tiruppur">Tiruppur</option>
                                <option value="Karur">Karur</option>
                            </select>
                            <label class="form-label" for="location">Location</label>
                            @error('location')
                            <div class="text-danger">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="form-outline mb-4">
                            <input type="number" id="phone" name="phone" class="form-control" value="{{old('phone')}}"/>
                            <label class="form-label" for="phone">Phone</label>
                            @error('phone')
                            <div class="text-danger">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="form-outline mb-4">
                            <input type="password" id="password" name="password" class="form-control"
                                   value="{{old('password')}}"/>
                            <label class="form-label" for="password">Confirm Password</label>
                            @error('password')
                            <div class="text-danger">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="form-outline mb-4">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="form-control"
                                   value="{{old('password_confirmation')}}"/>
                            <label class="form-label" for="password_confirmation">Password</label>
                            @error('password_confirmation')
                            <div class="text-danger">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary btn-block mb-4">Sign up</button>
                            <a class="btn btn-link" href="{{route('driver.login')}}">Already have account?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
