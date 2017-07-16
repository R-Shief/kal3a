<?php

namespace AppBundle;

use AppBundle\CouchDocument\AtomEntry;
use AppBundle\Entity\StreamParameters;
use Doctrine\Common\Persistence\ObjectRepository;
use SRL\Builder;

class Matcher
{
    /**
     * @var StreamParameters[]
     */
    private $entities;

    public function __construct(ObjectRepository $repo)
    {
        $this->entities = $repo->findBy(['enabled' => true]);
        $this->strings = array_map([$this, 'makeExpression'], $this->entities);
    }

    public function match($content)
    {
        $results = [];
        /** @var Builder $string */
        foreach ($this->strings as $key => $string) {
            if ($string->isMatching($content)) {
                $results[] = $this->entities[$key]->getName();
            }
        }
        return $results;
    }

    public function matchAtom(AtomEntry $atomEntry)
    {
        $string = $atomEntry->getContent()->getContent();
        foreach ($atomEntry->getLinks() as $link) {
            $string .= ' '. $link->getHref();
        }
        return $this->match($string);
    }


    private function makeExpression(StreamParameters $streamParameters)
    {
        $builder = new Builder();

        return $builder->anyOf(function (Builder $query) use ($streamParameters) {
            foreach ($streamParameters->getTrack() as $track) {
                $query->literally($track);
            }
        })->caseInsensitive();
    }
}
