<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\User;
use App\Form\Type\ForgotPasswordType;
use App\Form\Type\ModifyPasswordType;
use App\Service\PasswordService;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class PasswordController extends AbstractController
{
    #[Route(path: '/modify-password/{expired}', name: 'app_modify_password')]
    public function modifyPassword(
        Request $request,
        PasswordService $passwordService,
        string $expired,
        EntityManagerInterface $emi,
        Security $security
    ): Response 
    {
        $session = $request->getSession();

        $passwordForm = $this->createForm(ModifyPasswordType::class, options:
            [
                'action' => $this->generateUrl('app_modify_password', ['expired' => $expired]),
                'is_expired_password' => $expired === 'true',
            ]
        );

        $passwordForm->handleRequest($request);

        if ($request->getMethod() == 'POST') {

            $route = $request->headers->get('referer');
            $response = $this->redirect($route);

            $user = $this->getUser() ?? 
                $emi->getRepository(User::class)->find($session->get('must_change_password_user_id'));

            if (
                $passwordForm->isSubmitted()
                && $passwordForm->isValid()
                && $user instanceof User
            ) {
                $passwordService->changePassword($user, $request->get('modify_password')['newPassword']['first']['password'], false);
                $response->headers->clearCookie('DISPLAY_MODIFY_PASSWORD_MODAL');
                $session->set('last_modify_password_error', null);
                if ($expired === 'true') {
                    $session->remove('display_must_change_password');
                    $session->remove('must_change_password_user_id');
                    $security->login($user, 'security.authenticator.form_login.main');
                }
                $session->save();
            } else {
                $error = $passwordForm->getErrors(true)->current()->getMessage();
                $session->set('last_modify_password_error', $error);
                $session->save();
            }
            
            return $response;
        }

        // Si la methode HTTP est GET
        return $this->render('users/modify_password.html.twig', [
            'passwordForm' => $passwordForm,
            'expired' => $expired,
            'lastModifyPasswordError' => $session->get('last_modify_password_error'),
        ]);
    }


    #[Route(path: '/forgot-password', name: 'app_forgot_password')]
    public function forgotPassword(
        Request $request,
        PasswordService $passwordService,
        EntityManagerInterface $emi
    ): Response 
    {
        $session = $request->getSession();

        $forgotPasswordForm = $this->createForm(ForgotPasswordType::class, options:
            ['action' => $this->generateUrl('app_forgot_password')]
        );

        $forgotPasswordForm->handleRequest($request);

        if ($request->getMethod() == 'POST') {

            $route = $request->headers->get('referer');
            $response = $this->redirect($route); 

            if (
                $forgotPasswordForm->isSubmitted()
                && $forgotPasswordForm->isValid()
            ) {
                $user = $emi->getRepository(User::class)->findOneBy(['email' => $request->get('forgot_password')['username']]);
                $passwordService->generatePassword($user);
                $response->headers->clearCookie('DISPLAY_FORGOT_PASSWORD_MODAL');
                $session->set('last_forgot_password_error', null);
                $session->save();
            } else {
                $error = $forgotPasswordForm->getErrors(true)->current()->getMessage();
                $session->set('last_forgot_password_error', $error);
                $session->save();
            }
            
            return $response;
        }

        // Si la methode HTTP est GET
        return $this->render('users/forgot_password.html.twig', [
            'forgotPasswordForm' => $forgotPasswordForm,
            'lastForgotPasswordError' => $session->get('last_forgot_password_error'),
        ]);
    }
}