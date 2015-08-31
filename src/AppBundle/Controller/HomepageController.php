<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Entity\Comment;

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
        
        $comment = new Comment();
        $form = $this->createCommentForm($id, $comment);

        return $this->render('AppBundle:Homepage:viewPost.twig.html', array(
            'post' => $post[0],
            'comments' => $this->getComments($id),
            'form' => $form->createView(),
        ));
    }

    public function addCommentAction($postId)
    {
        $comment = new Comment();
        $form = $this->createCommentForm($postId, $comment);
        $form->handleRequest($this->getRequest());

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $comment->setPost($em->getRepository('AppBundle:Post')->findOneById($postId));

            if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
                $comment->setUser($this->get('security.context')->getToken()->getUser());        
            }

            $em->persist($comment);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('view_post', array('id' => $postId)));
    }

    private function getComments($postId)
    {
        $em = $this->getDoctrine()->getManager();

        $comments = $em->getRepository('AppBundle:Comment')->findAllCommentsByPostId($postId);

        return $comments;
    }

    private function createCommentForm($id, Comment $comment)
    {
        $form = $this->createFormBuilder($comment)
            ->add('comment', 'textarea', array('label' => false))
            ->setAction($this->generateUrl('add_comment', array('postId' => $id)))
            ->setMethod('POST')
            ->add('save', 'submit', array('label' => 'Add Comment'))
            ->getForm();
       
        return $form;
    }
}
