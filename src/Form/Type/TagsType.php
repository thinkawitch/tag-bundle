<?php

namespace Thinkawitch\TagBundle\Form\Type;

use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Thinkawitch\TagBundle\Form\DataTransformer\TagsTransformer;

class TagsType extends AbstractType
{
    public function __construct(
        private readonly ObjectManager $manager,
        private readonly UrlGeneratorInterface $urlGenerator,
    )
    {
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars = array_merge($view->vars, $options);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $autocompleteUrl = $this->urlGenerator->generate('thinkawitch_tag_autocomplete', [
            'category' => $options['thinkawitch_tag_category'],
        ]);
        $builder
            ->addModelTransformer(new CollectionToArrayTransformer(), true)
            ->addModelTransformer(new TagsTransformer($this->manager, $options), true)
            ->setAttribute('autocomplete_url', $autocompleteUrl)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'required' => false,
            'autocomplete' => true,
            'tom_select_options' => [
                'create' => true,
                'createOnBlur' => true,
                'delimiter' => ',',
            ],
            'min_characters' => 2,
            'thinkawitch_tag_persist_new' => true,
            'thinkawitch_tag_category' => 'default',
        ]);
    }

    public function getParent(): string
    {
        return TextType::class;
    }
}