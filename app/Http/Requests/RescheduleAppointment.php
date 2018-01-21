<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class RescheduleAppointment extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $today = Carbon::today();
        return [
        'appointDateTime'       => 'required|after:'. $today .'',
        ];
    }

        public function messages()
        {
             return [
            'appointDateTime.after' => 'Cannot choose date beyond present date.',
            ];
        }
}
