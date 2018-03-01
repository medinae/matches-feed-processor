<?php

namespace App\Match;

use App\Match\Model\Match;

class MatchFactory
{
    public static function createMatchFromSimpleXmlElement(\SimpleXMLElement $xmlElement): Match
    {
        $teamsName = explode(' vs ', $xmlElement->name);
        if (false === $teamsName || 2 !== count($teamsName)) {
            throw new \RuntimeException("Match name value '{$xmlElement->name}' is not valid");
        }

        return new Match(
            (string) $xmlElement->event_id,
            (string) $xmlElement->venue,
            new \DateTime($xmlElement->date),
            (string) $teamsName[0],
            (string) $teamsName[1],
            (int) $xmlElement->home_team_score,
            (int) $xmlElement->away_team_score,
            (string) $xmlElement->competition_name
        );
    }

    public static function createMatchFromArray(array $match): Match
    {
        try {
            return new Match(
                $match['id'],
                $match['venue'],
                new \DateTime($match['played_at']),
                $match['home_team'],
                $match['away_team'],
                $match['home_team_score'],
                $match['away_team_score'],
                $match['competition_name']
            );
        } catch (\Exception $e) {
            throw new \RuntimeException('To create a Match instance, given array should contain keys : id, venue, played_at, home_team, away_team, home_team_score, away_team_score, competition_name');
        }
    }
}
