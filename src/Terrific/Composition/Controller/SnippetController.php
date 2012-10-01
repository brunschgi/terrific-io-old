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
 * @Route("/data/snippet")
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

        $tmpSnippet = $serializer->deserialize($request->getContent(), 'Terrific\Composition\Entity\Snippet', 'json');
        $snippet = $repo->create();
        $snippet = $repo->update($snippet->getId(), $tmpSnippet);

        return new Response($serializer->serialize($snippet, 'json'));
    }

    /**
     * @Route("/{id}", defaults={"_format"="json", "id"=""}, requirements={"id"=".*"}, name="snippet_read")
     * @Method({"GET"})
     */
    public function readAction($id)
    {
        $serializer = $this->container->get('serializer');
        $repo = $this->getDoctrine()->getRepository('TerrificComposition:Snippet');

        $snippet = null;

        if(!empty($id)) {
            $snippet = $repo->find($id);
        }
        else {
            // create default snippet
            $snippet = $repo->create();
        }

        return new Response($serializer->serialize($snippet, 'json'));
    }

    /**
     * @Route("/{id}", defaults={"_format"="json", "id"="new"}, requirements={"id"=".*"}, name="snippet_update")
     * @Method({"PUT"})
     */
    public function updateAction(Request $request, $id)
    {
        $serializer = $this->container->get('serializer');
        $repo = $this->getDoctrine()->getRepository('TerrificComposition:Snippet');

        $tmpSnippet = $serializer->deserialize($request->getContent(), 'Terrific\Composition\Entity\Snippet', 'json');
        $snippet = $repo->update($id, $tmpSnippet);

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
