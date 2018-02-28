<?php

namespace App\Repository;

use App\Match\Model\Match;
use Doctrine\DBAL\Connection;

class MatchRepository
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function insertMatch(Match $match): void
    {
        $stmt = $this->connection->prepare('
            INSERT INTO game VALUES (:id, :venue, :played_at, :home_team, :away_team, :home_team_score, :away_team_score, :competition_name)
        ');

        $stmt->bindValue('id', $match->getId());
        $stmt->bindValue('venue', $match->getVenue());
        $stmt->bindValue('played_at', $match->getPlayedAt()->format('Y-m-d H:i:s'));
        $stmt->bindValue('home_team', $match->getHomeTeam());
        $stmt->bindValue('away_team', $match->getAwayTeam());
        $stmt->bindValue('home_team_score', $match->getHomeTeamScore());
        $stmt->bindValue('away_team_score', $match->getAwayTeamScore());
        $stmt->bindValue('competition_name', $match->getCompetitionName());

        $stmt->execute();
    }

    public function cleanMatches(): void
    {
        $this->connection->executeQuery('DELETE FROM game');
    }
}
