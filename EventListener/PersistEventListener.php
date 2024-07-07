<?php

namespace App\EventListener;

use DateTime;
use App\Entity\TrackingAction;
use App\Entity\User;
use App\Repository\TrackingActionRepository;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Events;
use Symfony\Bundle\SecurityBundle\Security;
use Doctrine\ORM\Event\PostPersistEventArgs;

/**
 * Ajout d'une ligne dans la table de tracking après chaque ajout d'objet dans la
 * base de données par un utilisateur.
 */
#[AsDoctrineListener(event: Events::postPersist, priority: 500, connection: 'default')]
class PersistEventListener
{
    private Security $security;
    private TrackingActionRepository $trackingActionRepository;

    public function __construct(Security $security, TrackingActionRepository $trackingActionRepository)
    {
        $this->security = $security;
        $this->trackingActionRepository = $trackingActionRepository;
    }

    /**
     * Après enregistrement d'une modification ou d'un nouvelle entitée dans la base de donnée,
     * enregistrer l'action dans la table de tracking
     *
     * @param PostPersistEventArgs $args Contient l'entité enregistré
     */
    public function postPersist(PostPersistEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof TrackingAction) {

            $entityManager = $args->getObjectManager();

            $userInt = $this->security->getUser();

            if (is_null($userInt)) {  // Sécurité pour les tests phpunit
                return;
            }

            $user = $entityManager->getRepository(User::class)->findOneBy([
                'email' => $userInt->getUserIdentifier()
            ]);

            $trackingAction = new TrackingAction();
            $trackingAction->setNomTable($entityManager->getClassMetadata(get_class($entity))->getTableName());
            $trackingAction->setUser($user);
            $trackingAction->setDateAction(new DateTime());

            $this->trackingActionRepository->save($trackingAction);
        }
    }
}
