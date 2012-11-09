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
 * @Route("/api/snippet")
 */
class SnippetController extends Controller
{
    /**
     * @Route("/", defaults={"_format"="json"}, name="snippet_create")
     * @Method({"POST"})
     */
    public function createAction(Request $request)
    {
        $serializer = $this->container->get('serializer');
        $repo = $this->getDoctrine()->getRepository('TerrificComposition:Snippet');

        $snippet = $serializer->deserialize($request->getContent(), 'Terrific\Composition\Entity\Snippet', 'json');
        $snippet = $repo->create($snippet);

        return new Response($serializer->serialize($snippet, 'json'));
    }

    /**
     * @Route("/{id}", defaults={"_format"="json"}, name="snippet_read")
     * @Method({"GET"})
     */
    public function readAction($id)
    {
        $serializer = $this->container->get('serializer');
        $repo = $this->getDoctrine()->getRepository('TerrificComposition:Snippet');

        $snippet = $repo->find($id);

        if(!$snippet) {
            throw new \Exception('the snippet with the id "'.$id.'" could not be found');
        }

        return new Response($serializer->serialize($snippet, 'json'));
    }

    /**
     * @Route("/{id}", defaults={"_format"="json"}, name="snippet_update")
     * @Method({"PUT"})
     */
    public function updateAction(Request $request, $id)
    {
        $serializer = $this->container->get('serializer');
        $repo = $this->getDoctrine()->getRepository('TerrificComposition:Snippet');

        $snippet = $serializer->deserialize($request->getContent(), 'Terrific\Composition\Entity\Snippet', 'json');
        $snippet = $repo->update($id, $snippet);

        return new Response($serializer->serialize($snippet, 'json'));
    }

    /**
     * @Route("/{id}", defaults={"_format"="json", "id"="new"}, requirements={"id"=".*"}, name="snippet_delete")
     * @Method({"DELETE"})
     */
    public function deleteAction($id)
    {
        $repo = $this->getDoctrine()->getRepository('TerrificComposition:Snippet');
        $repo->delete($id);

        return new Response();
    }
}
