@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-center align-items-center mt-5">
        <div class="d-flex flex-column">
            <div class="d-flex justify-content-between mb-3">
                <div class="fs-4">
                    Drivers
                </div>
            </div>
            <div class="card-body w-100 shadow-lg rounded-3">
                <table class="w-100 table table-striped table-bordered table-hover table-responsive">
                    <thead>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Location</th>
                    <th>Phone</th>
                    <th>Rating</th>
                    <th>Status</th>
                    </thead>
                    <tbody>
                    @if(!$drivers->isEmpty())
                        @foreach($drivers as $driver)
                            <tr>
                                <td>{{$driver->id}}</td>
                                <td>{{$driver->name}}</td>
                                <td>{{$driver->email}}</td>
                                <td>{{$driver->location}}</td>
                                <td>{{$driver->phone}}</td>
                                <td>
                                    @if($driver->ratings->isEmpty())
                                        <div>
                                            No rating till now!
                                        </div>
                                    @else
                                        @php
                                            $sum = 0;
                                            foreach ($driver->ratings as $rating) {
                                                $sum += $rating->rating;
                                            }
                                        @endphp
                                        {{$sum/count($driver->ratings)}}
                                    @endif
                                </td>
                                <td>
                                    <button
                                        class="btn {{($driver->status == "available" ? "bg-success" : "bg-warning")}}">
                                        {{$driver->status}}
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6">No drivers !</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                {{$drivers->links()}}
            </div>
        </div>
    </div>
@endsection
