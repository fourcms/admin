<?php

namespace FourCms\Admin\Controllers\Api;

use Illuminate\Http\Request;
use FourCms\Admin\Controllers\ApiController;
use Longman\Platfourm\User\Services\GetRolesService;

class RoleController extends ApiController
{

    public function __construct()
    {
        parent::__construct();

        $this->middleware('permission:role.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role.update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role.delete', ['only' => ['destroy']]);
    }

    /**
     * @SWG\Get(
     *     path="/admin/api/role",
     *     description="Roles list",
     *     tags={"Admin - Role"},
     *     @SWG\Parameter(
     *         description="perPage",
     *         name="perPage",
     *         required=false,
     *         type="integer",
     *         in="query",
     *         default="25"
     *     ),
     *     @SWG\Parameter(
     *         description="page",
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
     *         description="search",
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
     * Log the roles list of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'perPage' => 'numeric|min:1',
            'page'    => 'numeric|min:1',
        ]);

        $userService = $this->app->make(GetRolesService::class);

        $fields  = $request->get('fields', '*');
        $perPage = $request->get('perPage', 10);
        $page    = $request->get('page', 1);
        $sortBy  = $request->get('sortBy');

        $options                 = [];
        $options['status']       = $request->get('status');
        $options['search']       = $request->get('search');
        $options['searchFields'] = $request->get('searchFields');
        $items                   = $userService->run(['*'], null, $perPage, $page, $sortBy);

        return $this->response($items->toArray());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role        = new Role();
        $permissions = Permission::all();

        return view('admin.roles.create')
            ->with(['role' => $role, 'permissions' => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\RoleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $role = Role::create($request->all());

        $permissions = $request->permission;
        $status      = $this->assignPermissionsToRole($permissions, $role);

        Flash::success('Successfully created');

        return redirect('admin/roles');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role        = Role::findOrFail($id);
        $permissions = Permission::all();

        return view('admin.roles.edit')
            ->with(['role' => $role, 'permissions' => $permissions]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\RoleRequest $request
     * @param  int                            $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update($request->except(['name']));

        $permissions = $request->permission;
        $status      = $this->assignPermissionsToRole($permissions, $role);

        Flash::success('Successfully updated');

        return redirect('admin/roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        //$role->detachAllPermissions();
        //$role->users()->delete();
        //$role->perms()->delete();

        $status = $role->delete();

        $status ? Flash::success('Successfully deleted') : Flash::error('Error: Item not deleted');

        return redirect('admin/roles');
    }

    private function assignPermissionsToRole($permissions, $role)
    {
        if (empty($role)) {
            return false;
        }
        $role->detachAllPermissions();
        if (!empty($permissions)) {
            foreach ($permissions as $perm_id) {
                $role->attachPermission($perm_id);
            }
        }

        return true;
    }
}
