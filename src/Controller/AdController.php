<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\AdSearch;
use App\Form\AdType;
use App\Entity\Image;
use App\Form\AdSearchType;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ads_index")
     */
    public function index(AdRepository $repo, Request $request)
    {   
        $search = new AdSearch();

        $form = $this->createForm(AdSearchType::class, $search);
        $form->handleRequest($request);
        
        $ads = $repo->findByQuery($search);
        
        return $this->render('ad/index.html.twig', [
            'ads' => $ads,
            'form' => $form->createView()
        ]);
    }

    /**
     * Create Ad
     * 
     * @Route("/ads/new", name="ads_create")
     * @IsGranted("ROLE_USER")
     */

    public function create(Request $request, ObjectManager $manager)
    {   
       $ad = new Ad(); 
    
       $form = $this->createForm(AdType::class, $ad);

       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()){
            foreach($ad->getImages() as $image) {
                $image->setAd($ad);
                $manager ->persist($image);
            }
            $ad->setAuthor($this->getUser());

            $manager ->persist($ad);
            $manager->flush();

            $this->addFlash(
                'success', 'L\'annonce a bien été enregistrée !' 
            );

            return $this->redirectToRoute('ads_show', [
                'slug' => $ad->getSlug()
            ]);
       }

        return $this->render('ad/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Edit an ad
     * 
     * @Route("/ads/{slug}/edit", name="ads_edit")
     * @Security("is_granted('ROLE_USER') and user === ad.getAuthor()", message="Vous n'êtes pas le propriétaire de cette annonce !")
     */
    public function edit(Request $request, Ad $ad, ObjectManager $manager)
    {   
        $form = $this->createForm(AdType::class, $ad);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            foreach($ad->getImages() as $image) {
                $image->setAd($ad);
                $manager ->persist($image);
            }

            $manager ->persist($ad);
            $manager->flush();

            $this->addFlash(
                'success', 'L\'annonce a bien été modifiée !' 
            );

            return $this->redirectToRoute('ads_show', [
                'slug' => $ad->getSlug()
            ]);
        }

        return $this->render('ad/edit.html.twig', [
            
            'form' => $form->createView(),
            'ad' => $ad
        ]);
    }


    /**
     * Show one ad
     * 
     * @Route("/ads/{slug}", name="ads_show")
     */
    public function show(Ad $ad)
    {   
        return $this->render('ad/show.html.twig', [
            'ad' => $ad,
        ]);
    }

    /**
     * Delete an add
     *
     * @Route("/ads/{slug}/delete", name="ads_delete")
     * @Security("is_granted('ROLE_USER') and user === ad.getAuthor()")
     * 
     * @param Ad $ad
     * @param ObjectManager $manager
     */
    public function delete(Ad $ad, ObjectManager $manager, Request $request)
    {   
        if($this->isCsrfTokenValid('delete' . $ad->getId(), $request->get('_token'))){
            $manager->remove($ad);
            $manager->flush();

            $this->addFlash('success', "L'annonce {$ad->getTitle()} a bien été supprimée !");
        }

        return $this->redirectToRoute("ads_index");
    }
}
