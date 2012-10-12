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
 * @Route("/api/module")
 */
class ModuleController extends Controller
{
    /**
     * @Route("", defaults={"_format"="json"}, name="module_add")
     * @Method({"POST"})
     */
    public function addAction(Request $request)
    {
        $serializer = $this->container->get('serializer');
        $repo = $this->getDoctrine()->getRepository('TerrificComposition:Module');

        $module = $serializer->deserialize($request->getContent(), 'Terrific\Composition\Entity\Module', 'json');
        $module = $repo->create($module);

        return new Response($serializer->serialize($module, 'json'));
    }

    /**
     * @Route("/list/{type}/{page}", defaults={"_format"="json"}, name="module_list")
     * @Method({"GET"})
     */
    public function listAction($type, $page)
    {
        $serializer = $this->container->get('serializer');
        $repo = $this->getDoctrine()->getRepository('TerrificComposition:Module');

        $modules = $repo->findPage($type, $page);

        return new Response($serializer->serialize($modules, 'json'));
    }


    /**
     * @Route("/{id}", defaults={"_format"="json"}, requirements={"id"="\d+"}, name="module_get")
     * @Method({"GET"})
     */
    public function getAction($id)
    {
        $serializer = $this->container->get('serializer');
        $repo = $this->getDoctrine()->getRepository('TerrificComposition:Module');

        $module = $repo->find($id);

        if(!$module) {
            throw new \Exception('the module with the id "'.$id.'" could not be found');
        }

        return new Response($serializer->serialize($module, 'json'));
    }

    /**
     * @Route("/{id}", defaults={"_format"="json"}, requirements={"id"="\d+"}, name="module_delete")
     * @Method({"DELETE"})
     */
    public function deleteAction($id)
    {
        $this->getDoctrine()->getRepository('TerrificComposition:Module')->delete($id);
        return new Response();
    }

    /**
     * @Route("/render/{id}", requirements={"id"="\d+"}, name="module_render")
     * @Template()
     */
    public function renderAction($id) {
        $repo = $this->getDoctrine()->getRepository('TerrificComposition:Module');

        $module = $repo->find($id);

        if(!$module) {
            throw new \Exception('the module with the id "'.$id.'" could not be found');
        }

        return array('module' => $module);
    }
}
