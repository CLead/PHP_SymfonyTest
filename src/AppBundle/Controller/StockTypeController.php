<?php

namespace AppBundle\Controller;

use AppBundle\Entity\StockType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StockTypeController extends Controller
{


	/**
	* @Route("/StockTypes/new", name="newType")
	*/
	public function newAction(Request $request)
	{
		$type = new StockType();
		$type->setDescription('Dynamic?');
		$type->setDeleted(false);

		$form = $this->createFormBuilder($type)
					->add('Description', TextType::class)
					->add('save', SubmitType::class, array('label'=>'Create Stock Type'))
					->getForm();

		$form->handleRequest($request);

	    if ($form->isSubmitted() && $form->isValid()) {
	        // $form->getData() holds the submitted values
	        // but, the original `$task` variable has also been updated
	        $type = $form->getData();

	        // ... perform some action, such as saving the task to the database
	        // for example, if Task is a Doctrine entity, save it!
	        // $em = $this->getDoctrine()->getManager();
	        // $em->persist($task);
	        // $em->flush();


		    $em = $this->getDoctrine()->getManager();
		    $em->persist($type);
		    $em->flush();


	        //return $this->redirectToRoute('task_success');
	    }

		return $this->render('maintain/newType.html.twig', array('form' => $form->createView(), ));
	}
}