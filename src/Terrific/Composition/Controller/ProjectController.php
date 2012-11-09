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
 * @Route("/api/project")
 */
class ProjectController extends Controller
{
    /**
     * @Route("", defaults={"_format"="json"}, name="project_add")
     * @Method({"POST"})
     */
    public function addAction(Request $request)
    {
        $serializer = $this->container->get('serializer');
        $repo = $this->getDoctrine()->getRepository('TerrificComposition:Project');

        $project = $serializer->deserialize($request->getContent(), 'Terrific\Composition\Entity\Project', 'json');
        $project = $repo->create($this->getUser(), $project);

        $serializer->setGroups(array('project_details'));
        return new Response($serializer->serialize($project, 'json'));
    }

    /**
     * @Route("/list", defaults={"_format"="json"}, name="project_list")
     * @Method({"GET"})
     */
    public function listAction()
    {
        $serializer = $this->container->get('serializer');
        $repo = $this->getDoctrine()->getRepository('TerrificComposition:Project');

        $projects = $repo->getAll($this->getUser());

        $serializer->setGroups(array('project_list'));
        return new Response($serializer->serialize($projects, 'json'));
    }


    /**
     * @Route("/{id}", defaults={"_format"="json"}, requirements={"id"="\d+"}, name="project_get")
     * @Method({"GET"})
     */
    public function getAction($id)
    {
        $serializer = $this->container->get('serializer');
        $repo = $this->getDoctrine()->getRepository('TerrificComposition:Project');

        $project = $repo->get($this->getUser(), $id);

        if(!$project) {
            throw new \Exception('the project with the id "'.$id.'" could not be found');
        }

        $serializer->setGroups(array('project_details'));
        return new Response($serializer->serialize($project, 'json'));
    }

    /**
     * @Route("/{id}", defaults={"_format"="json"}, requirements={"id"="\d+"}, name="project_delete")
     * @Method({"DELETE"})
     */
    public function deleteAction($id)
    {
        $this->getDoctrine()->getRepository('TerrificComposition:Project')->delete($this->getUser(), $id);
        return new Response();
    }

    /**
     * @Route("/render/{id}", requirements={"id"="\d+"}, name="project_render")
     * @Template()
     */
    public function renderAction($id) {
        $repo = $this->getDoctrine()->getRepository('TerrificComposition:Project');

        $project = $repo->get($this->getUser(), $id);

        if(!$project) {
            throw new \Exception('the project with the id "'.$id.'" could not be found');
        }

        return array('project' => $project);
    }
}
