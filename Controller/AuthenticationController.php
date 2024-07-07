<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

use App\Form\Type\LoginType;
use Symfony\Bundle\SecurityBundle\Security;

// Class : Controller lié à la page de login
class AuthenticationController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(
        AuthenticationUtils $authenticationUtils,
        Request $request,
        RequestStack $requestStack,
        FormFactoryInterface $formFactory,
    ): Response
    {
        // Si l'utilisateur est déjà authentifié
        if ($this->getUser()) {
            return new RedirectResponse('/');  // Rediriger vers la page d'accueil
        }

        $error = $authenticationUtils->getLastAuthenticationError();  // récupère l'erreur d'authentification si elle existe
        $session = $requestStack->getSession();
        $lastRememberMe = $session->get('last_remember_me', true);
        $displayMustChangePassword = $session->get('display_must_change_password', false);

        $lastUsername = $authenticationUtils->getLastUsername();  // dernier identifiant entré
        
        // Créer le formulaire sans ajouter de préfix aux nom des champs
        $form = $formFactory->createNamed('', LoginType::class , options: [
            'last_username' => $lastUsername,
            'last_remember_me' => $lastRememberMe,
        ]);

        $form->handleRequest($request);

        return $this->render('authentication/login.html.twig', [
            'error' => $error,
            'form' => $form,
            'displayMustChangePassword' => $displayMustChangePassword,
        ]);
    }

    /**
     * Page de déconnexion. Nécessaire pour le bundle Security.
     */
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
