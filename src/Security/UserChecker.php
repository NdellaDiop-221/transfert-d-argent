<?php
namespace App\Security;
 
use App\Entity\User as AppUser;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;

class UserChecker implements UserCheckerInterface
{
    public function checkerPreAuth(UserInterface $user)
    {
        if (!$user instanceof AppUser){
            return false;
        }
    }

    public function checkPosteAuth(UserInterface $user)
    {
        if(!$user instanceof AppUser){
            return;
        }

        if(!$user->getIsActive()){
            throw new AccountExpiredException();
        }
    }
}