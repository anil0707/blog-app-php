<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Post;
use AppBundle\Form\PostForm;

class ManagePostController extends Controller
{
	public function listPostsAction(){

		$em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('AppBundle:Post')->fetchAllPosts();

        return $this->render('AppBundle:Post:list.twig.html', array(
            'posts' => $posts,
        ));
	}

	public function addAction(Request $request)
    {
        $postEntityObj = new Post();
        $form = $this->createNewPostForm($postEntityObj);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $postEntityObj->setUser($this->get('security.context')->getToken()->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($postEntityObj);
            $em->flush();

            return $this->redirect($this->generateUrl('editor_post_list'));
        }

        return $this->render('AppBundle:Post:add.twig.html', array(
            'post'	 => $postEntityObj,
            'form'   => $form->createView(),
        ));
    }

    private function createNewPostForm(Post $entity)
    {
        $form = $this->createForm(new PostForm(), $entity, array(
            'action' => $this->generateUrl('add_post'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Save'));

        return $form;
    }

    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $postDataArr = $em->getRepository('AppBundle:Post')->fetchPostById($id);

        if (!$postDataArr) {
            throw $this->createNotFoundException('Invalid Id.');
        }

        $postEditForm = $this->createEditForm($postDataArr[0]);
        $postEditForm->handleRequest($request);

        if ($postEditForm->isValid()) {

        	$em->persist($postDataArr[0]);
            $em->flush();

            return $this->redirect($this->generateUrl('editor_post_list'));
        }

        return $this->render('AppBundle:Post:add.twig.html', array(
            'entity'      => $postDataArr[0],
            'form'   => $postEditForm->createView()
        ));
    }
    
    private function createEditForm(Post $entity)
    {
        $form = $this->createForm(new PostForm(), $entity, array(
            'action' => $this->generateUrl('edit_post', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $postDataArr = $em->getRepository('AppBundle:Post')->fetchPostById($id);

        if (!$postDataArr) {
            throw $this->createNotFoundException('Invalid Id');
        }

        $em->remove($postDataArr[0]);
        $em->flush();

        return $this->redirect($this->generateUrl('editor_post_list'));
    }
}
