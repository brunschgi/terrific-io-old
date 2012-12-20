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

        $modules = $repo->findPage($this->getUser(), $type, $page);

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

        $module = $repo->findOneByUserAndId($this->getUser(), $id);

        $serializer->setGroups(array('module_details'));
        return new Response($serializer->serialize($module, 'json'));
    }

    /**
     * @Route("/{id}", defaults={"_format"="json"}, requirements={"id"="\d+"}, name="module_delete")
     * @Method({"DELETE"})
     */
    public function deleteAction($id)
    {
        $this->getDoctrine()->getRepository('TerrificComposition:Module')->delete($this->getUser(), $id);
        return new Response();
    }

    /**
     * @Route("/{id}", defaults={"_format"="json"}, name="module_update")
     * @Method({"PUT"})
     */
    public function updateAction(Request $request, $id)
    {
        $serializer = $this->container->get('serializer');
        $repo = $this->getDoctrine()->getRepository('TerrificComposition:Module');

        $tmpModule = $serializer->deserialize($request->getContent(), 'Terrific\Composition\Entity\Module', 'json');
        $module = $repo->update($this->getUser(), $id, $tmpModule);

        if($tmpModule->getShared() || $tmpModule->getInWork()) {
            // injecting dependencies into entity repositories is quite a pain, therefore this is made here
            $em = $this->getDoctrine()->getEntityManager();
            $precompiler = $this->get('terrific_composition.precompiler');

            $markup = $module->getMarkup();
            $markup->setCompiled($markup->getCode());

            $style = $module->getStyle();
            if($style->getMode() !== 'text/css') {
                // precompile styles
                $style->setCompiled($precompiler->precompile($style->getCode(), $style->getMode()));
            }
            else {
                $style->setCompiled($style->getCode());
            }

            $script = $module->getScript();
            $script->setCompiled($script->getCode());

            $em->flush();
        }

        return new Response($serializer->serialize($module, 'json'));
    }

    /**
     * @Route("/render/{id}", requirements={"id"="\d+"} , name="module_render")
     * @Template()
     */
    public function renderAction($id) {
        $repo = $this->getDoctrine()->getRepository('TerrificComposition:Module');
        $module = $repo->findOneByUserAndId($this->getUser(), $id);

        return array('module' => $module);
    }
}
