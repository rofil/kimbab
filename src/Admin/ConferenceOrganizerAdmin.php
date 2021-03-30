<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\ConferenceOrganizer;
use App\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

final class ConferenceOrganizerAdmin extends AbstractAdmin
{
    protected $level = [
        1 => 'Lokal',
        2 => 'Nasional',
        3 => 'Internasional'
    ];

    public function toString($object)
    {
        return $object instanceof ConferenceOrganizer ? $object->getName() : "Forum";
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('name')
            ->add('partner')
            ->add('level', 'doctrine_orm_choice', [], ChoiceType::class, [
                'choices' => array_flip($this->level)
            ])
            ->add('place')
            ->add('heldOn')

            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('name')
            ->add("year", 'string')
            ->add("unit", 'string')
            ->add('partner')
            ->add('level', 'choice', ['choices' => $this->level])
            ->add('place')
            ->add('heldOn')
            ->add('_action', null, [
                'header_style' => 'width:120px',
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

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $subject = $this->getSubject();
        $formMapper
            ->add('name')
            ->add("year", null, ['required' => true])
        ;
        if (in_array('ROLE_UNIT', $this->getUser()->getRoles())) {
            $subject->setUnit($this->getUser()->getUnit());

        } else {
            $formMapper->add("unit");
        }
        $formMapper
            ->add('partner')
            ->add('level', ChoiceType::class, [
                'choices' => array_flip($this->level)
            ])
            ->add('place')
            ->add('heldOn')
            ;


    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('name')
            ->add("year", 'string')
            ->add("unit", 'string')
            ->add('partner')
            ->add('level', 'choice', [
                'choices' => $this->level
            ])
            ->add('place')
            ->add('heldOn')
            ->add('createdAt')
            ->add('updatedAt')
            ;
    }

    public function getUser():?User
    {
        return $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->join($query->getRootAlias().".year", "y")
            ->orderBy("y.year", "DESC");

        if (in_array('ROLE_UNIT', $this->getUser()->getRoles()) || in_array('ROLE_FACULTY', $this->getUser()->getRoles())) {
            $query->andWhere(
                $query->expr()->eq($query->getRootAlias().'.unit', $this->getUser()->getUnit()->getId())
            );
        }
        return $query;
    }
}
