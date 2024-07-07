<?php
// src/Controller/VolunteerController.php

namespace App\Controller;

use App\Entity\Constancien;
use App\Form\Type\Volunteer\VolunteerFilterType;
use App\Repository\ConstanciensRepository;
use App\Service\CriteriaValidator;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VolunteerController extends AbstractController
{
    #[Route('/volunteers', name: 'volunteer_list')]
    public function list(Request $request, ConstanciensRepository
    $constancienRepository, PaginatorInterface $paginator,CriteriaValidator $criteriaValidator): Response
    {
        // Création du formulaire de filtre
        $filterForm = $this->createForm(VolunteerFilterType::class, null, [
            'method' => 'GET', // Utiliser la méthode GET pour inclure les paramètres dans l'URL
        ]);
        $filterForm->handleRequest($request);

        // Initialisation des critères de recherche
        $criteria = $filterForm->getData() ?? [];

        $criteriaValidator->validateBirthdate($criteria);

        // Récupération de la QueryBuilder avec les filtres appliqués
        $queryBuilder = $constancienRepository->findVolunteersWithFilters($criteria);

        // Inclusion des paramètres actuels dans la pagination
        $queryParams = $request->query->all();

        // Utilisation de KnpPaginator pour la pagination
        $pagination = $paginator->paginate(
            $queryBuilder->getQuery(),
            $request->query->getInt('page', 1),
            10,
            ['query' => $queryParams]
        );

        // Compter le nombre total de volontaires après filtrage
        $filteredVolunteerCount = $pagination->getTotalItemCount();

        // Compter le nombre total de volontaires dans la base
        $totalVolunteerCount = $constancienRepository->count([]);

        // Rendu de la vue
        return $this->render('volunteer/list.html.twig', [
            'filterForm' => $filterForm->createView(),
            'pagination' => $pagination,
            'filteredVolunteerCount' => $filteredVolunteerCount,
            'totalVolunteerCount' => $totalVolunteerCount,
        ]);
    }

}
