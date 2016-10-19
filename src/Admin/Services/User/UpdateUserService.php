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
use Longman\Platfourm\Contracts\Auth\AuthUserService;
use Longman\Platfourm\Service\EntityService;

class UpdateUserService extends EntityService
{
    protected $repository;
    protected $authUserService;

    public function __construct(
        AuthUserService $authUserService,
        UserRepository $repository
    ) {
        $this->authUserService = $authUserService;
        $this->repository      = $repository;

        $authUserService->should('user.update');
    }

    public function run($id, array $data)
    {
        $this->checkRepository();

        if (! empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $entity = $this->repository->update($id, $data);

        return $this->parseResult($entity);
    }

}
