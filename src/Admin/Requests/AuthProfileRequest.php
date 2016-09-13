<?php

namespace FourCms\Admin\Requests;

use Longman\Platfourm\Auth\Services\AuthUserService as AuthUserServiceContract;

class AuthProfileRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(AuthUserServiceContract $authService)
    {
        $rules = [
            'first_name' => 'required|max:255',
            'last_name'  => 'required|max:255',
        ];

        if ($this->isMethod('PUT') && $this->get('email') !== $authService->user()->email) {
            $rules['email'] = 'required|email|unique:users,email';
        }

        return $rules;
    }
}
