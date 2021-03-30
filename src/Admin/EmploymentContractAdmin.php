<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\EmploymentContract;
use App\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class EmploymentContractAdmin extends AbstractAdmin
{
    public function toString($object)
    {
        return $object instanceof EmploymentContract ? $object->getName() : "Kontrak Kerja";
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('name')
            ->add('unit')
            ->add('partner')
            ->add('contractNumber')
            ->add('contractValue')
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('name')
            ->add('unit')
            ->add('partner')
            ->add('contractNumber')
            ->add('contractValue')
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

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $subject = $this->getSubject();
        $formMapper
            ->add('name')
        ;
        if (in_array('ROLE_UNIT', $this->getUser()->getRoles())){
            if ($this->getUser()->getUnit())
                $subject->setUnit($this->getUser()->getUnit());
        } else {
            $formMapper
                ->add('unit');
        }

        $formMapper
            ->add('year', null, [
                'required' => true
            ])
            ->add('partner')
            ->add('contractNumber')
            ->add('contractValue')
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('name')
            ->add('year')
            ->add('unit')
            ->add('partner')
            ->add('contractNumber')
            ->add('contractValue')
            ->add('createdAt')
            ->add('updatedAt')
            ;
    }

    public function getUser(): User
    {
        return $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
    }

    public function createQuery($context = 'list')
    {
        $query= parent::createQuery($context);

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
