<?php

namespace Terrific\Composition\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Terrific\ComposerBundle\Annotation\Composer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/data/module")
 */
class ModuleController extends Controller
{
    /**
     * @Route("/", defaults={"_format"="json"}, name="module_create")
     * @Method({"POST"})
     */
    public function createAction(Request $request)
    {
        $serializer = $this->container->get('serializer');
        $repo = $this->getDoctrine()->getRepository('TerrificComposition:Module');

        $tmpModule = $serializer->deserialize($request->getContent(), 'Terrific\Composition\Entity\Module', 'json');
        $module = $repo->create();
        $module = $repo->update($module->getId(), $tmpModule);

        return new Response($serializer->serialize($module, 'json'));
    }

    /**
     * @Route("/render/{id}", name="module_render")
     * @Template()
     */
    public function renderAction($id) {
        $repo = $this->getDoctrine()->getRepository('TerrificComposition:Module');

        $module = $repo->find($id);

        return array('module' => $module);
    }

    /**
     * @Route("/{id}", defaults={"_format"="json", "id"=""}, requirements={"id"=".*"}, name="module_read")
     * @Method({"GET"})
     */
    public function readAction($id)
    {
        $serializer = $this->container->get('serializer');
        $repo = $this->getDoctrine()->getRepository('TerrificComposition:Module');

        $module = null;

        if(!empty($id)) {
            $module = $repo->find($id);
        }
        else {
            // create default module
            $module = $repo->create();
        }

        return new Response($serializer->serialize($module, 'json'));
    }

    /**
     * @Route("/{id}", defaults={"_format"="json", "id"="new"}, requirements={"id"=".*"}, name="module_delete")
     * @Method({"DELETE"})
     */
    public function deleteAction($id)
    {
        $this->getDoctrine()->getRepository('TerrificComposition:Module')->delete($id);
        return new Response();
    }


}
