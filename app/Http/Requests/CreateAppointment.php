<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class CreateAppointment extends FormRequest
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
        'appointRemarks'        => 'nullable',
        'service_id'            => 'required',
        'worker_id'             => 'required',
        'customer_id'           => 'required',
        'agree'                 => 'required',
        ];
    }

    public function messages()
    {
        return [
            'appointDateTime.after' => 'Date must be on current date and beyond.',
        ];
    }


}
