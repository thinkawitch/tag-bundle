<?php

namespace Thinkawitch\TagBundle\Model\Taggable;

use Thinkawitch\TagBundle\Entity\Tag;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

trait TaggableTrait
{
    #[ORM\ManyToMany(targetEntity: Tag::class, cascade: ['persist'])]
    protected Collection $tags;

    public function setTags(Collection $tags): static
    {
        $this->tags = $tags;
        return $this;
    }

    public function addTag(Tag $tag): static
    {
        if (!isset($this->tags)) {
            $this->tags = new ArrayCollection();
        }
        $this->tags->add($tag);
        return $this;
    }

    public function removeTag(Tag $tag): static
    {
        if (!isset($this->tags)) {
            $this->tags = new ArrayCollection();
        }
        $this->tags->removeElement($tag);
        return $this;
    }

    public function getTags(): Collection
    {
        if (!isset($this->tags)) {
            $this->tags = new ArrayCollection();
        }
        return $this->tags;
    }
}