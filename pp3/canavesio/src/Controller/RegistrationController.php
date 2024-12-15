<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/test', name:'test')]
    public function main()
    {
        return $this->render(view:'base.html.twig');
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Obtener el email del usuario
            $email = $user->getEmail();
    
            // Lógica de asignación de roles basada en el email
            $roles = ['ROLE_USER']; // Rol por defecto
    
            // Ejemplos de asignación de roles
            if (strpos($email, 'santiagoaragonadmin@gmail.com') !== false) {
                $roles = ['ROLE_ADMIN'];
            } elseif (strpos($email, 'santiagoaragonstock@gmail.com') !== false) {
                $roles = ['ROLE_GESTORSTOCK'];
            } elseif (strpos($email, 'santiagoaragonventas@gmail.com') !== false) {
                $roles = ['ROLE_VENDEDOR'];
            }
    
            // Asignar los roles al usuario
            $user->setRoles($roles);
    
            // Codificar contraseña
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
    
            $entityManager->persist($user);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_login');
        }
    
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
