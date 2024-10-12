<?php

declare(strict_types=1);

namespace App\AppBundle\Controller;

use App\AppBundle\Entity\Playlist;
use App\AppBundle\Form\PlaylistType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/playlist')]
class PlaylistController extends AbstractController
{
    private EntityManagerInterface $entity_manager;

    public function __construct(EntityManagerInterface $entity_manager)
    {
        $this->entity_manager = $entity_manager;
    }

    #[Route('/edit/{playlist_id}', name: 'playlist_edit', requirements: ['playlist_id' => '\d+'])]
    public function edit(Request $request, ?int $playlist_id = null): Response
    {
        if (!$playlist_id)
        {
            $playlist = new Playlist('Unnamed');
        }
        else
        {
            $playlist = $this->entity_manager
                ->getRepository(Playlist::class)
                ->find($playlist_id);
        }

        $form = $this->createForm(PlaylistType::class, $playlist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->entity_manager->persist($playlist);
            $this->entity_manager->flush();

            return $this->redirectToRoute('home_page');
        }

        return $this->render(
            '@App/playlist_edit.html.twig', [
                'form' => $form->createView(),
                'playlist' => $playlist
            ]
        );
    }

    #[Route('/delete/{playlist_id}', name: 'playlist_delete', requirements: ['playlist_id' => '\d+'])]
    public function delete(int $playlist_id): Response
    {
        $playlist = $this->entity_manager->getRepository(Playlist::class)->find($playlist_id);

        if ($playlist)
        {
            $this->entity_manager->remove($playlist);
            $this->entity_manager->flush();
        }

        return $this->redirectToRoute('system_user_list');
    }
}