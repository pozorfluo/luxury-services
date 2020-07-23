<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Security;
use App\Entity\User;
use App\Entity\Profile;

class ProfileVoter extends Voter
{
    const VIEW = 'view';
    const EDIT = 'edit';
    const DELETE = 'delete';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [
            self::VIEW,
            self::EDIT,
            self::DELETE
        ])
            && $subject instanceof Profile;
    }

    protected function voteOnAttribute(
        string $attribute,
        $subject,
        TokenInterface $token
    ): bool {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!($user instanceof UserInterface)) {
            return false;
        }

        // some magic happening with supports() allows this.
        /** @var Profile $profile */
        $profile = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($profile, $user);
            case self::EDIT:
                return $this->canEdit($profile, $user);
            case self::DELETE:
                return $this->canDelete($profile, $user);
        }

        return false;
    }

    private function canView(Profile $profile, User $user): bool
    {
        return $user === $profile->getUser();
    }

    private function canEdit(Profile $profile, User $user): bool
    {
        return $user === $profile->getUser();
    }

    private function canDelete(Profile $profile, User $user): bool
    {
        return $user === $profile->getUser();
    }
}
