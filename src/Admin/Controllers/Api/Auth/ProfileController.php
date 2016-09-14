<?php
/*
 * This file is part of the FourCms Admin package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FourCms\Admin\Controllers\Auth;

use App;
use App\Http\Requests\AuthProfileRequest;
use App\Services\Auth\UpdateProfileService;
use FourCms\Admin\Controllers\Controller;

class ProfileController extends Controller
{
    protected $httpNamespace = 'auth';
    protected $viewNamespace = 'common.auth';

    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function getProfile()
    {
        $user = $this->authUser->user();

        return $this->view('profile')
            ->with('user', $user);
    }

    public function putProfile(AuthProfileRequest $request)
    {
        $userService = App::make(UpdateProfileService::class);
        $item        = $userService->run($request->all());

        return $this->redirect('profile')
            ->with('success', 'Profile updated successfully');
        ;
    }
}
