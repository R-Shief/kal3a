<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Query;
use League\Csv\Writer;
use ONGR\ElasticsearchDSL\Aggregation\Bucketing\DateHistogramAggregation;
use ONGR\ElasticsearchDSL\Query\QueryStringQuery;
use ONGR\ElasticsearchDSL\Query\RangeQuery;
use ONGR\ElasticsearchDSL\Query\TermQuery;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Sensio;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Underscore\Types\Arrays;

/**
 * Class ExportController
 * @package AppBundle\Controller
 * @Sensio\Route("/query")
 */
class ExportController extends Controller
{
    /**
     * @Sensio\Route("/{query}")
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
     * @Sensio\Route("/{query}/{date}.json")
     */
    public function jsonAction(Query $query, \DateTime $date)
    {
        $results = $this->makeResults($query, $date);
        return new StreamedResponse(function () use ($results) {
            $k = 0;
            echo '[';
            foreach ($results as $result) {
                $k++;
                echo json_encode($result['_source']);
                if ($k < $results->count()) {
                    echo ',';
                }
                flush();
            }
            echo ']';
            flush();
        }, 200, [
          'Content-Type' => 'application/json',
        ]);
    }

    /**
     * @Sensio\Route("/{query}/{date}.csv")
     */
    public function csvAction(Query $query, \DateTime $date)
    {
        $results = $this->makeResults($query, $date);

        $response = new StreamedResponse(function () use ($results) {
            $k = 0;
            $csv = Writer::createFromFileObject(new \SplFileObject('php://output'));
            $row = [
              'id', 'published', 'content', 'title', 'lang', 'authors', 'categories', 'link_canonical', 'link_author', 'link_author_thumbnail', 'link_nofollow',
            ];
            $csv->insertOne($row);
            flush();
            foreach ($results as $result) {
                $row = [];
                $row['id'] = $result['_source']['id'];
                $row['published'] = $result['_source']['published'];
                $row['content'] = $result['_source']['content']['content'];
                $row['title'] = $result['_source']['title']['text'];
                $row['lang'] = $result['_source']['lang'];
                $row['authors'] = Arrays::from($result['_source']['authors'])->pluck('name')->implode(',');
                $row['categories'] = Arrays::from($result['_source']['categories'])->pluck('term')->implode(',');
                $row['link_canonical'] = Arrays::from($result['_source']['links'])->filter(function ($link) {
                    return $link['rel'] === 'canonical';
                })->pluck('href')->implode(',');
                $row['link_author'] = Arrays::from($result['_source']['links'])->filter(function ($link) {
                    return $link['rel'] === 'author';
                })->pluck('href')->implode(',');
                $row['link_author_thumbnail'] = Arrays::from($result['_source']['links'])->filter(function ($link) {
                    return $link['rel'] === 'author thumbnail';
                })->pluck('href')->implode(',');
                $row['link_nofollow'] = Arrays::from($result['_source']['links'])->filter(function ($link) {
                    return $link['rel'] === 'nofollow';
                })->pluck('href')->implode(',');
                $csv->insertOne($row);
                flush();
            }
            flush();
        }, 200, [
          'Content-Type' => 'text/csv',
        ]);
        $response->headers->set('Content-Disposition', $response->headers->makeDisposition(
          ResponseHeaderBag::DISPOSITION_ATTACHMENT,
          $date->format('Y-m-d').'.csv'
        ));

        return $response;
    }

    private function makeResults(Query $query, \DateTime $date)
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
          'gte' => $date->add(new \DateInterval('P1D'))->format('Y-m-d'),
          'lt' => $date->add(new \DateInterval('P1D'))->format('Y-m-d'),
        ]);
        $search->addFilter($rangeQuery);

        $results = $repo->findRaw($search);
        return $results;
    }
}
