<?php
/*
 * This file is part of the FourCms Admin package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FourCms\Admin\Models;

use FourCms\Auth\RemoteUserTrait;
use Longman\Platfourm\User\Models\Eloquent\User as BaseUser;

class User extends BaseUser
{
    use RemoteUserTrait;
}
