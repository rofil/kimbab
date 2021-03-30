<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\CommunityService;
use App\Entity\Lecturer;
use App\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\Form\Type\CollectionType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

final class CommunityServiceAdmin extends AbstractAdmin
{
    use UploaderMethod;

    protected $duration =[
        1 => '0-6 Bulan', 2 => '>6 Bulan'
    ];

    protected $level = [
        1 => 'Lokal', 2 => 'Nasional', 3 => 'Internasional'
    ];

    public function toString($object)
    {
        return $object instanceof CommunityService ? $object->getTitle() : "Pengabdian Masyarakat";
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('title')
            ->add('duration')
            ->add('level', 'doctrine_orm_choice', [], ChoiceType::class, [
                'choices' => [
                    'Lokal' => 1,
                    'Nasional' => 2,
                    'Internasional' => 3,
                ],
//                'catalogue' => 'App'
            ])
            ->add('fundingSource')
            ->add('funding')
            ->add('numberOfStudents')
            ->add('numberOfAlumni')
            ->add('numberOfStaff')

            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->addIdentifier('title')
            ->add("uploader", 'string', [
                'admin_code' => 'admin.people'
            ])
            ->add('duration', 'choice', [
                'choices' => [
                    1 => '0 - 6 Bulan',
                    2 => '> 6 Bulan',
                ],
            ])
            ->add('level', 'choice', [
                'choices' => [
                    1 => 'Lokal',
                    2 => 'Nasional',
                    3 => 'Internasional',
                ], 'row_align' => 'center'
            ])
            ->add('fundingSource')
            ->add('funding', 'string', [
                'template' => 'sonata/fields/money.html.twig',
                'row_align' => 'right'
            ])
            ->add('numberOfStudents', null, [ 'label' => 'Student', 'row_align' => 'center' ])
            ->add('numberOfAlumni', null, [ 'label' => 'Alumni', 'row_align' => 'center'])
            ->add('numberOfStaff', null, [ 'label' => 'Staff', 'row_align' => 'center' ])
            ->add("document", null, [
                'template' => 'sonata/fields/cs-document.html.twig', 'label' => 'Doc'
            ])
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
        $isDocumentRequired = true;

        if (null !== $this->getSubject()->getId())
            $isDocumentRequired = false;

        $formMapper
            ->with("Umum", ['class' => 'col-md-7'])
                ->add('title', null)
                ->add("year", null, ['label' => 'Tahun', 'required' => true])
                ->add('duration', ChoiceType::class, [
                    'choices' => [
                        '0-6 Bulan' => 1,
                        '> 6 Bulan' => 2,
                    ],
                    'label' => 'duration'
                ])
                ->add('level', ChoiceType::class, [
                    'choices' => [
                        "Lokal" => 1,
                        'Nasional' => 2,
                        'Internasional' => 3
                    ],
                    'label' => 'Level Kegiatan',
                ])
                ->add('fundingSource', null, [
                    'label' => 'Sumber Pendanaan',
                ])
                ->add('funding', NumberType::class, [
                    'label' => 'Total Dana'
                ])
                ->add('numberOfStudents', null, [])
                ->add('numberOfAlumni', null, [])
                ->add('numberOfStaff', null, [])
                ->add('documentFile', FileType::class, [
                    'required' => $isDocumentRequired
                ])
            ->end()

            ->with("Personil", ['class' => 'col-md-5'])
                ->add("communityServiceLecturers", CollectionType::class,[
                    'label' => false,
                ],[
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position',
                ])
            ->end()
            ->with("Mitra", ['class' => 'col-md-5'])
                ->add("communityServicePartners", CollectionType::class,[
                    'label' => false,
                ],[
                    'edit' => 'inline',
//                    'inline' => 'table',
                    'sortable' => 'position',
                ])
            ->end()

            ;
    }

    public function prePersist($object)
    {
        $object = $this->getCommunityServiceObject($object);
        $object->setUploader($this->getLecturer());


        foreach($object->getCommunityServiceLecturers() as $csl) {
            $csl->setCommunityService($object);
        }

        foreach ($object->getCommunityServicePartners() as $partner) {
            $partner->setCommunityService($object);
        }

        $this->uploadDocument($object);
    }

    public function preUpdate($object)
    {
        $object = $this->getCommunityServiceObject($object);

        foreach($object->getCommunityServiceLecturers() as $csl) {
            $csl->setCommunityService($object);
        }

        foreach ($object->getCommunityServicePartners() as $partner) {
            $partner->setCommunityService($object);
        }

        $this->uploadDocument($object);
    }

    protected function uploadDocument(CommunityService &$object)
    {
        if (null !== $object->getDocumentFile()) {
            $filename = $this->getUploader()->upload($object->getDocumentFile());
            $object->setDocument($filename);
        }
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->with("Pengabdian", ['class' => 'col-md-7', 'box_class'   => 'box box-solid box-primary'])
                ->add('title', null, [
                    'headers' => 'width:1200px'
                ])
                ->add("year")
                ->add('duration', 'choice', [
                    'choices' => $this->duration
                ])
                ->add('level', 'choice', [
                    'choices' => $this->level
                ])
                ->add('fundingSource')
                ->add('funding', NumberType::class, ['template' => 'money.html.twig'])
                ->add('numberOfStudents')
                ->add('numberOfAlumni')
                ->add('numberOfStaff')
                ->add('document', null, [
                    'template' => 'sonata/show/community-service-document.html.twig'
                ])

            ->end()
            ->with("lecturer", ['class' => 'col-md-5', 'box_class' =>'box box-solid box-info'])
                ->add("communityServiceLecturers", null, [
                    'template' => 'sonata/show/lecturers.html.twig',
                    'admin_code' => 'admin.people'
                ])
            ->end()
            ->with("Mitra", ['class' => 'col-md-5', 'box_class' =>'box box-solid box-danger'])
                ->add("communityServicePartners", null, [
                    'template' => 'sonata/show/partners.html.twig'
                ])
            ->end()
            ->with("Author", ['class' => 'col-md-5'])
                ->add("uploader", 'string', [
                    'admin_code' => 'admin.people'
                ])
                ->add('createdAt')
                ->add('updatedAt')
            ->end()
            ;
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

    public function getCommunityServiceObject($object): CommunityService
    {
        return $object;
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        $query->join($query->getRootAlias().".year", "y")
            ->orderBy("y.year", "DESC");

        if (in_array('ROLE_LECTURER', $this->getUser()->getRoles())) {
            $query->join($query->getRootAliases()[0]. ".communityServiceLecturers", 'l');
            $query->orWhere('l.lecturer =:lecturer');
            $query->orWhere($query->getRootAliases()[0].'.uploader =:lecturer');
            $query->setParameter("lecturer", $this->getLecturer());
        }

        if (in_array('ROLE_FACULTY', $this->getUser()->getRoles())) {
            $query->join($query->getRootAlias(). ".communityServiceLecturers", 'csl');
            $query->join("csl.lecturer", 'l');
            $query->where($query->expr()->eq("l.unit", $this->getUser()->getUnit()->getId()));
        }

        return $query;

    }
}
