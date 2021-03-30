<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Lecturer;
use App\Entity\User;
use App\Service\FileUploaderService;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class LecturerAdmin extends AbstractAdmin
{
    protected $status = [
        1 => 'Dosen UNMUL',
        2 => 'Dosen/Mitra/Penulis Luar UNMUL',
        3 => 'Mahasiswa/Mitra/Penulis UNMUL',
    ];

    protected $functional = [
        0 => 'Unknown',
        1 => 'Tenaga Pengajar',
        2 => 'Asisten Ahli',
        3 => 'Lektor',
        4 => 'Lektor Kepala',
        5 => 'Guru Besar',
    ];

    public function toString($object) 
    {
        return $object instanceof Lecturer ? $object->getName() : "Dosen";
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('nip')
            ->add('nidn')

            ->add('name')
            ->add('education')
        ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('no', 'batch', [

                'template' => 'sonata/fields/no.html.twig'
            ])
            ->add('nip')
            ->add('nidn')
            ->add('name')
            ->add('affiliation')
            ->add('creator', null, [
                'admin_code' => 'admin.people'
            ])
            ->add('educationLevel', 'virtual_field')

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
        if (null !== $subject)
            $subject->setAffiliation("Universitas Mulawarman");
        $formMapper
            ->with("General", ['class' => 'col-md-9'])
                ->add('nip', null)
                ->add('nidn', null)
                ->add('name', null)
                ->add('status', ChoiceType::class, [
                    'required' => true,
                    'choices' => array_flip($this->status)
                ])
                ->add("email")
                ->add("expertises")
                ->add('unit', null)
                ->add('affiliation', TextType::class)
            ->end()
            ->with('Photo', ['class' => 'col-md-3'])
                ->add('filePhoto', FileType::class, [
                    'help' => 'Foto dalam bentuk JPG/JPEG',
                    'required' => false
                ])
            ->end()
            ->with('Pendidikan & Fungsional', ['class' => 'col-md-3'])
                ->add('education', ChoiceType::class, [
                    'choices' => [ "S-1" => 1, "S-2" => 2, "S-3" => 3 ]
                ])
                ->add('functional', ChoiceType::class, [
                    'choices' => array_flip($this->functional)
                ])
            ->end()
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper

            ->with("Photo", ['class' => 'col-md-4'])
                ->add('photo', null, [
                        'template' => 'sonata/show/image.html.twig',
                        'require' => false,
                    ]
                )
            ->end()
            ->with("Biodata", ['class' => 'col-md-8'])
                ->add('nip')
                ->add('nidn')
                ->add('name')
                ->add('education', null, [
                    'choices' => [
                        1 => 'sd'
                    ]
                ])
            ->add("unit", null, [
                'label' => 'Faculty'
            ])
            ->add("affiliation")

            ->end()
            ;
    }

    public function preUpdate($object)
    {
        if ($object->getFilePhoto() instanceof UploadedFile) {
            $filename = $this->uploader->upload($object->getFilePhoto());

            $object->setPhoto($filename);

        }
    }

    protected $uploader;

    public function setUploader(FileUploaderService $uploader, string  $dir)
    {
        $this->uploader = $uploader;
        $this->uploader->setUploadDir($dir);
    }

    public function getUser():?User
    {
        return $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection->add("my_profile", "profile", [
            "_controller" => $this->baseControllerName."::profile"
        ]);

        $collection->add("my_profile_edit", "profile-edit", [
            "_controller" => $this->baseControllerName."::edit"
        ]);

//        $collection->add('available_schema', '/available-research-schema', [
//            "_controller" => $this->baseControllerName."::researchSchema"
//        ]);

//        $collection->add('add_reviewer_monev', $this->getRouterIdParameter().'/reviewer/{stage}', [
//            "_controller" => $this->baseControllerName."::addReviewerAction"
//        ]);
//
    }
}
