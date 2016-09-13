<?php

namespace FourCms\Admin\Controllers\Api\Auth;

use Exception;
use Illuminate\Http\Request;
use FourCms\Admin\Controllers\ApiController;
use Longman\Platfourm\Auth\Services\UpdateAvatarService;
use Longman\Platfourm\Contracts\Auth\AuthUserService;
use Longman\Platfourm\Foundation\Exceptions\AuthException;

class AuthController extends ApiController
{

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $guest['only'] = [
            'postLogin',
        ];
        $auth['only']  = [
            'getUser',
            'getLogout',
            'getAvatar',
        ];

        $this->middleware('guest', $guest);
        $this->middleware('auth', $auth);
    }

    /**
     * @SWG\Post(
     *     path="/admin/api/auth/login",
     *     description="Authenticats user",
     *     tags={"Admin - Authentication"},
     *     @SWG\Parameter(
     *         description="Email",
     *         name="email",
     *         required=true,
     *         type="string",
     *         in="query",
     *         default="avto@itdc.ge"
     *     ),
     *     @SWG\Parameter(
     *         description="Password",
     *         name="password",
     *         required=true,
     *         type="string",
     *         in="query",
     *         default=""
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Authenticated User",
     *     ),
     * )
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $service = $this->app->make(AuthUserService::class);

        try {
            $user = $service->login($request);
        } catch (AuthException $e) {
            return $this->response(['error' => $e->getMessage()], 400);
        }

        return $this->response($user->toArray());
    }

    /**
     * @SWG\Get(
     *     path="/admin/api/auth/logout",
     *     description="User logout",
     *     tags={"Admin - Authentication"},
     *     @SWG\Response(
     *         response=200,
     *         description="",
     *     ),
     * )
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        $service = $this->app->make(AuthUserService::class);
        $user    = $service->user();
        $service->logout();

        return '';
    }

    /**
     * @SWG\Get(
     *     path="/admin/api/auth/user",
     *     description="Auth user data",
     *     tags={"Admin - Authentication"},
     *     @SWG\Response(
     *         response=200,
     *         description="",
     *     ),
     * )
     */
    public function getUser()
    {

        $service = $this->app->make(AuthUserService::class);
        $user    = $service->user();

        $userData = $user->toArray();

        return $this->response($userData);
    }

    /**
     * @SWG\Get(
     *     path="/admin/api/auth/avatar",
     *     description="Get user avatar",
     *     tags={"Admin - Authentication"},
     *     @SWG\Response(
     *         response=200,
     *         description="",
     *     ),
     * )
     */
    public function getAvatar()
    {
        $service = $this->app->make(AuthUserService::class);
        $user    = $service->user();

        $service = $this->app->make(UpdateAvatarService::class);

        try {
            $service->run();
        } catch (Exception $e) {

        }

        $avatar = $user->getAvatar();

        return $this->response(['avatar' => $avatar]);
    }

}
