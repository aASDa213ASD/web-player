<?php

declare(strict_types=1);

namespace App\AppBundle\Controller;

use App\AppBundle\Entity\Playlist;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    private EntityManagerInterface $entity_manager;

    public function __construct(EntityManagerInterface $entity_manager)
    {
        $this->entity_manager = $entity_manager;
    }

    #[Route('/', name: 'home_page')]
    public function home()
    {
        $playlists = $this->entity_manager->getRepository(Playlist::class)->findAll();

        return $this->render(
            '@App/home.html.twig', [
                'playlists' => $playlists
            ]
        );
    }

    #[Route('playlists/', name: 'playlists')]
    public function playlists()
    {
        return $this->render('@App/playlists.html.twig');
    }
}