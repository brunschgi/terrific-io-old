<?php

namespace Terrific\Composition\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class PreCompilerController extends Controller
{
    /**
     * @Route("/api/precompile/{type}", requirements={"type"=".+"}, name="precompile")
     * @Method({"POST"})
     */
    public function precompileAction(Request $request, $type)
    {
        $precompiler = $this->get('terrific_composition.precompiler');
        return new Response($precompiler->precompile($request->getContent(), $type));
    }
}
