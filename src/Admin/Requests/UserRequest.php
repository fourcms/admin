<?php

namespace FourCms\Admin\Requests;

class UserRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            //'email'                 => 'required|email|unique:users',
            'first_name'            => 'required|max:255',
            'last_name'             => 'required|max:255',
            'password'              => 'required',
            'password_confirmation' => 'required|same:password',
        ];

        if ($this->isMethod('PUT')) {
            $routeParams = $this->route()->parameters();
            if (!empty($routeParams['users'])) {
                $rules['email'] = 'required|email|unique:users,email,' . $routeParams['users'];
            }
            unset($rules['password'], $rules['password_confirmation']);
        }

        return $rules;
    }
}
