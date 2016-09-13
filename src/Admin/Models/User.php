<?php

namespace FourCms\Admin\Models;

use FourCms\Auth\RemoteUserTrait;
use Longman\Platfourm\User\Models\Eloquent\User as BaseUser;

class User extends BaseUser
{
    use RemoteUserTrait;
}
