<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Lecturer;
use App\Entity\Research;
use App\Entity\User;
use App\Service\FileUploaderService;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\Filter\NumberType;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

final class ResearchAdmin extends AbstractAdmin
{

    /**
     * @var FileUploaderService
     */
    private $uploader;

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('title')
            ->add('fundingSource')
            ->add('funding')
            ->add('document')
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
//            ->add('id')
            ->add('title')
            ->add('uploader', null, [
                'admin_code' => 'admin.people'
            ])
            ->add('researchLecturers', null, ['template' => 'sonata/tim-peneliti.html.twig'])
            ->add('fundingSource')
            ->add('funding', NumberType::class, ['template' => 'sonata/fields/money.html.twig'])
            ->add('document', null, ['template' => 'sonata/fields/research-document.html.twig'])
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
        $isFileDocumentRequired = true;

        if ($this->getSubject() !== null && $this->getSubject()->getId() !== null)
            $isFileDocumentRequired = false;

        $formMapper
            ->with("Informasi Penelitian")
            ->add('title')
            ->add('year')
            ->add('fundingSource')
            ->add('funding')
            ->add('fileDocument', FileType::class, [
                'required' => $isFileDocumentRequired
            ])
            ->end()
            ->with("Anggota Peneliti")
            ->add('researchLecturers', CollectionType::class,[
                'label' => false,
            ],[
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position',
//                'admin_code' => "admin.people"
            ])
            ->end()
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('title')
            ->add('fundingSource')
            ->add('funding')
            ->add('document')
            ;
    }

    protected function uploadDocument(Research &$object)
    {
        if (null !== $object->getFileDocument()) {
            $filename = $this->uploader->upload($object->getFileDocument());
            $object->setDocument($filename);
        }
    }

    public function prePersist($object)
    {
        $object->setUploader($this->getLecturer());
        foreach($object->getResearchLecturers() as $rl) {
            $rl->setResearch($object);
        }

        $this->uploadDocument($object);
    }

    public function preUpdate($object)
    {
        foreach($object->getResearchLecturers() as $rl) {
            $rl->setResearch($object);
        }

        $this->uploadDocument($object);
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        $query->join($query->getRootAlias().".year", "y")
            ->orderBy("y.year", "DESC");

        if (in_array('ROLE_LECTURER', $this->getUser()->getRoles())) {
            $query->join($query->getRootAliases()[0]. ".researchLecturers", 'l');
            $query->orWhere('l.lecturer =:lecturer');
            $query->orWhere($query->getRootAliases()[0].'.uploader =:lecturer');
            $query->setParameter("lecturer", $this->getLecturer());
        }

        if (in_array('ROLE_FACULTY', $this->getUser()->getRoles())) {
            $query->join($query->getRootAlias(). ".researchLecturers", 'rl');
            $query->join("rl.lecturer", 'l');
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

    public function setUploader(FileUploaderService $uploader, string  $dir)
    {
        $this->uploader = $uploader;
        $this->uploader->setUploadDir($dir);
    }
}
