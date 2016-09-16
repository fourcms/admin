<?php
/*
 * This file is part of the FourCms Admin package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FourCms\Admin\Controllers;

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
abstract class ApiController extends Controller
{

}
