<?php

namespace FourCms\Admin\Controllers;

use Longman\Platfourm\Http\Controllers\AdminController;

/**
 * @SWG\Swagger(
 *     basePath="/ge",
 *     produces={"application/json"},
 *     consumes={"application/json"},
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="CMS REST API v1",
 *         description="CMS API",
 *         @SWG\Contact(
 *             name="ITDC Team",
 *             email="avto@itdc.ge"
 *         ),
 *     ),
 * )
 */
abstract class ApiController extends AdminController
{

}
