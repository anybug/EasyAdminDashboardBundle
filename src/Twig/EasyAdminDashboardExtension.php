<?php
namespace EasyAdminFriends\EasyAdminDashboardBundle\Twig;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class EasyAdminDashboardExtension extends AbstractExtension
{
    private $config;
    private $tokenStorage;
    private $authorizationChecker;

    public function __construct(
        array $config, 
        AuthorizationCheckerInterface $authorizationChecker, 
        TokenStorageInterface $tokenStorage)
    {
        $this->config = $config;
        $this->authorizationChecker = $authorizationChecker;
        $this->tokenStorage = $tokenStorage;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('can_access_block', [$this, 'canAccessBlock']),
        ];
    }

    public function canAccessBlock(string $blockName): bool
    {
        $blockConfig = $this->config['blocks'][$blockName] ?? null;
        if (!$blockConfig) {
            return false;
        }

        $requiredRoles = $blockConfig['permissions'] ?? [];
        $hierarchyEnabled = $blockConfig['hierarchy'] ?? true;

        if (empty($requiredRoles)) {
            return true;
        }

        $token = $this->tokenStorage->getToken();
        if (!$token) {
            return false;
        }

        $userRoles = $token->getRoleNames();

         foreach ($requiredRoles as $requiredRole) {
            if ($hierarchyEnabled) {
                // Respecte la hiérarchie Symfony (comportement natif de isGranted)
                if ($this->authorizationChecker->isGranted($requiredRole)) {
                    return true;
                }
            } else {
                // Ignore la hiérarchie : vérifie si le rôle est exactement présent dans $userRoles
                if (in_array($requiredRole, $userRoles)) {
                    return true;
                }
            }
        }

        

        return false;
    }
}
