<?php

namespace App\Http\Requests;

use App\Models\Ride;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RatingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $ride = Ride::find($this->route('id'));
        $user = User::find($ride->user_id);
        return Auth::id() == $user->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'rating' => 'required|min:0|max:5',
        ];
    }
}
