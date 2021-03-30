<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use App\Entity\Document;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use App\Service\FileUploaderService;

final class DocumentAdmin extends AbstractAdmin
{
    protected $uploader;

    public function __construct($code, $class, $baseControllerName, FileUploaderService $uploader, $dir)
    {
        $this->uploader = $uploader;
        $this->uploader->setUploadDir($dir);
        
        parent::__construct($code, $class, $baseControllerName);
    }

    public function toString($object)
    {
        return $object instanceof Document ? $object->getTitle() : "Fakultas";
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('title')
            ->add('path')
            ->add('isDraft')
            ->add('createdAt')
            ->add('updatedAt')
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('title')
            ->add('path')
            ->add('isDraft')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('title')
            ->add('docFile', FileType::class, [
                'required' => false
            ])
            ->add('isDraft')
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('title')
            ->add('path')
            ->add('isDraft')
            ->add('createdAt')
            ->add('updatedAt')
            ;
    }

    public function preUpdate($doc)
    {
        if (null !== $doc->getDocFile()) {
            $filename = $this->uploader->upload($doc->getDocFile());
            $doc->setPath($filename);
        }
        
    }
}
