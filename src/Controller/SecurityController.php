<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/api/user/register', name: 'app_user_register')]
    public function register(
        UserPasswordHasherInterface $passwordHasher,
        DecoderInterface $decoder,
        EntityManagerInterface $em
    ): BackendResponse
    {
        // get parameters for new user from request
        $request = Request::createFromGlobals()->getContent();
        $input = $decoder->decode($request, 'json');

        // create new user entity
        $user = new User();
        $user->setUsername($input['username']);

        // hash the password (based on the security.yaml config for the $user class)
        $hashedPassword = $passwordHasher->hashPassword($user, $input['password']);
        $user->setPassword($hashedPassword);

        // persist and write new user to db
        $em->persist($user);
        $em->flush();

        return new BackendResponse('Successfully registered new user '.$input['username'].'.', 201);
    }
}
