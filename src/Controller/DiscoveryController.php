<?php

namespace App\Controller;

use App\Repository\DiscoveryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DiscoveryController extends AbstractController
{
	/**
	 * @Route("/discoveries", name="discovery.index")
	 */
	public function index(DiscoveryRepository $discoveryRepository):Response
	{
		
		$results = $discoveryRepository->findAll();

		return $this->render('discovery/index.html.twig', [
			'results' => $results
		]);
	}

	/**
	 * @Route("/discovery/{slug}", name="discovery.details")
	 */

	public function details(string $slug, DiscoveryRepository $discoveryRepository):Response
	{
		
		$discovery = $discoveryRepository->findOneBy([
			'slug' => $slug
		]);

		return $this->render('discovery/details.html.twig', [
			'discovery' => $discovery
		]);
	}

}