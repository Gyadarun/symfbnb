<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Repository\AdRepository;
use App\Service\PaginationService;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAdController extends AbstractController
{
    /**
     * @Route("/admin/ads/{page}", name="admin_ads_index", requirements={"page": "\d+"})
     */
    public function index($page = 1, PaginationService $pagination)
    {   
        // Pagination
        $pagination->setEntityClass(Ad::class)
                   ->setcurrentPage($page);

        return $this->render('admin/ad/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * Edit an ad from admin
     *
     * @Route("/admin/ads/{id}/edit", name="admin_ads_edit")
     * @param Ad $ad
     * @return Response
     */
    public function edit(Ad $ad, ObjectManager $manager, Request $request)
    {
        $form =  $this->createForm(AdType::class, $ad);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($ad);
            $manager->flush();

            $this->addFlash('success', 'Annonce modifiée avec succès');
        }

        return $this->render('admin/ad/edit.html.twig', [
            'ad' => $ad,
            'form' => $form->createView()
        ]);

    }

    /**
     * Delete an ad from admin
     * 
     * @Route("/admin/ads/{id}/delete", name="admin_ads_delete")
     *
     * @param Ad $ad
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Ad $ad, ObjectManager $manager, Request $request)
    {   
        if(count($ad->getBookings()) > 0) {
            $this->addFlash(
                'warning',
                "L'annonce {$ad->getTitle()} possède des réservations, vous ne pouvez pas la supprimer"
            );
        } else {
            if($this->isCsrfTokenValid('delete' . $ad->getId(), $request->get('_token'))) {
                $manager->remove($ad);
                $manager->flush();
    
                $this->addFlash(
                'success',
                "L'annonce {$ad->getTitle()} a bien été supprimée"
            ); 
            }
            
        }
    
        return $this->redirectToRoute('admin_ads_index');
    }
}
