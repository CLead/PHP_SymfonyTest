<?php 
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Location;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class LocationController extends Controller
{

	/**
	* @Route("/locations/list", name="ViewLocations")
	*/
	public function locationViewAll()
	{
		$repository = $this->getDoctrine()->getRepository('AppBundle:Location');
	    $location = $repository->findBy(array('Deleted' => false));

	    if (!$location) 
	    {
	    	throw $this->createNotFoundException('No locations in the system');
	    }

		return $this->render('maintain/locationList.html.twig', array('items'=>$location ));
	}

	/**
	* @Route("/locations/service/edit", name="locationEditAjax")

	*/
	public function locationAjax(Request $request)
	{
		if ($request->isXMLHttpRequest()) 
		{         
			$ID = $request->request->get('id');
			$Desc = $request->request->get('NewVal');
			$em = $this->getDoctrine()->getManager();
			$Location = $em->getRepository('AppBundle:Location')->findOneBy(array('ID' => $ID));

		    if (!$Location) 
		    {
				return new JsonResponse(array('status' => '501', 'MSG' => 'Error'));
		    }

    		$Location->setDescription($Desc);
    		$em->flush();

        	return new JsonResponse(array('status' => '200', 'MSG' => 'OK'));
    	}

    	return new Response('Invalid Call', 400);
	}

	/**
	* @Route("/maintain/locations/delete?{ItemID}", name="DeleteLocation")
	*/
	public function locationDelete($ItemID)
	{
		$repository = $this->getDoctrine()->getRepository('AppBundle:Location');
		$location = $repository->findOneBy(array('ID' => $ItemID));
		
		if ($location)
		{
			$em = $this->getDoctrine()->getManager();
			$location->setDeleted(true);
			$em->flush();
		}
		
	    $location = $repository->findAll();

	    if (!$location) 
	    {
	    	throw $this->createNotFoundException('No locations in the system');
	    }

		return $this->redirectToRoute('ViewLocations');
	}	

    /**
     * @Route("/maintain/locations/new", name="LocationNew")
     */
	public function locationAdd(Request $request)
    {
        // create a task and give it some dummy data for this example
        $Location = new Location();
        $Location->setDescription("");
        $Location->setDeleted(false);

        $form = $this->createFormBuilder($Location)
            ->add('Description', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Add Location'))
            ->getForm();

    	$form->handleRequest($request);

    	if ($form->isSubmitted() && $form->isValid()) 
    	{
        // $form->getData() holds the submitted values
        // but, the original `$task` variable has also been updated
        	$Location = $form->getData();

        // ... perform some action, such as saving the task to the database
        // for example, if Task is a Doctrine entity, save it!
        	$em = $this->getDoctrine()->getManager();
         	$em->persist($Location);
         	$em->flush();

        	return $this->redirectToRoute('ViewLocations');
    	}

        return $this->render('maintain/newItem.html.twig', array('form' => $form->createView(), ));
    }
}


