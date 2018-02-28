<?php

namespace App\Command;

use App\Match\SourceMatchesProviderInterface;
use App\Repository\MatchRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReindexMatchesCommand extends Command
{
    private $sourceMatchesProvider;
    private $matchRepository;

    public function __construct(SourceMatchesProviderInterface $sourceMatchesProvider, MatchRepository $matchRepository)
    {
        $this->sourceMatchesProvider = $sourceMatchesProvider;
        $this->matchRepository = $matchRepository;

        parent::__construct();
    }

    public function configure()
    {
       $this->setName('app:reindex:matches');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->matchRepository->cleanMatches();

        foreach ($this->sourceMatchesProvider->provide() as $match) {
            $this->matchRepository->insertMatch($match);
        }
    }
}
