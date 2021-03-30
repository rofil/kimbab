<?php


namespace App\Controller;


use App\Entity\ConferenceOrganizer;
use App\Entity\Lecturer;
use App\Repository\AdditionalOutputRepository;
use App\Repository\BookRepository;
use App\Repository\CommunityServiceRepository;
use App\Repository\ConferenceRepository;
use App\Repository\EmploymentContractRepository;
use App\Repository\FacultyRepository;
use App\Repository\IntellectualPropertyRepository;
use App\Repository\JournalRepository;
use App\Repository\LecturerRepository;
use App\Repository\ResearchRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FacultyController extends AbstractController
{
    /**
     * @Route("/faculty/{id}")
     */
    public function show(
        $id,
        FacultyRepository $repository,
        JournalRepository $journalRepository,
        ConferenceRepository $conferenceRepository,
        LecturerRepository $lecturerRepository,
        IntellectualPropertyRepository $ipRepository,
        BookRepository $bookRepository,
        CommunityServiceRepository $comRepository
    )
    {

        $faculty = $repository->find($id);
        $ids  = [];
        foreach ($lecturerRepository->getIdsByFaculty($id) as $item)
            $ids[] = $item['id'];

        $journals = $journalRepository->findByLecturers($ids);
        $conferences = $conferenceRepository->findByLecturers($ids);
        $ips = $ipRepository->findByLecturers($ids);
        $books = $bookRepository->findByLecturers($ids);
        $coms = $comRepository->findByLecturers($ids);
        $ids = $lecturerRepository->getIdLecturers($faculty->getId());

        $years = $journalRepository->journalStatByLecturersYears($ids, array_fill(date("Y")-9, 10,0));

        $years2 = $conferenceRepository->statByLecturersPerYears($ids, array_fill(date("Y")-9, 10,0));

        $years = add_merge($years, $years2);

        $years3 = $bookRepository->statByLecturersPerYears($ids, array_fill(date("Y")-9, 10,0));
        $years = add_merge($years,$years3);
        return $this->render('front/faculty/overview.html.twig', [
            'faculty' => $faculty,
            'dosen_count' => $faculty->getLecturers()->count(),
            'journal_count' => $journals->count(),
            'conference_count' => $conferences->count(),
            'ip_count' => $ips->count(),
            'book_count' => $books->count(),
            'com_count' => $coms->count(),
            'org_count' => $faculty->getConferenceOrganizers()->count(),
            'contract_count' => $faculty->getEmploymentContracts()->count(),
            'functional_stat' => $this->getFafung($faculty->getId()),
            'functional_label' => Lecturer::JAFUNG,
            'yearLabel' => array_keys($years),
            'yearValue' => array_values($years)
        ]);
    }

    /**
     * @Route("/faculty/{faculty_id}/dosen")
     * @param $faculty_id
     * @return Response
     */
    public function dosen($faculty_id, FacultyRepository $repository): Response
    {
        $faculty = $repository->find($faculty_id);
        return $this->render('front/faculty/dosen.html.twig', [
            'faculty' => $faculty,
            'lecturers' => $faculty->getLecturers()
        ]);
    }

    /**
     * @Route("/faculty/{id}/community-service", name="faculty.community-service")
     * @param $id
     * @return Response
     */
    public function communityService($id, FacultyRepository $repository, CommunityServiceRepository $csRepo, LecturerRepository $lecturerRepository): Response
    {
        $faculty = $repository->find($id);
        $data = $csRepo->findByLecturers($lecturerRepository->getIdLecturers($id));
        return $this->render('front/faculty/community-service.html.twig', [
            'faculty' => $faculty,
            'data' => $data
        ]);
    }

    /**
     * @Route("/faculty/{id}/research", name="faculty.research")
     * @param $id
     * @return Response
     */
    public function research($id, FacultyRepository $repository, ResearchRepository $researchRepo, LecturerRepository $lecturerRepository): Response
    {
        $faculty = $repository->find($id);
        $data = $researchRepo->findByLecturers($lecturerRepository->getIdLecturers($id));
        return $this->render('front/faculty/research.html.twig', [
            'faculty' => $faculty,
            'data' => $data
        ]);
    }

    /**
     * @Route("/faculty/{id}/intellectual-property-right", name="faculty.ipr")
     * @param $id
     * @return Response
     */
    public function ipr($id, FacultyRepository $repository, IntellectualPropertyRepository $iprRepo, LecturerRepository $lecturerRepository): Response
    {
        $faculty = $repository->find($id);
        $data = $iprRepo->findByLecturers($lecturerRepository->getIdLecturers($id));
        return $this->render('front/faculty/ipr.html.twig', [
            'faculty' => $faculty,
            'data' => $data
        ]);
    }

    /**
     * @Route("/faculty/{id}/additional-output", name="faculty.additional-output")
     * @param $id
     * @return Response
     */
    public function ao($id, FacultyRepository $repository, AdditionalOutputRepository $aoRepo, LecturerRepository $lecturerRepository): Response
    {
        $faculty = $repository->find($id);
        $data = $aoRepo->findByLecturers($lecturerRepository->getIdLecturers($id));
        return $this->render('front/faculty/ao.html.twig', [
            'faculty' => $faculty,
            'data' => $data
        ]);
    }

    /**
     * @Route("/faculty/{faculty_id}/publication")
     * @param $faculty_id
     * @return Response
     */
    public function publication(
        $faculty_id,
        FacultyRepository $repository,
        LecturerRepository $lecturerRepository,
        JournalRepository $journalRepository,
        ConferenceRepository $conferenceRepository,
        BookRepository $bookRepository,
        Request $request): Response
    {
        $type = $request->query->get('type', 'journal');
        $faculty = $repository->find($faculty_id);

        if ($type == "journal")
            $data = $journalRepository->findByLecturers($lecturerRepository->getIdLecturers($faculty_id));

        if ($type == "conference")
            $data = $conferenceRepository->findByLecturers($lecturerRepository->getIdLecturers($faculty_id));

        if ($type == "book")
            $data = $bookRepository->findByLecturers($lecturerRepository->getIdLecturers($faculty_id));

        return $this->render('front/faculty/journal.html.twig', [
            'faculty' => $faculty, 'type' => $type,
            'data' => $data,
        ]);
    }

    protected function getFafung($faculty)
    {

        $j = array_fill(0, 6, 0);
        $repo = $this->getDoctrine()->getRepository(Lecturer::class);
        foreach ($repo->getJafungStat(['faculty' => $faculty]) as $stat) {
            if (key_exists($stat['functional'], $j)) {

                $j[$stat['functional']] += $stat['jum'];
            }
        }
        return $j;
    }
}