<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController.
 *
 * @Route("/embed")
 */
class EmbedController extends Controller
{
    /**
     * @Route
     * @Template
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {
        /** @var \Doctrine\DBAL\Connection $conn */
        $conn = $this->getDoctrine()->getConnection();
        $sql = 'SELECT * FROM tag_trend ORDER BY slope DESC LIMIT 0,10';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $trends = $stmt->fetchAll();

        return array(
            'trends' => $trends,
        );
    }
}
