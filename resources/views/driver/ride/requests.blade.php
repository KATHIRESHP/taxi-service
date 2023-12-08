@extends('layouts.driver')

@section('content')
    <div class="d-flex justify-content-center align-items-center mt-5">
        <div class="d-flex flex-column">
            <div class="card-title">
                Ride Requests
            </div>
            <div class="card-body w-100">
                <table class="w-100 table table-striped table-bordered table-hover table-responsive">
                    <thead>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Requested Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @if(!$rides->isEmpty())
                            @foreach($rides as $ride)
                                <tr>
                                    <td>{{$ride->id}}</td>
                                    <td>{{$ride->user->name}}</td>
                                    <td>{{$ride->location}}</td>
                                    <td>{{$ride->requested_time}}</td>
                                    <td>
                                        <button class="btn {{($ride->status == "pending" ? "bg-warning" : "bg-danger")}}">{{$ride->status}} </button>
                                    </td>
                                    <td class="d-flex gap-2">
                                        <div>
                                            <form method="POST" action="{{route('driver.ride.accept', $ride->id)}}" style="display: {{auth()->user()->status == "available" ? "block": "none"}}">
                                                @method('PUT')
                                                @csrf
                                                <button type="submit" class="btn btn-success">Accept</button>
                                            </form>
                                        </div>
                                        <div>
                                            <form method="POST" action="{{route('driver.ride.reject', $ride->id)}}">
                                                @method('PUT')
                                                @csrf
                                                <button type="submit" class="btn btn-danger">Reject</button>
                                            </form>
                                        </div>
                                        <div>
                                            <a class="btn btn-primary" href="{{route('driver.ride.show', $ride->id)}}">Show</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6">No assignments yet!</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                {{$rides->links()}}
            </div>
        </div>
    </div>
@endsection
