<?php

namespace App\Match;

use App\Match\Model\MatchCollection;
use Symfony\Component\Finder\Finder;

class XmlFilesMatchesProvider implements SourceMatchesProviderInterface
{
    const SOURCE_DIR_PATH = __DIR__.'/../../data-feed';

    public function provide(): MatchCollection
    {
        $matches = [];

        foreach ($this->getSourceFilePaths() as $filePath) {
            if (false === $xml = file_get_contents($filePath)) {
                throw new \RuntimeException("Impossible to read the content of the file located at $filePath");
            }

            if (false === $xmlElement = simplexml_load_string($xml)) {
                throw new \RuntimeException("Impossible to load an xml element from string : $xml");
            }

            $matches[] = MatchFactory::createMatchFromSimpleXmlElement($xmlElement);
        }

        return new MatchCollection($matches);
    }

    private function getSourceFilePaths(): \Generator
    {
        $finder = new Finder();
        $files = $finder
            ->files()
            ->name('*.xml')
            ->depth(0)
            ->in(self::SOURCE_DIR_PATH)
        ;

        foreach ($files as $file) {
            yield $file->getRealPath();
        }
    }
}
