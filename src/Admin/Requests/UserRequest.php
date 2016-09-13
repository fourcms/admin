<?php
/*
 * This file is part of the FourCms Admin package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
