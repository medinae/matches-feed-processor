<?php

namespace App\Match\Model;

class MatchCollection implements \Iterator
{
    private $matches = [];

    public function __construct(array $matches)
    {
        foreach ($matches as $match) {
            $this->addMatch($match);
        }
    }

    public function addMatch(Match $match): void
    {
        $this->matches[] = $match;
    }

    public function current()
    {
        return current($this->matches);
    }

    public function next()
    {
        next($this->matches);
    }

    public function key()
    {
        return key($this->matches);
    }

    public function valid()
    {
        return $this->current() instanceof Match;
    }

    public function rewind()
    {
        reset($this->matches);
    }
}
