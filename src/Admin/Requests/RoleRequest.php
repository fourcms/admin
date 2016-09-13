<?php

namespace FourCms\Admin\Requests;

use App\Http\Requests\Request;

class RoleRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name'         => 'required|max:255',
            'display_name' => 'required|max:255',
        ];

        if ($this->isMethod('PUT')) {
            unset($rules['name']);
        }

        return $rules;
    }
}
