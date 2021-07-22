<?php

namespace App\Twig;

use App\Entity\User;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AdminCheck extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('isAdmin', [$this, 'isAdmin'])
        ];
    }

    public function isAdmin(?User $user): bool
    {
        if ($user != null) {
            $userRole = $user->getRoles();
            if ($userRole[0] == "ROLE_ADMIN") {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
