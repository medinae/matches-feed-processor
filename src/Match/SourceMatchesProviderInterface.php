<?php

namespace App\Match;

use App\Match\Model\MatchCollection;

interface SourceMatchesProviderInterface
{
    public function provide(): MatchCollection;
}