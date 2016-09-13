<?php

namespace FourCms\Admin\Controllers\Api;

use Illuminate\Http\Request;
use FourCms\Admin\Controllers\ApiController;
use Longman\Platfourm\User\Services\CreateUserService;
use Longman\Platfourm\User\Services\DeleteUserService;
use Longman\Platfourm\User\Services\GetUserService;
use Longman\Platfourm\User\Services\GetUsersService;
use Longman\Platfourm\User\Services\RestoreUserService;
use Longman\Platfourm\User\Services\UpdateUserService;
use Longman\Platfourm\User\Services\UpdateUserStatusService;

class UserController extends ApiController
{

    public function __construct()
    {
        parent::__construct();

        $this->middleware('permission:user.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user.update', ['only' => ['edit', 'update', 'status']]);
        $this->middleware('permission:user.delete', ['only' => ['destroy']]);
    }

    /**
     * @SWG\Get(
     *     path="/admin/api/user",
     *     description="Users list",
     *     tags={"Admin - User"},
     *     @SWG\Parameter(
     *         description="Per page items count",
     *         name="perPage",
     *         required=false,
     *         type="integer",
     *         in="query",
     *         default="25"
     *     ),
     *     @SWG\Parameter(
     *         description="Page for pagination",
     *         name="page",
     *         required=false,
     *         type="integer",
     *         in="query",
     *         default="1"
     *     ),
     *     @SWG\Parameter(
     *         description="Comma separated fields",
     *         name="fields",
     *         required=false,
     *         type="string",
     *         in="query",
     *         default=""
     *     ),
     *     @SWG\Parameter(
     *         description="Search string",
     *         name="search",
     *         required=false,
     *         type="string",
     *         in="query",
     *         default=""
     *     ),
     *     @SWG\Parameter(
     *         description="Fields list for search",
     *         name="searchFields",
     *         required=false,
     *         type="string",
     *         in="query",
     *         default=""
     *     ),
     *     @SWG\Parameter(
     *         description="Items status. 1 - active, 2 - passive",
     *         name="status",
     *         required=false,
     *         type="integer",
     *         enum={"1", "2"},
     *         in="query",
     *         default=""
     *     ),
     *     @SWG\Parameter(
     *         description="Filter by role",
     *         name="role_id",
     *         required=false,
     *         type="integer",
     *         in="query",
     *         default=""
     *     ),
     *     @SWG\Parameter(
     *         description="Show trashed items. 1 - yes, 0 - no",
     *         name="trashed",
     *         required=false,
     *         type="integer",
     *         enum={"0", "1"},
     *         in="query",
     *         default="0"
     *     ),
     *     @SWG\Parameter(
     *         description="sortBy field. Format: field1:asc,field2:desc",
     *         name="sortBy",
     *         required=false,
     *         type="string",
     *         in="query",
     *         default=""
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="",
     *     ),
     * )
     * Log the users list of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'perPage' => 'numeric|min:1',
            'page'    => 'numeric|min:1',
            'status'  => 'in:1,2',
            'trashed' => 'in:0,1',
            'role_id' => 'exists:roles,id',
        ]);

        $userService = $this->app->make(GetUsersService::class);

        $fields  = $request->get('fields', '*');
        $perPage = $request->get('perPage', 10);
        $page    = $request->get('page', 1);
        $sortBy  = $request->get('sortBy');
        $trashed = $request->get('trashed');
        $role_id = $request->get('role_id');

        $options                 = [];
        $options['search']       = $request->get('search');
        $options['searchFields'] = $request->get('searchFields');
        if ($trashed) {
            $options['trashed'] = $trashed;
        }
        if ($role_id) {
            $options['role_id'] = $role_id;
        }
        if (!$this->getAuthService()->getUser()->isDeveloper()) {
            $options['is_developer'] = 0;
        }

        $items = $userService->run($fields, $options, $perPage, $page, $sortBy);

        return $this->response($items->toArray());
    }

    /**
     * @SWG\Post(
     *     path="/admin/api/user",
     *     description="Creates new user",
     *     tags={"Admin - User"},
     *     @SWG\Parameter(
     *         description="Email",
     *         name="email",
     *         required=true,
     *         type="string",
     *         in="query",
     *         default="someone@domain.com"
     *     ),
     *     @SWG\Parameter(
     *         description="Password",
     *         name="password",
     *         required=true,
     *         type="string",
     *         in="query",
     *         default="randompass"
     *     ),
     *     @SWG\Parameter(
     *         description="Password confirm",
     *         name="password_confirmation",
     *         required=true,
     *         type="string",
     *         in="query",
     *         default="randompass"
     *     ),
     *     @SWG\Parameter(
     *         description="Fullname",
     *         name="firstname",
     *         required=true,
     *         type="string",
     *         in="query",
     *         default="Firstname"
     *     ),
     *     @SWG\Parameter(
     *         description="Lastname",
     *         name="lastname",
     *         required=true,
     *         type="string",
     *         in="query",
     *         default="Lastname"
     *     ),
     *     @SWG\Parameter(
     *         description="Status",
     *         name="status",
     *         required=true,
     *         type="integer",
     *         enum={"1", "2"},
     *         in="query",
     *         default="1"
     *     ),
     *     @SWG\Parameter(
     *         description="Country ID",
     *         name="country_id",
     *         required=false,
     *         type="integer",
     *         in="query",
     *         default=""
     *     ),
     *     @SWG\Parameter(
     *         description="Mobile Phone",
     *         name="mobile_phone",
     *         required=false,
     *         type="string",
     *         in="query",
     *         default=""
     *     ),
     *     @SWG\Parameter(
     *         description="Gender",
     *         name="gender",
     *         required=false,
     *         type="integer",
     *         in="query",
     *         default=""
     *     ),
     *     @SWG\Parameter(
     *         description="Birth Date",
     *         name="birth_date",
     *         required=false,
     *         type="string",
     *         in="query",
     *         default=""
     *     ),
     *     @SWG\Parameter(
     *         description="Address",
     *         name="address",
     *         required=false,
     *         type="string",
     *         in="query",
     *         default=""
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Created User",
     *     ),
     * )
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|min:4|confirmed',
            'password_confirmation' => 'required|min:4',
            'firstname'             => 'required',
            'lastname'              => 'required',
            //'country_id'            => 'exists:countries,id',
            'status'                => 'required|in:1,2',
            'role_id'               => 'exists:roles,id',
        ]);

        $userService = $this->app->make(CreateUserService::class);
        $user        = $userService->run($request->only([
                                                            'email',
                                                            'password',
                                                            'firstname',
                                                            'lastname',
                                                            'status',
                                                            'role_id',
                                                            'country_id',
                                                            'mobile_phone',
                                                            'gender',
                                                            'birth_date',
                                                            'address',
                                                        ]));

        return $this->response($user->toArray());
    }

    /**
     * @SWG\Get(
     *     path="/admin/api/user/{id}",
     *     description="Return user",
     *     tags={"Admin - User"},
     *     @SWG\Parameter(
     *         description="ID",
     *         name="id",
     *         required=true,
     *         in="path",
     *         type="string",
     *         default="77777777-1111-1111-1111-111111111111"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="User response",
     *     ),
     * )
     *
     * @param  string $id
     * @return Response
     */
    public function show($id)
    {
        $service = $this->app->make(GetUserService::class);
        $user    = $service->run($id);
        return $this->response($user->toArray());
    }

