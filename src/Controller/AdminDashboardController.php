<?php

namespace App\Controller;

use App\Service\StatsService;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin/", name="admin_dashboard")
     */
    public function index(ObjectManager $manager, StatsService $service)
    {   
        // Using functions coming from App\Service\StatsService
        $users = $service->getUsersCount();
        $ads = $service->getAdsCount();
        $bookings = $service->getBookingsCount();
        $comments = $service->getCommentsCount();

        $bestAds = $service->getsAdsStats('DESC');
        $worstAds = $service->getsAdsStats('ASC');

        return $this->render('admin/dashboard/index.html.twig', [
            'stats' => compact('users', 'ads', 'bookings', 'comments'),
            'bestAds' => $bestAds,
            'worstAds' => $worstAds
        ]);
    }
}
