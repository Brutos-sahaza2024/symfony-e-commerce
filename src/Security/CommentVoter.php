<?php

namespace App\Security;

use App\Entity\Comment;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class CommentVoter extends Voter
{
    const EDIT = 'EDIT';
    const DELETE = 'DELETE';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::DELETE]) && $subject instanceof Comment;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /** @var Comment $comment */
        $comment = $subject;

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($comment, $user);
            case self::DELETE:
                return $this->canDelete($comment, $user);
        }

        return false;
    }

    private function canEdit(Comment $comment, User $user): bool
    {
        return $user === $comment->getUser();
    }

    private function canDelete(Comment $comment, User $user): bool
    {
        return $user === $comment->getUser();
    }
}
