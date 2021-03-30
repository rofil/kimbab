<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\IntellectualProperty;
use App\Entity\IntellectualPropertyLecturer;
use App\Entity\Lecturer;
use App\Entity\User;
use App\Form\IntellectualPropertyLecturerType;
use App\Repository\IntellectualPropertyRepository;
use App\Service\LecturerProfile;
use phpDocumentor\Reflection\Types\Null_;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class IntellectualPropertyAdmin extends AbstractAdmin
{
    use UploaderMethod;

    protected $lecturer;

    protected $classification = [
        1 => 'Penelitian',
        2 => 'Pengabdian Masyarakat'
    ];

    protected $status = [
        1 => 'Granted',
        5 => 'Process'
    ];

    public function toString($object)
    {
        return $object instanceof IntellectualProperty? $object->getName() : "HKI";
    }

    public function __construct($code, $class, $baseControllerName, LecturerProfile $lecturer)
    {
        $this->lecturer = $lecturer->getLecturer();
        parent::__construct($code, $class, $baseControllerName);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('year')
            ->add('name')
            ->add('number')
            ->add('status', 'doctrine_orm_choice', [], ChoiceType::class, [
                'choices' => array_flip($this->status)
            ])
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->addIdentifier('name', null, [
                'route' => ['name' =>'show']
            ])
            ->add('year', 'string')
            ->add('number')
            ->add('status', 'choice', [
                'choices' => [
                    1=> "Process",
                    5=> "Granted"
                ],
                'rules' => false
            ])
            ->add('document', null, [
                'template' => 'sonata/fields/ip-document.html.twig',
                'label' => 'Doc'])
            ->add('author', 'string', [
                'admin_code' => 'admin.people'
            ])
//            ->add('classification')
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
        $formMapper
            ->with("Data", ['class' => 'col-md-7'])
            ->add('name', null)
            ->add('number', null, [
                'label' => 'Nomor Registrasi/HKI'
            ])
            ->add('year', null, [
                'required' => true, 'label' => 'Tahun'
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Process' => 5,
                    'Granted' => 1,
                ]
            ])
            ->add('category', null, [
                'required' => true
            ])
            ->add('classification', ChoiceType::class, [
                'choices' => array_flip($this->classification)
            ])

            ;

//        $formMapper->with("Author", ['class' => 'col-md-4']) -> add("lecturers", CollectionType::class)->end();

        $subject = $this->getSubject();
        if ($subject->getId() == null){
            $ip = new IntellectualPropertyLecturer();
            $ip->setLecturer($this->lecturer);
            $subject->addIntellectualPropertyLecturer($ip);
        }

        if ($subject->getId()){
            $formMapper->add('documentFile', FileType::class, [
                'required' => false
            ])
            ;
        } else {
            $formMapper->add('documentFile', FileType::class);
        }
        $formMapper->end();
//        $subject->addLecturer($this->lecturer);
        $formMapper
            ->with("Anggota", ['class' => 'col-md-5'])
//            ->add("intellectualPropertyLecturers", \Symfony\Component\Form\Extension\Core\Type\CollectionType::class, [
//                'allow_add' => true,
//                'allow_delete' => true,
//                'entry_type' => IntellectualPropertyLecturerType::class,

//            ])
                ->add("intellectualPropertyLecturers", CollectionType::class,[
                    'label' => false
                    ],[
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position',
                ])
            ->end();
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->with("HKI", ['class' => 'col-md-7'])
                ->add('name')
                ->add('year', 'string')
                ->add("intellectualPropertyLecturers", null, [
                    'associated_property' => 'lecturer',
                    'route' => ['name' => 'show'],
                    'label' => 'Pengusul'
                ])
                ->add('number')
                ->add('status', 'choice', [
                    'choices' => [
                        5 => 'Process',
                        1 => 'Granted'
                    ]
                ])
                ->add('document', null, [
                    'template' => 'sonata/show/ip-document.html.twig'
                ])
            ->end()
            ->with('Uploader', ['class' => 'col-md-5'])
                ->add("author", 'string', ['admin_code' => 'admin.people'])
                ->add("createdAt")
                ->add("updatedAt")
            ->end()
            ;
    }


    public function prePersist($object)
    {
        $object = $this->getIpObject($object);
        $object->setAuthor($this->lecturer);
        if ($object->getDocumentFile() !== null) {
            $filename = $this->getUploader()->upload($object->getDocumentFile());
            $object->setDocument($filename);
        }
    }

    public function preUpdate($object)
    {
        $object = $this->ip($object);

        foreach($object->getIntellectualPropertyLecturers() as $ipl) {
            $ipl->setIntellectualProperty($object);
        }

        if ($object->getDocumentFile() !== null) {
            $filename = $this->getUploader()->upload($object->getDocumentFile());
            $object->setDocument($filename);
        }
    }

    public function ip($object):IntellectualProperty
    {
        return $object;
    }

    public function setIpRepository(IntellectualPropertyRepository $repo)
    {

    }


    public function getRepository():IntellectualPropertyRepository
    {
        return $this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository($this->getClass());
    }

    protected function getIpObject($object): IntellectualProperty
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
            $query->join($query->getRootAliases()[0]. ".intellectualPropertyLecturers", 'l');
            $query->orWhere($query->expr()->eq($query->getRootAliases()[0].'.author', $this->getLecturer()->getId()))
                ->orWhere($query->expr()->eq('l.lecturer', $this->getLecturer()->getId()));
        }

        if (in_array('ROLE_FACULTY', $this->getUser()->getRoles())) {
            $query->join($query->getRootAlias(). ".intellectualPropertyLecturers", 'ipl');
            $query->join("ipl.lecturer", 'l');
            $query->where($query->expr()->eq("l.unit", $this->getUser()->getUnit()->getId()));
        }

        return $query;

    }

    public function getUser():?User
    {
        return $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
    }

    public function getLecturer(): ?Lecturer
    {
        $repo = $this->getConfigurationPool()->getContainer()->get("doctrine.orm.entity_manager")->getRepository(Lecturer::class);
        return $repo->findOneBy(['nip'=>$this->getUser()->getUsername()]);
    }
}
