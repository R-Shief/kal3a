<?php

namespace Rshief\Bundle\Kal3aBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 * @package Rshief\Bundle\Kal3aBundle\Controller
 * @Route("/embed")
 */
class EmbedController extends Controller
{
    /**
     * @Route
     * @Template
     */
    public function indexAction(Request $request)
    {
        /** @var \Doctrine\DBAL\Connection $conn */
        $conn = $this->getDoctrine()->getConnection();
        $sql = "SELECT * FROM tag_trend ORDER BY slope DESC LIMIT 0,10";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $trends = $stmt->fetchAll();

        return array(
            'trends' => $trends,
        );
    }
}
