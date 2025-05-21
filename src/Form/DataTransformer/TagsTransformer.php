<?php

namespace Thinkawitch\TagBundle\Form\DataTransformer;

use Thinkawitch\TagBundle\Entity\Tag;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;

class TagsTransformer implements DataTransformerInterface
{
    public function __construct(
        private readonly ObjectManager $manager,
        private readonly array $options
    )
    {
    }

    public function transform($value): string
    {
        return implode(',', $value);
    }

    public function reverseTransform($value): array
    {
        $names = array_unique(array_filter(array_map('trim', explode(',', $value))));
        $tags = $this->manager->getRepository(Tag::class)->findBy([
            'name' => $names
        ]);

        if ($this->options['thinkawitch_tag_persist_new']) {
            $newNames = array_diff($names, $tags);
            foreach ($newNames as $name) {
                $tag = new Tag();
                $tag->setName($name);
                $tag->setCategory($this->options['thinkawitch_tag_category']);
                $tags[] = $tag;
            }
        }

        return $tags;
    }
}