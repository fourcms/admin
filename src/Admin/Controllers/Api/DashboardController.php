<?php

namespace FourCms\Admin\Controllers\Api;

use FourCms\Admin\Controllers\ApiController;

class DashboardController extends ApiController
{

    /**
     * @SWG\Get(
     *     path="/admin/api/dashboard",
     *     description="Authenticats user",
     *     tags={"Admin - Authentication"},
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
    public function index()
    {

        return $this->response($this->getAuthService()->user()->toArray());
    }
}
