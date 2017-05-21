<?php 
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Location;


class LocationController extends Controller
{

	/**
	* @Route("/maintain/locations", name="ViewLocations")
	*/
	public function locationViewAll()
	{
		$repository = $this->getDoctrine()->getRepository('AppBundle:Location');
	    $location = $repository->findAll();


	    if (!$location) 
	    {
	    	throw $this->createNotFoundException('No locations in the system');
	    }

    // ... do something, like pass the $product object into a template
		return $this->render('maintain/locationList.html.twig', array('items'=>$location ));

//$product = $repository->findOneByName('Keyboard');

	}


    /**
     * @Route("/maintain/locations/new", name="LocationNew")
     */
	public function locationAction()
	{

		$NewLocation = new Location();
		$NewLocation->setDescription('Home Base');
		$NewLocation->setDeleted(false);

	    $em = $this->getDoctrine()->getManager();

	    // tells Doctrine you want to (eventually) save the Product (no queries yet)
	    $em->persist($NewLocation);

	    // actually executes the queries (i.e. the INSERT query)
	    $em->flush();


		return $this->render('maintain/location.html.twig', array('id'=>$NewLocation->getId() ));

	} 

	/**
	* @Route("/maintain/locations/item{ItemID}", name="LocationID")
	*/
	public function locationView($ItemID)
	{

	    $location = $this->getDoctrine()
	        ->getRepository('AppBundle:Location')
	        ->find($ItemID);

	    if (!$location) 
	    {
	    	throw $this->createNotFoundException('No location found for id '.$location);
	    }

    // ... do something, like pass the $product object into a template
		return $this->render('maintain/locationView.html.twig', array('id'=>$ItemID, 'Description'=>$location->getDescription() ));
	}

	/**
	* @Route("/maintain/locations/itemname/{ItemName}")
	*/
	public function locationViewSpecific($ItemName)
	{
		$repository = $this->getDoctrine()->getRepository('AppBundle:Location');
	    $location = $repository->findBy(array('Description' => $ItemName));


	    if (!$location) 
	    {
	    	throw $this->createNotFoundException('No location found for Name: '. $ItemName);
	    }

    // ... do something, like pass the $product object into a template
		return $this->render('maintain/locationList.html.twig', array('items'=>$location ));

//$product = $repository->findOneByName('Keyboard');

	}
}


