<?php

namespace App\Match\Model;

class Match
{
    private $id;
    private $venue;
    private $playedAt;
    private $homeTeam;
    private $awayTeam;
    private $homeTeamScore;
    private $awayTeamScore;
    private $competitionName;

    public function __construct(
        string $id,
        string $venue,
        \DateTimeInterface $playedAt,
        string $homeTeam,
        string $awayTeam,
        int $homeTeamScore,
        int $awayTeamScore,
        string $competitionName
    ) {
        $this->id = $id;
        $this->venue = $venue;
        $this->playedAt = $playedAt;
        $this->homeTeam = $homeTeam;
        $this->awayTeam = $awayTeam;
        $this->homeTeamScore = $homeTeamScore;
        $this->awayTeamScore = $awayTeamScore;
        $this->competitionName = $competitionName;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getVenue(): string
    {
        return $this->venue;
    }

    public function getPlayedAt(): \DateTimeInterface
    {
        return $this->playedAt;
    }

    public function getHomeTeam(): string
    {
        return $this->homeTeam;
    }

    public function getAwayTeam(): string
    {
        return $this->awayTeam;
    }

    public function getHomeTeamScore(): int
    {
        return $this->homeTeamScore;
    }

    public function getAwayTeamScore(): int
    {
        return $this->awayTeamScore;
    }

    public function getCompetitionName(): string
    {
        return $this->competitionName;
    }
}
