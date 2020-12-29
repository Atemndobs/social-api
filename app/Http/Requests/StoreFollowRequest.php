<?php

namespace App\Http\Requests;

use App\Models\Follow;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class StoreFollowRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('follow_create');
    }

    public function rules()
    {
        return [
            'follewer'     => [
                'integer',
                'min:-2147483648',
                'max:2147483647',
                'nullable',
            ],
            'is_following' => [
                'nullable',
                'in:' . implode(',', Arr::pluck(Follow::IS_FOLLOWING_RADIO, 'value')),
            ],
        ];
    }
}
