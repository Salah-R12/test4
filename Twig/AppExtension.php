<?php

namespace App\Twig;

use App\Service\UserFilterDataProvider;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    private UserFilterDataProvider $userFilterDataProvider;

    public function __construct(UserFilterDataProvider $userFilterDataProvider)
    {
        $this->userFilterDataProvider = $userFilterDataProvider;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('format_role', [$this, 'formatRole']),
        ];
    }

    public function formatRole(string $role): string
    {
        return $this->userFilterDataProvider->formatRole($role);
    }
}
