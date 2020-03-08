<?php

namespace App\Controller\Admin;

use App\Entity\Discovery;
use App\Form\DiscoveryType;
use App\Repository\DiscoveryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 */
class DiscoveryController extends AbstractController
{
	/**
	 * @Route("/discoveries", name="admin.discovery.index")
	 */
	public function index(DiscoveryRepository $discoveryRepository):Response
	{
		$results = $discoveryRepository->findAll();

		return $this->render('admin/discovery/index.html.twig', [
			'results' => $results
		]);
	}

	/**
	 * @Route("/discoveries/form", name="admin.discovery.form")
	 * @Route("/discoveries/form/update/{id}", name="admin.discovery.form.update")
	 */
	public function form(Request $request, EntityManagerInterface $entityManager, int $id = null, DiscoveryRepository $discoveryRepository):Response
	{
		$type = DiscoveryType::class;
		$model = $id ? $discoveryRepository->find($id) : new Discovery();

		$form = $this->createForm($type, $model);
		$form->handleRequest($request);

		// Si le formulaire est valide
		if($form->isSubmitted() && $form->isValid()) {

			$id ? null : $entityManager->persist($model);
			$entityManager->flush();

			$message = $id ? "La découverte a été modifié" : "La découverte a été ajouté";
			$this->addFlash('notice', $message);

			return $this->redirectToRoute('admin.discovery.index');
		}
		return $this->render('admin/discovery/form.html.twig', [
			'form' => $form->createView()
		]);
	}

	/**
	 * @Route("/discoveries/delete/{id}", name="admin.discovery.delete")
	 */
	public function delete (DiscoveryRepository $discoveryRepository, EntityManagerInterface $entityManager, int $id): Response {

		$entity = $discoveryRepository->find($id);
		$entityManager->remove($entity);
		$entityManager->flush();

		$this->addFlash('notice', 'La découverte a été supprimé');
		return $this->redirectToRoute('admin.discovery.index');
	}
}