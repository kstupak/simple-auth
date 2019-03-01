<?php
/*
 * This file is part of "simple-auth".
 *
 * (c) Kostiantyn Stupak <konstantin.stupak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SimpleAuth\Service;

use SimpleAuth\Event\UserEvent;
use SimpleAuth\Event\UserEvents;
use SimpleAuth\Model\User;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Toolbox\Infrastructure\Persistence\GenericRepository;
use Toolbox\Service\API\CRUDService;

/**
 * @method User get(string $id)
 */
abstract class UserService implements CRUDService, UserServiceInterface
{
    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    /** @var GenericRepository */
    protected $repository;

    public function requestUserPasswordReset(string $userId)
    {
        $user = $this->get($userId);
        $this->eventDispatcher->dispatch(UserEvents::PASSWORD_RESET_REQUESTED, new UserEvent($user));
    }

    public function confirmUserPasswordReset(string $resetToken, string $password): UserInterface
    {
        if (!$this->validatePassword($password)) {
            throw new \InvalidArgumentException('Provided password did not pass validation');
        }

        /** @var User $user */
        $user = $this->repository->findOneBy(['resetToken' => $resetToken]);
        $user->resetPassword($password);

        $event = new UserEvent($user);
        $this->eventDispatcher->dispatch(UserEvents::PASSWORD_RESET_CONFIRMED, $event);
        $this->repository->save($user);

        return $user;
    }

    public function validatePassword(string $password): bool
    {
        if (empty($password)) { return false; }
        return true;
    }
}