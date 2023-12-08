@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-center align-items-center mt-5">
        <div class="d-flex flex-column">
            <div class="d-flex justify-content-between mb-3">
                <div class="fs-4">
                    Previous day rides
                </div>
            </div>
            <div class="card-body w-100 shadow-lg rounded-3">
                <table class="w-100 table table-striped table-bordered table-hover table-responsive">
                    <thead>
                    <th>ID</th>
                    <th>Date</th>
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
                                <td>{{$ride->created_at}}</td>
                                <td>{{$ride->location}}</td>
                                <td>{{$ride->requested_time}}</td>
                                <td>
                                    <button class="btn {{($ride->status == "pending" ? "bg-warning text-dark" : "bg-success text-light")}}">{{$ride->status}} </button>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <form action="{{route('admin.ride.destroy', $ride->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                        <a class="btn btn-primary" href="{{route('admin.ride.show', $ride->id)}}">Show</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6">No rides yesturday!</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                {{$rides->links()}}
            </div>
        </div>
    </div>
@endsection
