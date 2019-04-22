<?php

declare(strict_types = 1);

namespace App\Controller\User;

use DomainException;
use App\SocialManagement\User\Application\Query\UserQuery;
use App\SocialManagement\User\Domain\UserNotExist;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\AuthController;

final class UserController extends AuthController
{
    /**
     * @param Request $request
     * @param UserQuery $userQuery
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function login(Request $request, UserQuery $userQuery)
    {
        try {
            $user = $userQuery->login($request);
        } catch (DomainException $e) {
            $this->addFlash('notice', $e->getMessage());
            return $this->redirectToRoute('login');
        }

        $this->get('session')->set('userid', $user->getId());

        return $this->redirectToRoute('group_index');
    }
}
