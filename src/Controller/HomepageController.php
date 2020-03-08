<?php

// namespace
// App provient de composer.json
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{

	/**
	 * @Route("/", name="homepage.index")
	 */
	public function index(Request $request):Response
	{
		$userAgent = $request->server->get('HTTP_USER_AGENT');

		return $this->render('homepage/index.html.twig', [
			'param' => $userAgent
		]);
	}

	/**
	 * @Route("/twig", name="homepage.twig")
	 */
	public function twig():Response
	{
		$list = [
			'key0' => 'value0',
			'key1' => 'value1',
			'key2' => 'value2',
		];

		return $this->render('homepage/twig.html.twig', [
			'list' => $list,
			'now' => new \DateTime(),
			'price' => 50990.75
		]);
	}
}








