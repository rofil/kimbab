<?php


namespace App\Service;


use App\Entity\Lecturer;
use App\Repository\LecturerRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class LecturerProfile
{
    protected $username;

    protected $repository;

    public function __construct(TokenStorageInterface $tokenStorage, LecturerRepository $repository)
    {
        $this->username = $tokenStorage->getToken()? $tokenStorage->getToken()->getUsername() : null;
        $this->repository = $repository;
    }

    public function getLecturer():?Lecturer
    {
        return $this->repository->findOneBy(['nip' =>$this->username]);
    }
}