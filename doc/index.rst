Installation
------------

Install bundle with composer

.. code-block:: terminal

    $ composer require thinkawitch/tag-bundle

Register the bundle

.. code-block:: diff

    // config/bundles.php
    return [
      ...
  +   Thinkawitch\TagBundle\ThinkawitchTagBundle::class => ['all' => true],
    ];

Add routes file ``thinkawitch_tag.yaml``

.. code-block:: yaml

  # config/routes/thinkawitch_tag.yaml
  thinkawitch_tag:
    resource: '@ThinkawitchTagBundle/config/routes.yaml'
    prefix: /thinkawitch-tag


Update database

.. code-block:: terminal

    $ php bin/console doctrine:schema:update

Usage
-----

Add ``TaggableTrait`` to entity

.. code-block:: diff

  namespace App\Entity;
  +  use Thinkawitch\TagBundle\Model\Taggable\TaggableTrait;

  class UserFile {
  +  use TaggableTrait;
  }

Add ``TagsType`` field to form

.. code-block:: diff

  namespace App\Form;
  +  use Thinkawitch\TagBundle\Form\Type\TagsType;

  class UserFileType extends AbstractType
  {
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
  +   $builder->add('tags', TagsType::class, [
  +     'thinkawitch_tag_category' => 'user_file', // "default" if not set
  +   ])

