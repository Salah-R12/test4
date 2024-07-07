<?php

namespace App\Security;

use App\Entity\User;
use App\Enum\Status;
use Symfony\Component\Security\Core\Exception\LockedException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof User) {
            return;
        }

        if ($user->getStatus() !== Status::ACTIVE) {
            throw new LockedException();
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
    }
}