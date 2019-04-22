<?php

declare(strict_types = 1);

namespace App\Controller\Meeting;

use App\SocialManagement\Meeting\Application\Query\MeetingQuery;
use App\SocialManagement\Meeting\Domain\MeetingNotExist;
use DomainException;
use App\Controller\AuthController;

final class MeetingController extends AuthController
{
    /**
     * @param int $id
     * @param MeetingQuery $meetingQuery
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function find(int $id, MeetingQuery $meetingQuery)
    {
        if ( ! parent::auth() ) {
            return $this->redirectToRoute('login');
        }

        try {
            $meeting = $meetingQuery->find($id);
        } catch (DomainException $e) {
            $this->addFlash('error', $e->getMessage());
            $this->redirectToRoute('group_index');
        }

        $render =  $this->render('meeting.html.twig', [
            'meeting' => $meeting
        ]);
        $render->headers->set('Content-Type', 'text/html');

        return $render;
    }
}
