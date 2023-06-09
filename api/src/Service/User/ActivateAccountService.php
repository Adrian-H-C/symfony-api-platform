<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\Request\RequestService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Request;

class ActivateAccountService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    // Borrar
    // public function activate(Request $request, string $id): User
    // {
    //     $user = $this->userRepository->findOneInactiveByIdAndTokenOrFail(
    //       $id,
    //       RequestService::getField($request, 'token')
    //     );

    //     $user->setActive(true);
    //     $user->setToken(null);

    //     $this->userRepository->save($user);

    //     return $user;
    // }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function activate(string $id, string $token): User
    {
        $user = $this->userRepository->findOneInactiveByIdAndTokenOrFail($id, $token);

        $user->setActive(true);
        $user->setToken(null);

        $this->userRepository->save($user);

        return $user;
    }
}
