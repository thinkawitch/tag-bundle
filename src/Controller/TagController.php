<?php

namespace Thinkawitch\TagBundle\Controller;

use Thinkawitch\TagBundle\Entity\Tag;
use Thinkawitch\TagBundle\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/')]
class TagController extends AbstractController
{
    #[Route('/autocomplete', name: 'thinkawitch_tag_autocomplete', methods: ['GET'], format: 'json')]
    public function autocompleteAction(
        Request $request,
        TagRepository $tagRepository,
    ): JsonResponse
    {
        $search = $request->query->get('query');
        $category = $request->query->get('category', 'default');
        $tags = $tagRepository->searchTags($search,  $category);

        $results = [];
        /** @var Tag $tag */
        foreach ($tags as $tag) {
            $results[] = [
                'value' => $tag->getName(),
                'text' => $tag->getName(),
            ];
        }

        return $this->json(['results' => $results]);
    }
}