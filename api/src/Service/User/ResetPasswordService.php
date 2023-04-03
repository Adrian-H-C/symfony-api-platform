<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\Password\EncoderService;
use App\Service\Request\RequestService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Request;

class ResetPasswordService
{
    private UserRepository $userRepository;
    private EncoderService $encoderService;

    public function __construct(UserRepository $userRepository, EncoderService $encoderService)
    {
        $this->userRepository = $userRepository;
        $this->encoderService = $encoderService;
    }

    // Borrar
    //  /**
    //  * @throws ORMException
    //  * @throws OptimisticLockException
    //  */
    // public function reset(Request $request): User
    // {
    //     $userId = RequestService::getField($request, 'userI');
    //     $resetPasswordToken = RequestService::getField($request, 'resetPasswordToken');
    //     $password = RequestService::getField($request, 'password');

    //     $user = $this->userRepository->findOneByIdAndResetPasswordToken($userId, $resetPasswordToken);
    //     $user->setPassword($this->encoderService->generateEncodedPassword($user, $password));
    //     $user->setResetPasswordToken(null);

    //     $this->userRepository->save($user);

    //     return $user;
    // }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function reset(string $userId, string $resetPasswordToken, string $password): User
    {
        $user = $this->userRepository->findOneByIdAndResetPasswordToken($userId, $resetPasswordToken);
        $user->setPassword($this->encoderService->generateEncodedPassword($user, $password));
        $user->setResetPasswordToken(null);

        $this->userRepository->save($user);

        return $user;
    }
}