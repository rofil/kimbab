<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Journal;
use App\Entity\Lecturer;
use App\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class JournalAdmin extends AbstractAdmin
{
    use UploaderMethod;

    protected $baseRouteName = 'journal_admin';

    protected $baseRoutePattern = 'journal';

    protected $level = [
        1 => 'Lokal', 2 => 'Nasional', 3 => 'Internasional'
    ];

    protected $classification = [
        1 => 'Penelitian', 2 => 'Pengabdian'
    ];

    public function toString($object)
    {
        return $object instanceof Journal ? $object->getTitle(): "Jurnal";
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('title')
            ->add("year")
            ->add('nameOfJournal')
            ->add('volume')
            ->add('number')
            ->add('url')
            ->add('classification', 'doctrine_orm_choice', [], ChoiceType::class, [
                'choices' => array_flip($this->classification)
            ])
            ->add('abstract')
            ->add('level', 'doctrine_orm_choice', [], ChoiceType::class, [
                'choices' => array_flip($this->level)
            ])
            ->add('issn')

            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('title')
            ->add('uploader', 'string', [
                'admin_code' => 'admin.people'
            ])
            ->add('journalLecturers' )
            ->add("year", 'string', [
                'role' => ['ROLE_ADMIN'],
                'row_align' => 'center'
            ])
            ->add('nameOfJournal')
            ->add('volume', null, ['label' => 'Vol', 'row_align' => 'center'])
            ->add('number', null, ['label' => 'No', 'row_align' => 'center'])
            ->add('url')
            ->add('classification', 'choice', ['choices' => $this->classification])
            ->add('level', 'choice', ['choices' => $this->level])
            ->add('pages', null, ['label' => 'Hal'])
            ->add('issn')
            ->add('document', null, [
                'template' => 'sonata/fields/journal-document.html.twig',
                'label' => 'Doc', 'row_align' => 'center'
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
        if ($this->getSubject()->getId() !== null)
            $isDocumentRequired = false;

        $formMapper
            ->tab("Information")
            ->with("Personel")
                ->add("journalLecturers", CollectionType::class,[
                    'label' => false
                ], [
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position',
                ])
            ->end()
                ->with("Publication", ['class' => 'col-md-7'])
                    ->add('title')

                    ->add('year', null, ['required' => true])
                    ->add('abstract')


                    ->add('classification', ChoiceType::class, [
                        'choices' => [
                            'Penelitian' => 1,
                            'Pengabdian' => 2,
                        ]
                    ])


                    ->add('pages', null, ['required' => true])

                    ->add("documentFile",FileType::class, [
                        'required' => $isDocumentRequired
                    ])
                ->end()
                ->with("Journal Information", ['class' => 'col-md-5'])
                    ->add('nameOfJournal')
                    ->add('volume')
                    ->add('number')
                    ->add('url')
                    ->add('level', ChoiceType::class, [
                        'choices' => array_flip($this->level)
                    ])
                    ->add('issn')
                ->end()

            ->end();

            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->with("Publication", ['class' => 'col-md-7'])
                ->add('title')
                ->add("journalLecturers")
                ->add('year')
                ->add('document', null, [
                    'template' => 'sonata/show/journal-document.html.twig'
                ])
                ->add('classification', 'choice', ['choices' => $this->classification])
                ->add('level', 'choice', ['choices' => $this->level])
                ->add('pages')
                ->add('abstract')
            ->end()
            ->with("Journal", ['class' => 'col-md-5'])
                ->add('nameOfJournal')
                ->add('volume')
                ->add('number')
                ->add('url')
                ->add('issn')
            ->end()

        ;
    }


    public function prePersist($object)
    {
        $object = $this->getJournalObject($object);
        $object->setUploader($this->getLecturer());


        foreach($object->getJournalLecturers() as $jl) {
            $jl->setJournal($object);
        }

        $this->uploadDocument($object);
    }

    public function preUpdate($object)
    {
        $object = $this->getJournalObject($object);

        foreach($object->getJournalLecturers() as $jl) {
            $jl->setJournal($object);
        }

        $this->uploadDocument($object);
    }

    protected function uploadDocument(Journal &$object)
    {
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

    public function getJournalObject($object): Journal
    {
        return $object;
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->join($query->getRootAlias().".year", "y")
            ->orderBy("y.year", "DESC");
        if (in_array('ROLE_LECTURER', $this->getUser()->getRoles())) {
            $query->join($query->getRootAliases()[0]. ".journalLecturers", 'l');
            $query->orWhere($query->expr()->eq($query->getRootAliases()[0].'.uploader', $this->getLecturer()->getId()))
                ->orWhere($query->expr()->eq('l.lecturer', $this->getLecturer()->getId()));
        }

        if (in_array('ROLE_FACULTY', $this->getUser()->getRoles())) {

            $query->join($query->getRootAlias(). ".journalLecturers", 'jl');
            $query->join("jl.lecturer", 'l');
            $query->where($query->expr()->eq("l.unit", $this->getUser()->getUnit()->getId()));
        }


        return $query;

    }
}
