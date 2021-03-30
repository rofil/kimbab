<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Book;
use App\Entity\BookLecturer;
use App\Entity\Lecturer;
use App\Entity\User;
use App\Service\FileUploaderService;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class BookAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'admin_vendor_bundlename_adminclassname';

    protected $baseRoutePattern = 'unique-route-pattern';

    protected $classification = [
        Book::CLASSIFICATION_RESEARCH => 'Penelitian',
        Book::CLASSIFICATION_COMMUNITY_SERVICE => 'Pengabdian',
    ];

    public function toString($object)
    {
        return $object instanceof Book ? $object->getTitle() : "Buku";
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('year')
            ->add('title')
            ->add('numberOfPages')
            ->add('publisher')
            ->add('isbn')
            ->add('edition')
            ->add('classification', 'doctrine_orm_choice', [], ChoiceType::class, [
                'choices' => array_flip($this->classification)
            ])
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('title', null, [
                'header_style' => 'width:300px'
            ])
            ->add("year", 'string')
            ->add('numberOfPages', null, [
                'label' => 'Hal'
            ])
            ->add('publisher')
            ->add('isbn')
            ->add('edition')
            ->add('document', null, [
                'template' => 'sonata/fields/book-document.html.twig',
                'label' => 'doc'
            ])
            ->add('classification', 'choice', [
                'choices' => $this->classification
            ])
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
        $isDocumentRequired = true;
        $subject = $this->getSubject();
        if ($subject->getId() !== null) {
            $isDocumentRequired = false;
        }
        if ($subject->getId() === null){
            $subject->setUploader($this->getLecturer());
            $bookLecturer = new BookLecturer();
            $bookLecturer->setLecturer($this->getLecturer());
            $subject->addBookLecturer($bookLecturer);
        }

        $formMapper
            ->with("Book Information", ['class' => 'col-md-7'])
                ->add('title', null, ['label' => 'Judul'])
                ->add("year", null, [
                    'required' => true, 'label' => 'Tahun'
                ])
                ->add("category", null, [
                    'required' => true, 'label' => 'Jenis Buku'
                ])
                ->add('numberOfPages', null, ['required' => true, 'label' => 'Jumlah Halaman'])
                ->add('publisher', null, ['label' => 'Penerbit'])
                ->add('isbn')
                ->add('edition')
                ->add('classification', \Symfony\Component\Form\Extension\Core\Type\ChoiceType::class, [
                    'choices' => array_flip($this->classification)
                ])
            ->end()

            ->with("Pengarang", ['class' => "col-md-5"])
                ->add("bookLecturers", CollectionType::class,[
                    'label' => false,
                ],[
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position',
                ])
            ->end()

            ->with("document", ['class' => "col-md-5"])
                ->add("documentFile", FileType::class,[
                    'required' => $isDocumentRequired
                ])
            ->end()
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->tab("Book Information")
                ->with("Book Description")
                    ->add('title')
                    ->add("year", null, [
//                        'route'=>'/'
                    ])
                    ->add("bookLecturers", 'sonata_type_collection', array(
                        'associated_property' => 'lecturer',
                        'route' => array(
                            'name' => 'show'
                        ),
                        'admin_code' => 'admin.book_lecturer',
                    ))
                    ->add('numberOfPages')
                    ->add('publisher')
                    ->add('isbn')
                    ->add('edition')
                    ->add('document', [], [
                        'template' => 'sonata/show/book-document.html.twig'
                    ])
                    ->add('classification', 'choice', [
                        'choices' => $this->classification
                    ])
                ->end()
            ->end()
            ->tab("Record Information")
                ->add("uploader", 'string', [
                    'admin_code' => 'admin.people'
                ])
                ->add('createdAt')
                ->add('updatedAt')

            ->end()
            ;
    }

    public function preUpdate($object)
    {
        $object = $this->getBookObject($object);

        foreach($object->getBookLecturers() as $lecturer) {
            $lecturer->setBook($object);
        }

        if (null !== $object->getDocumentFile()) {
            $this->upload($object, $object->getDocumentFile());
        }
    }

    public function prePersist($object)
    {
        $object = $this->getBookObject($object);
        $object->setUploader($this->getLecturer());
        foreach($object->getBookLecturers() as $lecturer) {
            $lecturer->setBook($object);
        }

        if (null !== $object->getDocumentFile()) {
            $this->upload($object, $object->getDocumentFile());
        }
    }

    protected function upload(&$object, UploadedFile $file=null)
    {
        if (null !== $file) {
            $filename = $this->getUploader()->upload($object->getDocumentFile());
            $object->setDocument($filename);
        }
    }

    public function getBookObject(Book $book):Book
    {
        return $book;
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

    protected $uploader;

    /**
     * @return mixed
     */
    public function getUploader():FileUploaderService
    {
        return $this->uploader;
    }

    /**
     * @param mixed $uploader
     */
    public function setUploader(FileUploaderService $uploader, $dir): void
    {
        $this->uploader = $uploader;
        $this->uploader->setUploadDir($dir);

    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->join($query->getRootAlias().".year", "y")
            ->orderBy("y.year", "DESC");

        if (in_array('ROLE_LECTURER', $this->getUser()->getRoles())) {
            $query->join($query->getRootAliases()[0]. ".bookLecturers", 'l');
            $query->orWhere($query->expr()->eq($query->getRootAliases()[0].'.uploader', $this->getLecturer()->getId()))
                ->orWhere($query->expr()->eq('l.lecturer', $this->getLecturer()->getId()));
        }

        if (in_array('ROLE_FACULTY', $this->getUser()->getRoles())) {
            $query->join($query->getRootAlias(). ".bookLecturers", 'bl');
            $query->join("bl.lecturer", 'l');
            $query->where($query->expr()->eq("l.unit", $this->getUser()->getUnit()->getId()));

        }

        return $query;
    }
}
