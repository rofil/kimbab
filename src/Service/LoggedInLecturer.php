<?php


namespace App\Service;


use App\Entity\Lecturer;
use App\Repository\LecturerRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class LoggedInLecturer
{
    protected $tokenStorage;
    protected $lecturerRepository;

    public function __construct(TokenStorageInterface $tokenStorage, LecturerRepository $lecturerRepository)
    {
        $this->tokenStorage = $tokenStorage;
        $this->lecturerRepository = $lecturerRepository;
    }

    public function getLecturer():?Lecturer
    {
        return $this->lecturerRepository->findOneBy(['nip' => $this->tokenStorage->getToken()->getUsername()]);
    }
}