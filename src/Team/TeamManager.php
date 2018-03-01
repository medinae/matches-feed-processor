<?php

namespace App\Team;

use App\Repository\MatchRepository;

class TeamManager
{
    private $matchRepository;

    public function __construct(MatchRepository $repository)
    {
        $this->matchRepository = $repository;
    }

    public function getGoalScoredBy(string $team): int
    {
        $goals = 0;

        foreach ($this->matchRepository->getMatchesInformationByTeam($team) as $match) {
            $goals += $match->getHomeTeam() === $team ? $match->getHomeTeamScore() : $match->getAwayTeamScore();
        }

        return $goals;
    }
}