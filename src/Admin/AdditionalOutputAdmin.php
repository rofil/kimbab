<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\AdditionalOutput;
use App\Entity\AdditionalOutputLecturer;
use App\Entity\Lecturer;
use App\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

final class AdditionalOutputAdmin extends AbstractAdmin
{
    use UploaderMethod;

    public function toString($object)
    {
        return $object instanceof AdditionalOutput ? $object->getTitle() : "Luaran Lainnya";
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('title')
            ->add("year")
            ->add("category")
            ->add('description')
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('title')
            ->add("uploader", null, [
                'admin_code' => 'admin.people'
            ])
            ->add("year", 'string')
            ->add("category", 'string')

            ->add('document', null, [
                'template' =>'sonata/fields/additional-output-document.html.twig',
                'label' => 'Doc'
            ])
            ->add('description')
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
        $isDocumentRequired= true;
        if (null !== $subject->getDocument())
            $isDocumentRequired = false;

        if (null == $subject->getId()) {
            $lec = new AdditionalOutputLecturer();
            $lec->setLecturer($this->getLecturer());
            $subject->addAdditionalOutputLecturer($lec);
        }

        $formMapper
            ->with("Luaran Tambahan", ['class' => 'col-md-7'])
                ->add('title')
                ->add("category", null, [
                    'required' => true
                ])
                ->add("year", null, [
                    'required' => true
                ])
                ->add('description')
                ->add('documentFile', FileType::class, ['required' => $isDocumentRequired])
            ->end()
            ->with("Personel", ['class' => 'col-md-5'])
                ->add("additionalOutputLecturers", CollectionType::class, [
                    'label'=>false,
                    
                ], [
                    'edit' => 'inline',
                    'inline' =>'table'
                ])
            ->end()
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->with("Information", ['class' =>'col-md-7'])
                ->add('title')
                ->add("additionalOutputLecturers")
                ->add("year")
                ->add("category")
                ->add('description')
                ->add('document', null, [
                    'template' => 'sonata/show/additional-output-document.html.twig'
                ])
            ->end()
            ->with("Uploader", ['class' => 'col-md-5'])
                ->add("uploader", 'string', [
                    'admin_code' => 'admin.people'
                ])
                ->add('createdAt')
                ->add('updatedAt')
            ->end()
            ;
    }

    public function prePersist($object)
    {
        $object = $this->getAdditionalOutputObject($object);
        $object->setCreatedAt(new \DateTime());
        $object->setUploader($this->getLecturer());

        $object = $this->getAdditionalOutputObject($object);
        foreach($object->getAdditionalOutputLecturers() as $csl) {
            $csl->setAdditionalOutput($object);
        }

        if (null !== $object->getDocumentFile()) {
            $filename = $this->getUploader()->upload($object->getDocumentFile());
            $object->setDocument($filename);
        }
    }

    public function preUpdate($object)
    {
        $object = $this->getAdditionalOutputObject($object);
        $object->setUpdatedAt(new \DateTime());
        foreach($object->getAdditionalOutputLecturers() as $csl) {
            $csl->setAdditionalOutput($object);
        }

        if (null !== $object->getDocumentFile()) {
            $filename = $this->getUploader()->upload($object->getDocumentFile());
            $object->setDocument($filename);
        }

    }
    public function getLecturer(): ?Lecturer
    {
        $repo = $this->getConfigurationPool()->getContainer()->get("doctrine.orm.entity_manager")->getRepository(Lecturer::class);
        return $repo->findOneBy(['nip'=>$this->getUser()->getUsername()]);
    }

    public function getUser():?User
    {
        return $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
    }

    public function getAdditionalOutputObject($object): AdditionalOutput
    {
        return $object;
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->join($query->getRootAlias().".year", "y")
            ->orderBy("y.year", "DESC");

        if (in_array('ROLE_LECTURER', $this->getUser()->getRoles())) {
            $query->join($query->getRootAliases()[0]. ".additionalOutputLecturers", 'l');
            $query->orWhere('l.lecturer =:lecturer');
            $query->orWhere($query->getRootAliases()[0].'.uploader =:lecturer');
            $query->setParameter("lecturer", $this->getLecturer());
        }


        if (in_array('ROLE_FACULTY', $this->getUser()->getRoles())) {
            $query->join($query->getRootAlias(). ".additionalOutputLecturers", 'aol');
            $query->join("aol.lecturer", 'l');
            $query->where($query->expr()->eq("l.unit", $this->getUser()->getUnit()->getId()));
        }
        return $query;

    }
}
