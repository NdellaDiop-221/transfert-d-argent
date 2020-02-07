<?php

namespace App\Security\Voter;

use App\Entity\Compte;
use App\Entity\Depot;
use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class UserVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['POST', 'PUT', 'DELETE'])
            && $subject instanceof User || $subject instanceof Compte || $subject instanceof Depot;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($user->getRoles()[0] === "ROLE_SUPER_ADMIN") {
            return true;
        }

        if ($subject instanceof User) {

            if ($user->getRoles()[0] === "ROLE_CAISSIER" || $user->getRoles()[0] === "ROLE_PARTENAIRE") {
                return false;
            }

            if ($user->getRoles()[0] === "ROLE_ADMIN" && ($subject->getRoles()[0] === "ROLE_CAISSIER" || $subject->getRoles()[0] === "ROLE_PARTENAIRE")) {
                return true;
            }
        }

        if ($subject instanceof Compte) {
            switch ($attribute) {
                case 'POST':
                    return $user->getRoles()[0] === "ROLE_ADMIN" && $subject->getCreator()->getUsername() === $user->getUsername() && $subject->getPartenaire()->getUser()->getRoles()[0] === "ROLE_PARTENAIRE" && $subject->getPartenaire()->getUser()->getIsActive() === true;
                break;

                case 'PUT':
                    return $user->getRoles()[0] === "ROLE_ADMIN";
                break;

                case 'DELETE':
                    return $user->getRoles()[0] === "ROLE_ADMIN";
                break;

                default:
                    return false;
                break;
            }
        }
        
        if ($subject instanceof Depot) {
            if ($user->getRoles()[0] === "ROLE_PARTENAIRE") {
                return false;
            }
            return true;
        }
        return false;
    }
}