<?php

declare(strict_types = 1);

namespace App\Controller\UserGroup;

use App\SocialManagement\UserGroup\Application\Query\UserGroupQuery;
use App\SocialManagement\UserGroup\Domain\UserGroupNotExist;
use App\SocialManagement\UserGroup\Application\Command\UserGroupCommand;
use App\SocialManagement\UserGroup\Application\Command\UserGroupDeleteCommand;
use App\SocialManagement\User\Application\Query\UserQuery;
use App\SocialManagement\Group\Application\Query\GroupQuery;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use App\Controller\AuthController;

final class UserGroupController extends AuthController
{
    /**
     * @param Request $request
     * @param UserGroupCommand $userGroupCommand
     * @param UserQuery $userQuery
     * @param GroupQuery $groupQuery
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function joinGroup(Request $request, UserGroupCommand $userGroupCommand, UserQuery $userQuery, GroupQuery $groupQuery)
    {
        if ( ! parent::auth() ) {
            return $this->redirectToRoute('login');
        }

        try {
            $user = $userQuery->find((int)$request->get('userId'));
            $group = $groupQuery->find((int)$request->get('groupId'));

            try {
                $userGroupCommand->joinGroup($user, $group);
                $this->get('session')->getFlashBag()->add('success', 'joined the group');
            } catch (UniqueConstraintViolationException $e) {
                $this->get('session')->getFlashBag()->add('warn', $e->getMessage());
            }
        } catch (DomainException $e) {
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @param Request $request
     * @param UserGroupDeleteCommand $userGroupDeleteCommand
     * @param UserQuery $userQuery
     * @param GroupQuery $groupQuery
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function leaveGroup(Request $request, UserGroupDeleteCommand $userGroupDeleteCommand, UserQuery $userQuery, GroupQuery $groupQuery)
    {
        if ( ! parent::auth() ) {
            return $this->redirectToRoute('login');
        }

        try {
            $user = $userQuery->find((int)$request->get('userId'));
            $group = $groupQuery->find((int)$request->get('groupId'));

            $userGroupDeleteCommand->leaveGroup($user, $group);

            $this->get('session')->getFlashBag()->add('success', 'left the group');
        } catch (DomainException $e) {
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirect($request->headers->get('referer'));
    }
}
