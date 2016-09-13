<?php

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
            ->with('success', 'Profile updated successfully');;
    }
}
