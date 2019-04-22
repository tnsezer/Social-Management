<?php

declare(strict_types = 1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class AuthController extends AbstractController
{
    final public function auth()
    {
        if ($this->get('session')->get('userid') > 0 ) {
            return true;
        }

        return false;
    }
}
