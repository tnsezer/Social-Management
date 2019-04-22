<?php

declare(strict_types = 1);

namespace App\Controller\UserMeeting;

use App\SocialManagement\UserMeeting\Application\Command\UserMeetingCommand;
use App\SocialManagement\UserMeeting\Application\Command\UserMeetingDeleteCommand;
use App\SocialManagement\UserMeeting\Application\Query\UserMeetingQuery;
use App\SocialManagement\User\Application\Query\UserQuery;
use App\SocialManagement\Meeting\Application\Query\MeetingQuery;
use App\SocialManagement\UserMeeting\Domain\UserMeetingNotExist;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\AuthController;

final class UserMeetingController extends AuthController
{
    /**
     * @return Response
     */
    private function checkAuth()
    {
        $response = new Response();
        $response->setContent(json_encode([
            'message' => 'auth error'
        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @param UserMeetingCommand $userMeetingCommand
     * @param UserQuery $userQuery
     * @param MeetingQuery $meetingQuery
     * @param UserMeetingQuery $userMeetingQuery
     * @return bool|Response
     */
    public function participationStatus(Request $request, UserMeetingCommand $userMeetingCommand, UserQuery $userQuery, MeetingQuery $meetingQuery, UserMeetingQuery $userMeetingQuery)
    {
        if ( ! parent::auth() ) {
            return $this->checkAuth();
        }

        try {
            $user = $userQuery->find((int)$request->get('userId'));
            $meeting = $meetingQuery->find((int)$request->get('meetingId'));
        } catch (DomainException $e) {
            $response = new Response();
            $response->setContent(json_encode([
                'message' => $e->getMessage()
            ]));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }

        $participation = (bool) $request->get('participation');

        $userMeeting = $userMeetingQuery->search($meeting, $user);

        if (0 === $userMeeting->count()) {
            $userMeetingCommand->createParticipation($participation, $user, $meeting);
        } else {
            $userMeeting = $userMeeting->first();
            $userMeetingCommand->updateParticipation($participation, $userMeeting);
        }

        $userMeetings = $userMeetingQuery->search($meeting);

        $response = new Response();
        $response->setContent(json_encode([
            'going' => count($userMeetings->filter(function ($item){ return $item->getParticipation() === true; })),
            'notgoing' => count($userMeetings->filter(function ($item){ return $item->getParticipation() === false; })),
        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @param UserMeetingDeleteCommand $userMeetingDeleteCommand
     * @param UserQuery $userQuery
     * @param MeetingQuery $meetingQuery
     * @param UserMeetingQuery $userMeetingQuery
     * @return Response
     */
    public function delete(Request $request, UserMeetingDeleteCommand $userMeetingDeleteCommand, UserQuery $userQuery, MeetingQuery $meetingQuery, UserMeetingQuery $userMeetingQuery)
    {
        if ( ! parent::auth() ) {
            return $this->checkAuth();
        }

        try {
            $user = $userQuery->find((int)$request->get('userId'));
            $meeting = $meetingQuery->find((int)$request->get('meetingId'));
        } catch (DomainException $e) {
            $response = new Response();
            $response->setContent(json_encode([
                'message' => $e->getMessage()
            ]));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }

        $userMeetingDeleteCommand->delete($user, $meeting);

        $userMeetings = $userMeetingQuery->search($meeting);

        $response = new Response();
        $response->setContent(json_encode([
            'going' => count($userMeetings->filter(function ($item){ return $item->getParticipation() === true; })),
            'notgoing' => count($userMeetings->filter(function ($item){ return $item->getParticipation() === false; })),
        ]));
        $response->headers->set('Content-Type', 'application/json');
    }
}
