<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use App\Entity\Post;

final class PostAdmin extends AbstractAdmin
{
    public $supportsPreviewMode = true;
    public function toString($object)
    {
        return $object instanceof Information ? $object->getTitle() : "Post";
    }

    protected function configureFormFields(FormMapper $formMapper) 
    {
        $formMapper
            ->add("title", TextType::class)
            ->add("body", CKEditorType::class)
            ->add("isPublished", CheckboxType::class, [
                'required' => false
            ])
            ->add("postType", ChoiceType::class, [
                'choices' => [
                    "Pengumuman" => 1, 
                    'Berita' => 2,
                ]
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title');    
        $datagridMapper->add('postType');
        $datagridMapper->add('isPublished');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('postType', 'choice', [
                'choices' => [
                    'Pengumuman' => 1, 'Berita' => 2
                ] 
            ])
            ->add('isPublised', 'boolean')
            ->add('updatedAt', null, [
                'label' => 'Tanggal'
            ])
            
        ;
    }
}
