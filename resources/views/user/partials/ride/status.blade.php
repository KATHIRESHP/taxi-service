<div class="d-flex gap-2">
    @if($ride->status == 'pending')
        <form action="{{route('user.ride.cancel', $ride->id)}}" method="POST" onsubmit="return confirm('Are you sure?')">
            @csrf
            @method('PUT')
            <button class="btn btn-warning">Cancel</button>
        </form>
    @endif
    @if($ride->status == 'ongoing' || $ride->status == 'picked')
        <form action="{{route('user.ride.complete', $ride->id)}}" method="POST" onsubmit="return confirm('Are you sure?')">
            @csrf
            @method('PUT')
            <button class="btn btn-success">Complete</button>
        </form>
    @endif
    @if($ride->status == 'payment')
        <form action="{{route('user.ride.pay', $ride->id)}}" method="POST" onsubmit="return confirm('Are you sure?')">
            @csrf
            @method('PUT')
            Total Fare: <span class="badge bg-primary fs-4 my-2">₹{{$ride->payment->amount}}</span>
            <button class="btn btn-success">Complete Payment</button>
        </form>
    @endif
    @if($ride->status == 'completed')
        <div>
            Total Fare: <span class="badge bg-primary fs-4 my-2">₹{{$ride->payment->amount}}</span>
            <form action="{{route('user.ride.rate', $ride->id)}}" method="POST"
                  class="bg-success text-light rounded py-2 px-4">
                @csrf
                @method("PUT")
                <span class="fs-4">Rate for the ride</span>
                <div class="d-flex gap-2">
                    <input type="radio" id="rating-1" value="1" name="rating"
                           class="form-check-input" {{$ride->rating->rating == "1" ? "checked" : ""}}
                            title="Not Satisfied"
                    >
                    <label for="rating-1">1</label>
                    <input type="radio" id="rating-2" value="2" name="rating"
                           class="form-check-input" {{$ride->rating->rating == "2" ? "checked" : ""}}
                            title="Average"
                    >
                    <label for="rating-2">2</label>
                    <input type="radio" id="rating-3" value="3" name="rating"
                           class="form-check-input" {{$ride->rating->rating == "3" ? "checked" : ""}}
                            title="Satisfied"
                    >
                    <label for="rating-3">3</label>
                    <input type="radio" id="rating-4" value="4" name="rating"
                           class="form-check-input" {{$ride->rating->rating == "4"? "checked" : ""}}
                            title="Good"
                    >
                    <label for="rating-4">4</label>
                    <input type="radio" id="rating-5" value="5" name="rating"
                           class="form-check-input" {{$ride->rating->rating == "5" ? "checked" : ""}}
                            title="Excellent"
                    >
                    <label for="rating-5">5</label>
                </div>
                <div class="d-flex justify-content-end my-3">
                    <button type="submit" class="btn btn-primary">Rate</button>
                </div>
            </form>

        </div>
    @endif
</div>
