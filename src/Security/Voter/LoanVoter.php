<?php

namespace App\Security\Voter;

use App\Entity\Loan;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class LoanVoter extends Voter
{
    // public const EDIT = 'POST_EDIT';
    public const CREATE = 'LOAN_CREATE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        // return in_array($attribute, [self::EDIT, self::CREATE]);

        if ($subject instanceof Loan OR $subject == null) {
            
            return true; 
            // if(in_array($attribute, [self::EDIT, self::CREATE]))
        }
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            
            case self::CREATE:
                // logic to determine if the user can CREATE
                
                return true; 
                break;
        }

        return false;
    }
}
