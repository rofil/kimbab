<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Conference;
use App\Entity\ConferenceLecturer;
use App\Entity\Lecturer;
use App\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class AppConferenceAdmin extends AbstractAdmin
{
    use UploaderMethod;

    protected $baseRouteName = 'master_conference_admin';

    protected $baseRoutePattern = 'master-conference';

    protected $participantType = [
        1 => 'Pemakalah',
        2 => 'Keynote Speaker',
        3 => 'Peserta'
    ];

    protected $level = [
        1 => 'Lokal',
        2 => 'Nasional',
        3 => 'Internasional'
    ];

    public function toString($object)
    {
        return $object instanceof Conference ? $this->getConferenceObject($object)->getTitle(): "Konferensi";
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('title')
            ->add('nameOfConference')
            ->add('typeOfParticipation', 'doctrine_orm_choice', [], ChoiceType::class, [
                'choices' => array_flip($this->participantType)
            ])
            ->add('conferenceDate')
            ->add('place')
            ->add('level', 'doctrine_orm_choice', [], ChoiceType::class, [
                'choices' => array_flip($this->level)
            ])
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('title', 'string', ['template' => 'money.html.twig'])
            ->add("year")
            ->add('uploader', 'string', [
                'admin_code' => 'admin.people'
            ])
            ->add('conferenceLecturers')
            ->add('nameOfConference')
            ->add('typeOfParticipation', 'choice', [
                'choices' => $this->participantType
            ])
            ->add('conferenceDate')
            ->add('place')
            ->add('classification', 'choice', [
                'choices' => [
                    1 => 'Penelitian',
                    2 => 'Pengabdian Masyarakat',
                ]
            ])
            ->add('level', 'choice', [
                'choices' => $this->level
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
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $isDocumentRequired = true;
        $subject = $this->getSubject();
        if (null !== $subject->getId())
            $isDocumentRequired = false;

        if (null === $subject->getId()) {
            $confLec = new ConferenceLecturer();
            $confLec->setLecturer($this->getLecturer());
            $subject->addConferenceLecturer($confLec);
        }

        $formMapper
            ->with("Konferensi", ['class' => 'col-md-7'])
                ->add('title')
                ->add("year", null, [
                    'required' => true
                ])
                ->add('nameOfConference')
                ->add('typeOfParticipation', ChoiceType::class, [
                    'choices' => array_flip($this->participantType),
                    'label' => 'Jenis Partisipasi'
                ])
                ->add('conferenceDate', DateType::class, [
                    'widget' => 'single_text',
                    'format' => DateType::HTML5_FORMAT
                ])
                ->add('place')
                ->add('level', ChoiceType::class, [
                    'choices' => [
                        'Lokal' => 1,
                        'Nasional' => 2,
                        'Internasional' => 3,
                    ]
                ])
                ->add("classification",ChoiceType::class, [
                    'choices' => [
                        'Penelitian' => 1, 'Pengabdian' => 2
                    ]
                ])
                ->add("documentFile", FileType::class, [
                    'required' => $isDocumentRequired
                ])
            ->end()
            ->with("Personel Dosen", ['class' => 'col-md-5'])
                ->add('conferenceLecturers', CollectionType::class, [
                    'label' => false,
                    'required' => true
                ], [
                    'edit' => 'inline',
                    'inline' => 'table',
                ])
            ->end()
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->with("Information", ['class' => 'col-md-7'])
                ->add('title')

                ->add("year", 'string')
                ->add("conferenceLecturers")
                ->add('nameOfConference')
                ->add('typeOfParticipation', 'choice', ['choices' => $this->participantType])
                ->add('conferenceDate')
                ->add('place')
                ->add('level', 'choice', [
                    'choices' => $this->level
                ])
                ->add('classification', 'choice', [
                    'choices' => [
                        1 => 'Penelitian', 2=> 'Pengabdian'
                    ]
                ])
                ->add("document", null, [
                    'template' => 'sonata/show/conference-document.html.twig'
                ])

            ->end()
            ->with('Author', ['class' => 'col-md-5'])
                ->add("uploader", null, [
                    'admin_code' => 'admin.people'
                ])
                ->add('createdAt')
                ->add('updatedAt')
            ->end()
//            ->add('conferenceLecturers')
            ;
    }

    public function prePersist($object)
    {
        $object = $this->getConferenceObject($object);
        $object->setUploader($this->getLecturer());


        $object = $this->getConferenceObject($object);
        foreach($object->getConferenceLecturers() as $csl) {
            $csl->setConference($object);
        }

        if (null !== $object->getDocumentFile()) {
            $filename = $this->getUploader()->upload($object->getDocumentFile());
            $object->setDocument($filename);
        }
    }

    public function preUpdate($object)
    {
        $object = $this->getConferenceObject($object);
        foreach($object->getConferenceLecturers() as $csl) {
            $csl->setConference($object);
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

    public function getConferenceObject($object): Conference
    {
        return $object;
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->join($query->getRootAlias().".year", "y")
            ->orderBy("y.year", "DESC");

        $roles = $this->getUser()->getRoles();

        if (in_array('ROLE_LECTURER', $roles)) {
            $query->join($query->getRootAliases()[0]. ".conferenceLecturers", 'cl');
            $query->orWhere($query->expr()->eq($query->getRootAliases()[0].'.uploader', $this->getLecturer()->getId()))
                ->orWhere($query->expr()->eq('cl.lecturer', $this->getLecturer()->getId()));
        }

        if (in_array('ROLE_FACULTY', $this->getUser()->getRoles())) {
            $query->join($query->getRootAlias(). ".conferenceLecturers", 'cl');
            $query->join("cl.lecturer", 'l');
            $query->where($query->expr()->eq("l.unit", $this->getUser()->getUnit()->getId()));
        }

        return $query;

    }
}
