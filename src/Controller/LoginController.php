<?php

declare(strict_types = 1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class LoginController extends AbstractController
{
    public function index()
    {
        $render =  $this->render('login.html.twig');
        $render->headers->set('Content-Type', 'text/html');

        return $render;
    }
}
