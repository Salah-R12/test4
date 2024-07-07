<?php
// src/Controller/UserController.php

namespace App\Controller;

use App\Entity\User;
use App\Enum\Role;
use App\Enum\Status;
use App\Form\Type\UserAddType;
use App\Form\Type\UserEditType;
use App\Form\UserFilterType;
use App\Repository\UserRepository;
use App\Service\PasswordService;
use App\Service\SecurityService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserController extends AbstractController
{
    #[Route('/users', name: 'user_list')]
    public function list(Request $request, UserRepository $userRepository, PaginatorInterface $paginator): Response
    {
        // Création du formulaire de filtre
        $filterForm = $this->createForm(UserFilterType::class, null, [
            'method' => 'GET', // Utiliser la méthode GET pour inclure les paramètres dans l'URL
        ]);
        $filterForm->handleRequest($request);

        // Initialisation des critères de recherche
        $criteria = $filterForm->getData() ?? [];

        // Récupération des rôles de l'utilisateur
        $userRoles = $this->getUser()->getRoles();

        // Récupération de la QueryBuilder avec les filtres appliqués
        $queryBuilder = $userRepository->findUsersWithFilters($criteria, $userRoles);

        // Inclusion des paramètres actuels dans la pagination
        $queryParams = $request->query->all();

        // Utilisation de KnpPaginator pour la pagination
        $pagination = $paginator->paginate(
            $queryBuilder->getQuery(),
            $request->query->getInt('page', 1),
            10,
            ['query' => $queryParams]
        );

        // Compter le nombre total d'utilisateurs après filtrage
        $filteredUserCount = $pagination->getTotalItemCount();

        // Compter le nombre total d'utilisateurs dans la base
        $totalUserCount = $userRepository->count([]);

        // Rendu de la vue
        return $this->render('user/list.html.twig', [
            'filterForm' => $filterForm->createView(),
            'pagination' => $pagination,
            'filteredUserCount' => $filteredUserCount,
            'totalUserCount' => $totalUserCount,
        ]);
    }

    #[Route('/user/edit/{id?-1}', name: 'user_edit', requirements: ['id' => '\d+'])]
    public function edit(
        int $id,
        EntityManagerInterface $emi,
        Request $request,
        TranslatorInterface $trans,
        SecurityService $securityService
    ): Response
    {
        $method = $request->getMethod();
        $userRepo = $emi->getRepository(User::class);
        $roles_choices = Role::from($this->getUser()->getProfileType())->getArrayEditableRoles();
        if ($id != -1 && $method === 'GET') {
            $userEditForm = $this->createForm(UserEditType::class, $userRepo->find($id), [
                'action' => $this->generateUrl('user_edit', ['id' => $id]),
                'roles_choices' => $roles_choices,
            ]);
        } else {
            $userEditForm = $this->createForm(UserEditType::class, options: [
                'roles_choices' => $roles_choices,
            ]);
        }
        
        if ($method == 'POST') {
            $userId = $request->get('user_id');
            $user = $userRepo->find($userId);
            $formData = $request->get('user_edit');
            if ($user->getEmail() === $formData['email']) {
                // Bypass email validation
                $email = $formData['email'];  
                unset($formData['email']); 
            }
            $userEditForm->submit($formData);
            if (
                $userEditForm->isSubmitted()
                && $userEditForm->isValid()
            ) {
                if(
                    !$request->get('confirmed') 
                    && !empty($userRepo->findHomonymous($formData['lastname'], $formData['firstname'], $userId))
                ){
                    $response = "HOMONYMOUS_DETECED";
                } else {
                    $newUser = $userEditForm->getData();
                    $user->setLastname($newUser->getLastname());
                    $user->setFirstname($newUser->getFirstname());
                    $user->setEmail($newUser->getEmail() ?? $email);
                    $user->setRoles($newUser->getRoles());
                    if ($newUser->getStatus() === Status::INACTIVE) {
                        $securityService->deactivateUser($user);
                    } else {
                        $user->setStatus(Status::ACTIVE);
                    }
                    $emi->flush();
                    $response = "UPDATED";
                }
            } else {
                $error = $userEditForm->getErrors(true)->current()->getMessage();
                $response = $trans->trans($error);
            }
            return new Response($response);
        }

        // Si la methode HTTP est GET
        return $this->render('user/edit.html.twig', [
            'userForm' => $userEditForm,
        ]);
    }

    #[Route('/user/new-password/{id}', name: 'user_new_password', requirements: ['id' => '\d+'])]
    public function newPassword(
        int $id,
        EntityManagerInterface $emi,
        PasswordService $passwordService,
    ): Response
    {
        $passwordService->generatePassword($emi->getRepository(User::class)->find($id));
        return new Response('PASSWORD_SENT');
    }

    #[Route('/user/add', name: 'user_add')]
    public function add(
        Request $request,
        PasswordService $passwordService,
        TranslatorInterface $trans,
        EntityManagerInterface $emi,
        Security $security // Ajouter l'argument Security
    ): Response
    {
        $roles_choices = Role::from($this->getUser()->getProfileType())->getArrayEditableRoles();
        $isTC = $security->isGranted('ROLE_TC'); // Vérification du rôle ROLE_TC

        $userAddForm = $this->createForm(UserAddType::class, options: [
            'roles_choices' => $roles_choices,
            'is_tc' => $isTC, // Passer cette information au formulaire
        ]);

        if ($request->getMethod() == 'POST') {
            $formData = $request->get('user_add');
            $userAddForm->submit($formData);
            if (
                $userAddForm->isSubmitted()
                && $userAddForm->isValid()
            ) {
                $user = $userAddForm->getData();
                if(
                    !$request->get('confirmed')
                    && !empty($emi->getRepository(User::class)->findHomonymous($formData['lastname'], $formData['firstname']))
                ){
                    $response = "HOMONYMOUS_DETECED";
                } else {
                    $user->setStatus(Status::ACTIVE);
                    $passwordService->generatePassword($user);
                    $response = "ADDED";
                }
            } else {
                $error = $userAddForm->getErrors(true)->current()->getMessage();
                $response = $trans->trans($error);
            }

            return new Response($response);
        }

        // Si la methode HTTP est GET
        return $this->render('user/add.html.twig', [
            'userForm' => $userAddForm,
        ]);
    }

}
