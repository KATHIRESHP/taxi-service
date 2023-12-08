@extends('layouts.user')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        <form action="{{route('user.update', $user->id)}}" method="POST">
                            @csrf
                            @method("PUT")
                            <div class="mb-4 fs-4">Update any time</div>
                            <div class="form-outline mb-4">
                                <label class="form-label" for="name">Name</label>
                                <input id="name" name="name" class="form-control" value="{{$user->name}}"/>
                                @error('name')
                                <div class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                            <div class="form-outline mb-4">
                                <label class="form-label" for="email">Email address</label>
                                <input type="email" id="email" name="email" class="form-control" value="{{$user->email}}"/>
                                @error('email')
                                <div class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary btn-block mb-4">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
