<?php

namespace Terrific\Composition\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Terrific\ComposerBundle\Annotation\Composer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Composer("Any")
     * @Route("/{any}", name="any", requirements={"any" = "((?!api\/).)*"})
     * @Template("TerrificComposition:Default:index.html.twig")
     */
    public function anyAction($any)
    {
        return array();
    }

}