    /**
     * @SWG\Put(
     *     path="/admin/api/user/{id}",
     *     description="Update user",
     *     tags={"Admin - User"},
     *     @SWG\Parameter(
     *         description="ID",
     *         name="id",
     *         required=true,
     *         in="path",
     *         type="string",
     *         default="77777777-1111-1111-1111-111111111111"
     *     ),
     *     @SWG\Parameter(
     *         description="Email",
     *         name="email",
     *         required=true,
     *         type="string",
     *         in="query",
     *         default="someone@domain.com"
     *     ),
     *     @SWG\Parameter(
     *         description="Password",
     *         name="password",
     *         required=false,
     *         type="string",
     *         in="query",
     *         default="randompass"
     *     ),
     *     @SWG\Parameter(
     *         description="Password confirm",
     *         name="password_confirmation",
     *         required=false,
     *         type="string",
     *         in="query",
     *         default="randompass"
     *     ),
     *     @SWG\Parameter(
     *         description="Fullname",
     *         name="firstname",
     *         required=true,
     *         type="string",
     *         in="query",
     *         default="Firstname"
     *     ),
     *     @SWG\Parameter(
     *         description="Lastname",
     *         name="lastname",
     *         required=true,
     *         type="string",
     *         in="query",
     *         default="Lastname"
     *     ),
     *     @SWG\Parameter(
     *         description="Status",
     *         name="status",
     *         required=false,
     *         type="string",
     *         enum={"1", "2"},
     *         in="query",
     *         default="1"
     *     ),
     *     @SWG\Parameter(
     *         description="Country ID",
     *         name="country_id",
     *         required=false,
     *         type="integer",
     *         in="query",
     *         default=""
     *     ),
     *     @SWG\Parameter(
     *         description="Mobile Phone",
     *         name="mobile_phone",
     *         required=false,
     *         type="string",
     *         in="query",
     *         default=""
     *     ),
     *     @SWG\Parameter(
     *         description="Gender",
     *         name="gender",
     *         required=false,
     *         type="integer",
     *         in="query",
     *         default=""
     *     ),
     *     @SWG\Parameter(
     *         description="Birth Date",
     *         name="birth_date",
     *         required=false,
     *         type="string",
     *         in="query",
     *         default=""
     *     ),
     *     @SWG\Parameter(
     *         description="Address",
     *         name="address",
     *         required=false,
     *         type="string",
     *         in="query",
     *         default=""
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Updated data",
     *     ),
     * )
     *
     * Handle a bank profile update request for the application.
     *
     * @param  string                   $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'email'                 => 'required|email|unique:users,email,' . $id,
            'password'              => 'min:4|confirmed',
            'password_confirmation' => 'min:4',
            'firstname'             => 'required',
            'lastname'              => 'required',
            //'country_id'            => 'exists:countries,id',
            'status'                => 'required|in:1,2',
        ]);

        $service = $this->app->make(UpdateUserService::class);
        $user    = $service->run($id, $request->only([
                                                         'email',
                                                         'password',
                                                         'firstname',
                                                         'lastname',
                                                         'status',
                                                         'country_id',
                                                         'mobile_phone',
                                                         'gender',
                                                         'birth_date',
                                                         'address',
                                                     ]));

        return $this->response($user->toArray());
    }

    /**
     * @SWG\Get(
     *     path="/admin/api/user/loginas/{id}",
     *     description="Login as other user",
     *     tags={"Admin - User"},
     *     @SWG\Parameter(
     *         description="ID",
     *         name="id",
     *         required=true,
     *         in="path",
     *         type="string",
     *         default="77777777-1111-1111-1111-111111111111"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="User response",
     *     ),
     * )
     *
     * @param  string $id
     * @return Response
     */
    public function loginAs($id)
    {
        $user = $this->getAuthService()->loginAs($id);

        return $this->response($user->toArray());
    }

