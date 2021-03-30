<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Lecturer;
use App\Repository\LecturerRepository;
use Sonata\AdminBundle\Admin\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;

class PeopleAdmin extends LecturerAdmin
{
    protected $status = [
        2 => 'Dosen/Mitra/Penulis Luar UNMUL',
        3 => 'Mahasiswa/Mitra/Penulis UNMUL',
    ];
    /**
     * Route Based
     * @var string
     */
    protected $baseRouteName = 'people_admin';

    protected $baseRoutePattern = 'people';

    protected function configureFormFields(FormMapper $formMapper): void
    {
        parent::configureFormFields($formMapper);
        $subject = $this->getSubject();
        $subject->setCreator($this->getLecturer());
//        $formMapper->add("creator", null, [], [
//            'admin_code' => 'admin.people'
//        ]);

        $formMapper->remove('filePhoto');
        $formMapper->remove('education');
        $formMapper->remove('nip');
        $formMapper->remove('nidn');
        $formMapper->remove('unit');
    }

    public function getLecturer()
    {
        $repo =  $this->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Lecturer::class);
        return $repo->findOneBy(['nip' => $this->getUser()->getUsername()]);
    }



    public function getContainer()
    {
        return $this->getConfigurationPool()->getContainer();
    }
}
