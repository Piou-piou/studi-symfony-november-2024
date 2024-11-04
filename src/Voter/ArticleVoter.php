<?php

namespace App\Voter;

use App\Entity\Article;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ArticleVoter extends Voter
{
    public function __construct(private readonly Security $security)
    {

    }


    protected function supports(string $attribute, mixed $subject): bool
    {
        if (!$subject instanceof Article) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        if (!$user = $token->getUser()) {
            return false;
        }

        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }
        if ('a.pilloud' === $user->getUsername() && $subject->getId() === 1) {
            return true;
        }

        return false;
    }
}