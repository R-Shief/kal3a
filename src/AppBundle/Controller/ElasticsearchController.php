<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as FOSRest;
use Nelmio\ApiDocBundle\Annotation as Nelmio;
use ONGR\ElasticsearchDSL\Aggregation\Bucketing\DateHistogramAggregation;
use ONGR\ElasticsearchDSL\Query\FullText\QueryStringQuery;
use ONGR\ElasticsearchDSL\Query\TermLevel\RangeQuery;
use ONGR\ElasticsearchDSL\Query\TermLevel\TermQuery;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class ElasticsearchController extends Controller
{
    /**
     * @Route("/query")
     */
    public function queryAction(Request $request)
    {
        $form = $this->createFormBuilder()
          ->add('q', TextareaType::class)
          ->add('term', TextType::class)
          ->add('published_gte', DateTimeType::class, [
            'label' => 'Published start',
          ])
          ->add('published_lte', DateTimeType::class, [
            'label' => 'Published end',
          ])
          ->getForm()
        ;

        $form->handleRequest($request);

        $results = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $repo = $this->get('es.manager.default.atom');
            $search = $repo->createSearch();

            $data = $form->getData();

            if (!empty($data['q'])) {
                $queryStringQuery = new QueryStringQuery($data['q']);
                $search->addQuery($queryStringQuery);
            }

            if (!empty($data['term'])) {
                $termQuery = new TermQuery('categories.term.keyword', $data['term']);
                $search->addQuery($termQuery);
            }

            if (!empty($data['published_gte']) || !empty($data['published_lte'])) {
                $parameters = [];
                if (!empty($data['published_gte'])) {
                    $parameters['gte'] = $data['published_gte']->format(\DateTime::ATOM);
                }
                if (!empty($data['published_lte'])) {
                    $parameters['lte'] = $data['published_lte']->format(\DateTime::ATOM);
                }
                $rangeQuery = new RangeQuery('published', $parameters);
                $search->addQuery($rangeQuery);
            }

            $agg = new DateHistogramAggregation('published', 'published', 'day');
            $search->addAggregation($agg);

            $results = $repo->findRaw($search);
        }

        return $this->render('AppBundle:Elasticsearch:query.html.twig', array(
          'form' => $form->createView(),
          'results' => $results,
        ));
    }

    /**
     * Read access to Elasticsearch indices, document and search APIs.
     *
     * @Nelmio\ApiDoc(section="Elasticsearch")
     * @FOSRest\Get("/elasticsearch")
     * @link https://www.elastic.co/guide/en/elasticsearch/reference/5.1/
     */
    public function indexAction($op = null, ServerRequestInterface $serverRequest)
    {
        return $this->forward('bangpound_guzzle_proxy.controller:proxy', [
          'endpoint' => 'elasticsearch',
          'path' => $op,
          'request' => $serverRequest,
        ]);
    }

    /**
     * Read access to Elasticsearch search APIs.
     *
     * @Nelmio\ApiDoc(section="Elasticsearch")
     * @FOSRest\Route("/elasticsearch/_search", methods={"GET","POST"})
     * @link https://www.elastic.co/guide/en/elasticsearch/reference/5.1/search.html
     */
    public function searchAction($op = null, ServerRequestInterface $serverRequest)
    {
        return $this->forward('bangpound_guzzle_proxy.controller:proxy', [
          'endpoint' => 'elasticsearch',
          'path' => '_search',
          'request' => $serverRequest,
        ]);
    }
}
