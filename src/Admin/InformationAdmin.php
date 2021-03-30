<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use App\Entity\Information;

final class InformationAdmin extends AbstractAdmin
{
    public function toString($object)
    {
        return $object instanceof Information ? $object->getTitle() : "Halaman Informasi";
    }

    protected function configureFormFields(FormMapper $formMapper) 
    {
        $formMapper->add("title", TextType::class);    
        $formMapper->add("body", CKEditorType::class);
        $formMapper->add("isPublished", CheckboxType::class, [
            'required' => false
        ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title');    
        $datagridMapper->add('isPublished');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('isPublised', 'choice', [
                'editable' => true,
                'label' => 'Terbit?',
                'choices' => array_flip([1 =>"Terbit", 0=>"Draft"])
            ])
            ->add('updatedAt')
        ;
    }
}
