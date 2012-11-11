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
        $module = $repo->create($this->getUser(), $module);

        $serializer->setGroups(array('module_details'));
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

        $serializer->setGroups(array('module_list'));
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

        $module = $repo->findOneById($id);

        if(!$module) {
            throw new \Exception('the module with the id "'.$id.'" could not be found');
        }

        $serializer->setGroups(array('module_details'));
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
     * @Route("/{id}", defaults={"_format"="json"}, name="module_update")
     * @Method({"PUT"})
     */
    public function shareAction(Request $request, $id)
    {
        $serializer = $this->container->get('serializer');
        $repo = $this->getDoctrine()->getRepository('TerrificComposition:Module');

        $module = $serializer->deserialize($request->getContent(), 'Terrific\Composition\Entity\Module', 'json');
        $module = $repo->update($id, $module);

        return new Response($serializer->serialize($module, 'json'));
    }

    /**
     * @Route("/render/{id}/{type}", requirements={"id"="\d+", "type"="fresh|compiled"}, defaults={"type"="compiled"} , name="module_render")
     * @Template()
     */
    public function renderAction($id, $type) {
        $repo = $this->getDoctrine()->getRepository('TerrificComposition:Module');

        if($type === "compiled") {
            $module = $repo->find($id);
        }
        else {
            $module = $repo->findFresh($id);
        }

        if(!$module) {
            throw new \Exception('the module with the id "'.$id.'" could not be found');
        }

        return array('module' => $module);
    }
}
