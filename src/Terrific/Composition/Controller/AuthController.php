<?php

namespace Terrific\Composition\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Terrific\ComposerBundle\Annotation\Composer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AuthController extends Controller
{
    /**
     * @Composer("Auth")
     * @Route("/auth/", name="auth_index")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Composer("Auth Failure")
     * @Route("/auth/failure/", name="auth_failure")
     * @Template()
     */
    public function failureAction()
    {
        return array();
    }
}
