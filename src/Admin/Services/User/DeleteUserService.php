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

use FourCms\Admin\Repositories\User\UserRepository;
use Longman\Platfourm\Auth\Exceptions\ForbiddenException;
use Longman\Platfourm\Contracts\Auth\AuthUserService;
use Longman\Platfourm\Service\EntityService;

class DeleteUserService extends EntityService
{

    protected $repository;

    protected $authUserService;

    public function __construct(
        AuthUserService $authUserService,
        UserRepository $repository
    ) {
        $this->authUserService = $authUserService;
        $this->repository      = $repository;

        $authUserService->should('user.delete');
    }

    public function run($id)
    {
        $this->checkRepository();

        $item = $this->repository->find($id);

        if ( ! $this->authUserService->canDeleteUser($item)) {
            throw new ForbiddenException('Do not have permission to update this user');
        }

        $item = $this->repository->delete($id);

        return $item;
    }
}
