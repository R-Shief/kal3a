<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Query;
use ONGR\ElasticsearchDSL\Aggregation\Bucketing\DateHistogramAggregation;
use ONGR\ElasticsearchDSL\Query\QueryStringQuery;
use ONGR\ElasticsearchDSL\Query\RangeQuery;
use ONGR\ElasticsearchDSL\Query\TermQuery;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Class ExportController
 * @package AppBundle\Controller
 * @Route("/query")
 */
class ExportController extends Controller
{
    /**
     * @Route("/{query}")
     */
    public function indexAction(Query $query)
    {
        $repo = $this->get('es.manager.default.atom');
        $search = $repo->createSearch();

        if (!empty($query->getQ())) {
            $queryStringQuery = new QueryStringQuery($query->getQ());
            $search->addQuery($queryStringQuery);
        }

        if (!empty($query->getTerm())) {
            $termQuery = new TermQuery('categories.term.keyword', $query->getTerm());
            $search->addQuery($termQuery);
        }

        if (null !== $query->getPublishedStart() || null !== $query->getPublishedEnd()) {
            $parameters = [];
            if (null !== $query->getPublishedStart()) {
                $parameters['gte'] = $query->getPublishedStart()->format(\DateTime::ATOM);
            }
            if (null !== $query->getPublishedEnd()) {
                $parameters['lte'] = $query->getPublishedEnd()->format(\DateTime::ATOM);
            }
            $rangeQuery = new RangeQuery('published', $parameters);
            $search->addQuery($rangeQuery);
        }

        $agg = new DateHistogramAggregation('published', 'published', 'day');
        $search->addAggregation($agg);

        $results = $repo->findRaw($search);
        return $this->render('AppBundle:Export:index.html.twig', array(
          'query' => $query,
          'results' => $results,
        ));
    }

    /**
     * @Route("/{query}/{date}.{_format}")
     */
    public function segmentAction(Query $query, \DateTime $date, $_format)
    {
        $repo = $this->get('es.manager.default.atom');
        $search = $repo->createSearch();
        $search->setScroll();

        if (!empty($query->getQ())) {
            $queryStringQuery = new QueryStringQuery($query->getQ());
            $search->addQuery($queryStringQuery);
        }

        if (!empty($query->getTerm())) {
            $termQuery = new TermQuery('categories.term.keyword', $query->getTerm());
            $search->addQuery($termQuery);
        }

        $rangeQuery = new RangeQuery('published', [
          'gte' => $date->format(\DateTime::ATOM),
          'lt' => $date->add(new \DateInterval('P1D'))->format(\DateTime::ATOM),
        ]);
        $search->addQuery($rangeQuery);

        $results = $repo->findRaw($search);

        $serializer = $this->get('serializer');

        return new StreamedResponse(function () use ($serializer, $results, $_format) {
            $k = 0;
            if ($_format === 'json') {
                echo '[';
            }
            foreach ($results as $result) {
                $k++;
                echo $serializer->serialize($result['_source'], $_format);
                if ($_format === 'json' && $k < $results->count()) {
                    echo ',';
                }
                flush();
            }
            if ($_format === 'json') {
                echo ']';
            }
            flush();
        });
    }
}
