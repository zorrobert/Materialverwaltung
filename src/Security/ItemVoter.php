<?php
declare(strict_types=1);

namespace App\Security;

use App\Entity\Item;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
class ItemVoter extends Voter
{
    const CREATE = 'create';
    const LIST = 'list';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::CREATE, self::LIST])) {
            return false;
        }

        if($subject == null ) {
            return true; 
        }

        // only vote on `Item` objects
        if (!$subject instanceof Item) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // you know $subject is an Item object, thanks to `supports()`
//        /** @var Item $item */
//        $item = $subject;

        return match($attribute) {
            #self::VIEW => $this->canView($post, $user),
            #self::EDIT => $this->canEdit($post, $user),
            self::CREATE => $this->canCreate($user),
            default => throw new \LogicException('This code should not be reached!')
        };
    }

    private function canCreate(User $user): bool
    {
        if(in_array('ROLE_ADMIN', $user->getRoles())){
            return true;
        }
        return false;
    }

//    private function canView(Post $post, User $user): bool
//    {
//        // if they can edit, they can view
//        if ($this->canEdit($post, $user)) {
//            return true;
//        }
//
//        // the Post object could have, for example, a method `isPrivate()`
//        return !$post->isPrivate();
//    }
//
//    private function canEdit(Post $post, User $user): bool
//    {
//        // this assumes that the Post object has a `getOwner()` method
//        return $user === $post->getOwner();
//    }
}