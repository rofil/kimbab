<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\AdminType;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use App\Entity\Information;

final class FacultyAdmin extends AbstractAdmin
{
    protected $accessMapping = [
        'autocomplete' => 'AUTOCOMPLETE',
    ];

    public function toString($object)
    {
        return $object instanceof Information ? $object->getTitle() : "Fakultas";
    }

    protected function configureFormFields(FormMapper $formMapper) 
    {
        $formMapper
            ->with("Unit", ['class' => 'col-md-8'])
                ->add("name", TextType::class)
                ->add("abbreviation", TextType::class)
                ->add("unitType", ChoiceType::class, [
                    "choices" => [
                        'Fakultas' => 1,
                        'Lembaga' => 3,
                    ]
                ])
            ->end()
        ;
//        $formMapper
//            ->with('Account', ['class' => 'col-md-4'])
//                ->add("accounts", \Symfony\Component\Form\Extension\Core\Type\CollectionType::class, [
////                    'label' => false
//                ], [
//                    'edit' => 'inline',
//                    'inline' => 'table',
//                    'sortable' => 'position',
//                ])
//            ->end()
//        ;
        
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name');    
        $datagridMapper->add('abbreviation');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('abbreviation')
            ->add('_action', null, [
                'header_style' => 'width:140px',
                'template' => 'sonata/action/list__action.html.twig',
                'actions' => [
                    'show' => [
                        'template' => 'sonata/action/list__action_show.html.twig',
                    ],
                    'edit' => [
                        'template' => 'sonata/action/list__action_edit.html.twig',
                    ],
                    'delete' => [
                        'template' => 'sonata/action/list__action_delete.html.twig',
                    ],
                ],
            ])
        ;
    }
}
