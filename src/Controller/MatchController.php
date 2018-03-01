<?php

namespace App\Controller;

use App\Repository\MatchRepository;
use App\Team\TeamManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MatchController
{
    public function matchAction(string $homeTeam, string $awayTeam, MatchRepository $matchRepository)
    {
        $matchDetails = $matchRepository->getRawMatchInformation($homeTeam, $awayTeam);
        if (empty($matchDetails)) {
            throw new NotFoundHttpException("Impossible to find a match between home team $homeTeam and away team $awayTeam");
        }

        return new JsonResponse($matchDetails);
    }

    public function scoredGoalsAction(string $team, TeamManager $teamManager)
    {
        try {
            $goals = $teamManager->getGoalScoredBy($team);
        } catch (\RuntimeException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }

        return new JsonResponse([
            'scored_goals' => $goals
        ]);
    }
}
