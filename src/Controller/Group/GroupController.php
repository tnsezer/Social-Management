<?php

declare(strict_types = 1);

namespace App\Controller\Group;

use App\SocialManagement\Group\Application\Query\GroupQuery;
use App\SocialManagement\Group\Application\Command\GroupCommand;
use Symfony\Component\HttpFoundation\Request;
use App\SocialManagement\Group\Domain\GroupNotExist;
use App\Controller\AuthController;

final class GroupController extends AuthController
{
    /**
     * @param GroupQuery $groupQuery
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function index(GroupQuery $groupQuery)
    {
        if ( ! parent::auth() ) {
            return $this->redirectToRoute('login');
        }

        $groups = $groupQuery->getAll();
        $render =  $this->render('groups.html.twig', [
            'groups' => $groups
        ]);
        $render->headers->set('Content-Type', 'text/html');

        return $render;
    }

    /**
     * @param int $id
     * @param GroupQuery $groupQuery
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function find(int $id, GroupQuery $groupQuery)
    {
        if ( ! parent::auth() ) {
            return $this->redirectToRoute('login');
        }

        $session = $this->get('session');
        try {
            $group =  $groupQuery->find($id);
        } catch (DomainException $e) {
            $this->addFlash('error', $e->getMessage());
            $this->redirectToRoute('group_index');
        }

        $isJoin = $group->getUsersRelation()->exists(function ($key, $user) use ($session) {
            return $user->getUserId() === $session->get('userid');
        });
        $render =  $this->render('group.html.twig', [
            'group' => $group,
            'isJoin' => $isJoin
        ]);
        $render->headers->set('Content-Type', 'text/html');

        return $render;
    }
}
