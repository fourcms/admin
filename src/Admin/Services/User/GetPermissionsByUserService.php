<?php
/*
 * This file is part of the FourCms Admin package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FourCms\Admin\Services\User;

use FourCms\Admin\Repositories\User\PermissionRepository;
use Longman\Platfourm\Contracts\Auth\AuthUserService;
use Longman\Platfourm\Service\EntityService;

class GetPermissionsByUserService extends EntityService
{
    protected $repository;
    protected $authUserService;

    public function __construct(
        AuthUserService $authUserService,
        PermissionRepository $repository
    ) {
        $this->authUserService = $authUserService;
        $this->repository      = $repository;

        //$authUserService->should('roles.*');
    }

    public function run($user_id, $columns = ['*'])
    {
        $this->checkRepository();

        $entity = $this->repository->find($id, $columns);
        return $entity;
    }

}
