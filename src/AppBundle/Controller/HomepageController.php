<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HomepageController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('AppBundle:Post')->fetchAllActivePosts();

        return $this->render('AppBundle:Homepage:index.twig.html', array(
            'posts' => $posts,
        ));
    }

    public function viewPostAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $post = $em->getRepository('AppBundle:Post')->fetchActivePostById($id);

        if(!$post) {
            throw new NotFoundHttpException( 'Invalid id. Try again' );
        }
       
        return $this->render('AppBundle:Homepage:viewPost.twig.html', array(
            'post' => $post[0],
        ));
    }

    /**
     * @Route("/editor", name="editorhomepage")
     */
    public function editorAction()
    {
        return new Response('<html><body>Manage blog here!</body></html>');
    }
}
