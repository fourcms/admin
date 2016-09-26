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
use Illuminate\Support\Facades\App;
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
        $return = [];
        $return['environment']  = App::environment();
        $return['debug']        = $this->config->get('app.debug') ? 'true' : 'false';
        $return['pusher_key']   = $this->config->get('broadcasting.connections.pusher.key');
        $return['langs']        = implode(',', App::getAvailableLocales());
        $return['default_lang'] = App::getDefaultLocale();

        return $return;
    }

}
