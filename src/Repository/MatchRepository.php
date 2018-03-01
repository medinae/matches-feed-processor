<?php

namespace App\Repository;

use App\Match\MatchFactory;
use App\Match\Model\Match;
use App\Match\Model\MatchCollection;
use Doctrine\DBAL\Connection;

class MatchRepository
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getRawMatchInformation(string $homeTeam, string $awayTeam): array
    {
        $stmt = $this->connection->prepare('
            SELECT * FROM game
            WHERE home_team = :home_team AND away_team = :away_team
        ');

        $stmt->bindValue('home_team', $homeTeam);
        $stmt->bindValue('away_team', $awayTeam);

        $stmt->execute();

        return $stmt->fetch();
    }

    public function getMatchesInformationByTeam(string $team): MatchCollection
    {
        $stmt = $this->connection->prepare('
            SELECT * FROM game
            WHERE home_team = :team OR away_team = :team
        ');

        $stmt->bindValue('team', $team);

        $stmt->execute();

        $rawMatches = $stmt->fetchAll();
        if (0 ===  count($rawMatches)) {
            throw new \RuntimeException("Impossible to find existing match for team $team");
        }

        $matches = [];
        foreach ($rawMatches as $match) {
            $matches[] = MatchFactory::createMatchFromArray($match);
        }

        return new MatchCollection($matches);
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
