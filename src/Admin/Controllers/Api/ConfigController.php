<?php
/*
 * This file is part of the FourCms Admin package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FourCms\Admin\Controllers\Api;

use App;
use FourCms\Admin\Controllers\ApiController;
use FourCms\Admin\Services\GetPublicConfigService;
use Illuminate\Http\Request;

class ConfigController extends ApiController
{

    /**
     * @SWG\Get(
     *     path="/admin/api/config/public",
     *     description="Config",
     *     tags={"Admin - Config"},
     *     @SWG\Response(
     *         response=200,
     *         description="",
     *     ),
     * )
     * List of application public configs.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPublic(Request $request)
    {
        $service = App::make(GetPublicConfigService::class);

        $items = $service->run();

        return $this->response($items);
    }

}
