<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Entity\Image;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ads_index")
     */
    public function index(AdRepository $repo)
    {   
        $ads = $repo->findAll();

        return $this->render('ad/index.html.twig', [
            'ads' => $ads,
        ]);
    }

    /**
     * Create Ad
     * 
     * @Route("/ads/new", name="ads_create")
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


}
