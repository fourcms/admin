<?php
/*
 * This file is part of the FourCms Admin package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FourCms\Admin\Services;

use Illuminate\Config\Repository as ConfigRepository;
use Longman\Platfourm\Service\EntityService;

class GetPublicConfigService extends EntityService
{
    protected $config;

    public function __construct(
        ConfigRepository $config
    ) {
        $this->config = $config;
    }

    public function run()
    {
        $config = $this->config->get('a');

        $return = [];
        $return = ['aa' => 'bb'];

        return $return;
    }

}
