<?php

namespace App\Security;


use App\Entity\User as AppUser;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof AppUser)
        {
            return;
        }

        if($user->getActive() == 0)
        {
            throw new CustomUserMessageAccountStatusException("Votre compte n'est pas activé !"); 
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
 
    }
}