    /**
     * @SWG\Get(
     *     path="/admin/api/user/logoutas",
     *     description="Logout from other user",
     *     tags={"Admin - User"},
     *     @SWG\Response(
     *         response=200,
     *         description="User response",
     *     ),
     * )
     *
     * @param  string $id
     * @return Response
     */
    public function logoutAs()
    {

        $user = $this->getAuthService()->logoutAs();

        return $this->response($user->toArray());
    }

    /**
     * @SWG\Delete(
     *     path="/admin/api/user/{id}",
     *     description="Delete user",
     *     tags={"Admin - User"},
     *     @SWG\Parameter(
     *         description="ID",
     *         name="id",
     *         required=true,
     *         in="path",
     *         type="string",
     *         default="77777777-1111-1111-1111-111111111111"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="empty data",
     *     ),
     * )
     */
    public function destroy($id)
    {
        $service = $this->app->make(DeleteUserService::class);
        $user    = $service->run($id);

        return $this->response($user->toArray());
    }

    /**
     * @SWG\Put(
     *     path="/admin/api/user/{id}/restore",
     *     description="Restore deleted user",
     *     tags={"Admin - User"},
     *     @SWG\Parameter(
     *         description="ID",
     *         name="id",
     *         required=true,
     *         in="path",
     *         type="string",
     *         default="77777777-1111-1111-1111-111111111111"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="empty data",
     *     ),
     * )
     */
    public function putRestore($id)
    {
        $service = $this->app->make(RestoreUserService::class);
        $user    = $service->run($id);

        return $this->response($user->toArray());
    }

    /**
     * @SWG\Put(
     *     path="/admin/api/user/{id}/status",
     *     description="Update user status",
     *     tags={"Admin - User"},
     *     @SWG\Parameter(
     *         description="ID",
     *         name="id",
     *         required=true,
     *         in="path",
     *         type="string",
     *         default="77777777-1111-1111-1111-111111111111"
     *     ),
     *     @SWG\Parameter(
     *         description="Status",
     *         name="status",
     *         required=true,
     *         type="integer",
     *         in="query",
     *         default="2"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Updated data",
     *     ),
     * )
     *
     * Handle a user update request for the application.
     *
     * @param  string                   $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function putStatus($id, Request $request)
    {
        $this->validate($request, [
            'status' => 'required',
        ]);

        $service = $this->app->make(UpdateUserStatusService::class);
        $user    = $service->run($id, $request->get('status'));

        return $this->response($user->toArray());
    }

    /**
     * @SWG\Get(
     *     path="/admin/api/user/statuses",
     *     description="Return user statuses",
     *     tags={"Admin - User"},
     *     @SWG\Response(
     *         response=200,
     *         description="Users statuses response",
     *     ),
     * )
     *
     * @return \Illuminate\Http\Response
     */
    public function getStatuses()
    {

        return $this->response(array_to_subarray(config('cms.user.statuses')));
    }
}
