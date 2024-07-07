<?php

namespace App\EventListener;

use DateTime;
use App\Entity\TrackingAction;
use App\Repository\UserRepository;
use App\Service\PasswordService;
use Symfony\Component\Routing\RouterInterface;
use App\Repository\TrackingActionRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Event\LoginFailureEvent;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use Symfony\Component\Security\Http\Event\LogoutEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Traque les connexions des utilisateurs.
 */
final class SecurityEventListener
{
    private TrackingActionRepository $trackingActionRepository;
    private UserRepository $userRepository;
    private RouterInterface $router;
    private Security $security;
    private RequestStack $requestStack;
    private PasswordService $passwordService;

    public function __construct(
        TrackingActionRepository $trackingActionRepository,
        UserRepository $userRepository,
        UrlGeneratorInterface $router,
        Security $security,
        RequestStack $requestStack,
        PasswordService $passwordService
    ) {
        $this->trackingActionRepository = $trackingActionRepository;
        $this->userRepository = $userRepository;
        $this->router = $router;
        $this->security = $security;
        $this->requestStack = $requestStack;
        $this->passwordService = $passwordService;
    }

    /**
     * Enregistre une connexion réussie.
     *
     * @param LoginSuccessEvent $event L'événement de connexion réussie.
     */
    #[AsEventListener(event: LoginSuccessEvent::class)]
    public function onLoginSuccessEvent(LoginSuccessEvent $event): void
    {
        $userInt = $event->getUser();

        if (is_null($userInt)) {
            return;
        }

        $user = $this->userRepository->findOneBy(['email' => $userInt->getUserIdentifier()]);
        if ($user === null) {
            return;
        }

        $session = $this->requestStack->getSession();

        if ($this->passwordService->isPasswordExpired($user)) {
            $this->trackAction($user, "AUTHENT OK - MODIF PASSWORD");
            $session->set('display_must_change_password', true);
            $session->set('must_change_password_user_id', $user->getId());
            $session->save();
            $this->security->logout(false);
            return;
        }

        $this->trackAction($user, "AUTHENT OK");
    }

    /**
     * Enregistre une tentative de connexion échouée.
     *
     * @param LoginFailureEvent $event L'événement de connexion échouée.
     */
    #[AsEventListener(event: LoginFailureEvent::class)]
    public function onLoginFailureEvent(LoginFailureEvent $event): void
    {
        $request = $event->getRequest();
        $user = $this->userRepository->findOneBy(['email' => $request->get('username')]);

        $session = $request->getSession();
        $session->set('last_remember_me', (bool) $request->get('_remember_me', false));
        $session->save();

        if (is_null($user)) {  // Sécurité pour les tests phpunit
            return;
        }

        $this->trackAction($user, "AUTHENT KO");
    }

    /**
     * Enregistre une action dans le tracking.
     *
     * @param $user
     * @param string $action
     */
    private function trackAction($user, string $action): void
    {
        $trackingAction = new TrackingAction();
        $trackingAction->setNomTable("NO TABLE");
        $trackingAction->setUser($user);
        $trackingAction->setDateAction(new DateTime());

        $this->trackingActionRepository->save($trackingAction);
    }
}
