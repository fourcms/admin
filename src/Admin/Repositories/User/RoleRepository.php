<?php
/*
 * This file is part of the FourCms Admin package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FourCms\Admin\Repositories\User;

use Longman\Platfourm\Contracts\Repository\Repository;
use Longman\Platfourm\Contracts\Repository\RepositoryCriteria;
use Longman\Platfourm\Repository\Eloquent\BaseRepository;
use Longman\Platfourm\User\Models\Eloquent\Role;

class RoleRepository extends BaseRepository implements Repository, RepositoryCriteria
{

    public function model()
    {
        if (class_exists(\App\Models\Role::class)) {
            return \App\Models\Role::class;
        }
        return Role::class;
    }

}
