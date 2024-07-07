<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

use App\Entity\User;

/**
 * class de service pour la gestion de email
 *
 * @see UserInterface
 */
class EmailSenderService
{
    /**
     * Constructeur
     *
     * @param MaillerInterface $mailer l'interface pour traiter les mails
     * @param Security $security l'objet sécurité pour récuperer les infos de l'utilisateur. 
     * @param TranslatorInterface $translator le translator
     * @param LoggerInterface $logger le logger
     * @param string $mailerAdress l'adresse mail de constance
     */
    public function __construct(
        private MailerInterface $mailer, 
        private Security $security, 
        private TranslatorInterface $translator,
        private LoggerInterface $logger,
        private string $mailerAdress
        ) {
    }  

    /**
     * Envoi le mail lié au mot de passe, 
     *
     * @param string $password le mot de passe à envoyer
     * @return bool vrai si le mail est OK
     */
    public function sendPasswordMail(User $user, $password) : bool
    {
        $email = (new Email())
            ->from($this->mailerAdress)
            ->to($user->getUserIdentifier())
            ->subject($this->translator->trans('mail.subject'))
            ->html($this->translator->trans('mail.body', ['PASSWORD' => $password]));

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            $this->logger->error($e->getMessage());
            return false;
        } 
        return true;
    }  
}