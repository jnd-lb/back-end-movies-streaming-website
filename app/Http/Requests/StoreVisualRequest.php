<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVisualRequest extends FormRequest
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
        return [
            'movie_title'       => 'required|max:255',
            'duration'          => 'required',
            'language_id'       => 'required',
            'description'       => 'string|required',
            'movie_trailer'     => 'string|required',
            'year'              => 'date|required',
            'type_id'           => 'required',
            'poster_image_link' => 'required',
            'slug'              => 'string',
        ];
    }
}
