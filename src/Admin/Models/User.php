<?php

namespace FourCms\Admin\Models;

use Itdc\Auth\RemoteUserTrait;
use Longman\Platfourm\User\Models\Eloquent\User as BaseUser;

class User extends BaseUser
{
    use RemoteUserTrait;
}
