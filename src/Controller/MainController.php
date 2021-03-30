<?php

namespace App\Controller;

use App\Entity\AdditionalOutput;
use App\Entity\Book;
use App\Entity\BookLecturer;
use App\Entity\CommunityService;
use App\Entity\Conference;
use App\Entity\ConferenceLecturer;
use App\Entity\IntellectualProperty;
use App\Entity\IntellectualPropertyLecturer;
use App\Entity\Journal;
use App\Entity\JournalLecturer;
use App\Entity\Lecturer;
use App\Entity\Research;
use App\Entity\Unit;
use App\Entity\Year;
use App\Repository\BookRepository;
use App\Repository\ConferenceRepository;
use App\Repository\JournalRepository;
use App\Repository\LecturerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    protected $jafung = ['Unkown', 'Tenaga Pengajar', 'Asisten Ahli', 'Lektor', 'Lektor Kepala', 'Guru Besar'];
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        return $this->render('front-page/front-page.html.twig', [
            'faculties' => json_encode($this->getFaculties()),
            'journal' => json_encode($this->getJournalFaculties()),
            'year' => json_encode(array_keys($this->getYearPub())),
            'year_pub' => json_encode(array_values($this->getYearPub())),
            'intellectual_properties' => json_encode(array_values($this->getIPFaculties())),
            'books' => json_encode(array_values($this->getBooks())),
            'jafung_list' => json_encode($this->jafung),
            'jafung_stat' => json_encode($this->jafung()),

        ]);
    }

    /**
     * Jumlah Publikasi
     * @return Response
     */
    public function sumOfPublication()
    {
        $nConferences = $this->getDoctrine()->getRepository(Conference::class)->getCount();
        $nJournals = $this->getDoctrine()->getRepository(Journal::class)->getCount();
        return new Response($nConferences + $nJournals);
    }

    /**
     * Jumlah Pengabdian Masyarkat
     * @return Response
     */
    public function sumOfCommunityService()
    {

        $ncs = $this->getDoctrine()->getRepository(CommunityService::class)->getCount();
        return new Response($ncs);
    }


    public function sumOfIP()
    {
        $ncs = $this->getDoctrine()->getRepository(IntellectualProperty::class)->getCount();
        return new Response($ncs);
    }

    public function sumOfResearcher()
    {
        $ncs = $this->getDoctrine()->getRepository(Lecturer::class)->getCount();
        return new Response($ncs);
    }

    public function getFaculties(): array
    {
        $units = $this->getDoctrine()->getRepository(Unit::class)->findAllFaculties();
        
        $faculties = [];
        foreach ($units as $unit) {
            $faculties[] = $unit->getAbbreviation();
        }
        return $faculties;
    }

    /**
     * @Route("/ds")
     */
    public function getJournalFaculties(): array
    {
        $faculties = [];
        $units = $this->getDoctrine()->getRepository(Unit::class)->findAll();
        $penulisJournal = $this->getDoctrine()->getRepository(JournalLecturer::class)->findAll();
        $penulisConference = $this->getDoctrine()->getRepository(ConferenceLecturer::class)->findAll();
        foreach ($units as $unit) {
            $faculties[$unit->getId()] = new ArrayCollection();
        }

        foreach ($penulisJournal as $penulis) {
//            echo sprintf("<li>%s</li>", $penulis);
            if ($penulis->getLecturer()->getUnit() !== null) {
                if (!$faculties[$penulis->getLecturer()->getUnit()->getId()]->contains($penulis->getJournal())) {
                    $faculties[$penulis->getLecturer()->getUnit()->getId()]->add($penulis->getJournal());
                }
            }
        }

        foreach ($penulisConference as $penulis) {
            if ($penulis->getLecturer()->getUnit() !== null) {
                if (!$faculties[$penulis->getLecturer()->getUnit()->getId()]->contains($penulis->getConference())) {
                    $faculties[$penulis->getLecturer()->getUnit()->getId()]->add($penulis->getConference());
                }
            }
        }

        $f = [];
        foreach ($faculties as $id=>$v) {
            $f[] = $v->count();
        }
        return $f;
    }

    /**
     * @Route("/year")
     */
    public function getYearPub()
    {
        $qb = $this->getDoctrine()->getRepository(Year::class)
            ->createQueryBuilder("y")
            ->leftJoin("y.journals", "j")
            ->orderBy("y.year", "DESC")

        ;

//        $qb->setMaxResults(10)->setFirstResult(0);
        $years = $qb->getQuery()->getResult();

        $data = [];
        foreach ($years as $year) {
            $data[$year->getYear()] =
                $year->getJournals()->count() + $year->getConferences()->count();
        }
        ksort($data);
        return $data;
    }


    /**
     * @Route("/ip")
     */
    public function getIPFaculties(): array
    {
        $faculties = [];
        $units = $this->getDoctrine()->getRepository(Unit::class)->findAll();

        $inventors = $this->getDoctrine()->getRepository(IntellectualPropertyLecturer::class)->findAll();
        foreach ($units as $unit) {
            $faculties[$unit->getId()] = new ArrayCollection();
        }

        foreach ($inventors as $inventor) {
//            echo sprintf("<li>%s</li>", $inventor);
            if ($inventor->getLecturer()->getUnit() !== null) {
                if (!$faculties[$inventor->getLecturer()->getUnit()->getId()]->contains($inventor->getIntellectualProperty())) {
                    $faculties[$inventor->getLecturer()->getUnit()->getId()]->add($inventor->getIntellectualProperty());
                }
            }
        }

        $f = [];
        foreach ($faculties as $id=>$v) {
            $f[] = $v->count();
        }

        return $f;
    }

    public function getBooks(): array
    {
        $faculties = [];
        $units = $this->getDoctrine()->getRepository(Unit::class)->findAll();

        $writers = $this->getDoctrine()->getRepository(BookLecturer::class)->findAll();
        foreach ($units as $unit) {
            $faculties[$unit->getId()] = new ArrayCollection();
        }

        foreach ($writers as $writer) {
//            echo sprintf("<li>%s</li>", $inventor);
            if ($writer->getLecturer() !== null && $writer->getLecturer()->getUnit() !== null) {
                if (!$faculties[$writer->getLecturer()->getUnit()->getId()]->contains($writer->getBook())) {
                    $faculties[$writer->getLecturer()->getUnit()->getId()]->add($writer->getBook());
                }
            }
        }

        $f = [];
        foreach ($faculties as $id=>$v) {
            $f[] = $v->count();
        }

        return $f;
    }

    /**
     * @Route("/lecturers")
     */
    public function lecturerList()
    {
        $lecturers = $this->getDoctrine()->getRepository(Lecturer::class)->findWithFaculty();

        return $this->render('front/lecturer/list-lecturers.html.twig', [
           'lecturers' => $lecturers,
            'jafung_list' => json_encode($this->jafung),
            'jafung_stat' => json_encode($this->jafung()),
        ]);
    }

    /**
     * @Route("/lecturer/{id}", name="lecturer_show")
     */
    public function lecturerView($id, LecturerRepository $repository, Request $request)
    {
        $tab = $request->query->get('tab', 'journal');


        $tab = $tab == "publikasi" ? "journal": $tab;

        $tabs = [
            'publikasi' => 'Publikasi',
            'penelitian' =>'Penelitian',
//            'journal' =>'Jurnal',
//            'conference' =>'Konferensi',
//            'book' =>'Buku',
            'intellectual-property'=>'HKI',
            'community-service' =>'Pengabdian Masyarakat',
            'additional-output' =>'Produk Inovatif',
//            'document' =>'Dokumen',
        ];

        $lect        = $repository->findOneWithAttribute($id);
        $journals    = $this->getDoctrine()->getRepository(Journal::class)->findByPeople($id);
        $conferences = $this->getDoctrine()->getRepository(Conference::class)->findByPeople($id);
        $ips         = $this->getDoctrine()->getRepository(IntellectualProperty::class)->findByPeople($id);
        $books       = $this->getDoctrine()->getRepository(Book::class)->findByPeople($id);
        $aos         = $this->getDoctrine()->getRepository(AdditionalOutput::class)->findByPeople($id);
        $coms        = $this->getDoctrine()->getRepository(CommunityService::class)->findByPeople($id);
        $researches  = $this->getDoctrine()->getRepository(Research::class)->findByPeople($id);

        return $this->render('front/lecturer/lecturer-view.html.twig', [
            'lecturer' => $lect,
            'tab' => $tab,
            'tabs' => $tabs,
            'journals' => $journals,
            'conferences' => $conferences,
            'ips' => $ips,
            'aos' => $aos,
            'books' => $books,
            'coms' => $coms,
            'pubs_stat' => $this->last3Years(['lecturer' => $id]),
            "researches" => $researches
        ]);
    }

    /**
     * @Route("/publication/journals")
     */
    public function journals(JournalRepository $repository, ConferenceRepository $conferenceRepository, BookRepository $bookRepository, Request $request)
    {
        $type = $request->query->get('type', 'journal');
        if ($type == "journal")
            $data = $repository->findLatest();
        elseif ($type == "conference")
            $data = $conferenceRepository->findLatest();
        else
            $data = $bookRepository->findLatest();

        return $this->render('front/publication/list.html.twig', [
            'data' => $data,
            'type' => $type,
        ]);
    }

    /**
     * @Route("/item/{type}/{id}", name="object_show")
     * @param $id
     */
    public function itemView($type, $id)
    {
        $item = $this->findOject($id, $type);
        return $this->render('front/publication/item-view.html.twig', [
            'item' => $item,
            'type' => $type
        ]);
    }

    protected function findOject($id, $type)
    {
        if ($type == 'journal') {
            $repo = $this->getDoctrine()->getRepository(Journal::class)->find($id);
            return $repo;
        }

        if ($type == 'conference') {
            $repo = $this->getDoctrine()->getRepository(Conference::class)->find($id);
            return $repo;
        }

        if ($type == 'intellectual-property') {
            $repo = $this->getDoctrine()->getRepository(IntellectualProperty::class)->find($id);
            return $repo;
        }

        if ($type == 'book') {
            $repo = $this->getDoctrine()->getRepository(Book::class)->find($id);
            return $repo;
        }

        if ($type == 'additional-output') {
            $repo = $this->getDoctrine()->getRepository(AdditionalOutput::class)->find($id);
            return $repo;
        }

        if ($type == 'community-service') {
            $repo = $this->getDoctrine()->getRepository(CommunityService::class)->find($id);
            return $repo;
        }

        return null;
    }

    /**
     * @Route("/jafung")
     */
    public function jafung($faculty = null): array
    {
        $data1 = [
            0,0,0,0,0,0
        ];
        $repo = $this->getDoctrine()->getRepository(Lecturer::class);
        if ($faculty == null)
            $data = $repo->getJafungStat();
        else
            $data = $repo->getJafungStat(['faculty' => $faculty]);

        foreach ($data as $item) {
            $data1[$item['functional']] = $item['jum'];
        }


        return $data1;

//        return new Response();
    }

    /**
     * @Route("/book")
     */
    public function book()
    {
        $repo = $this->getDoctrine()->getRepository(Unit::class);
        $qb = $repo->createQueryBuilder("u");
        $qb->select('u.name');
        $qb->innerJoin('u.lecturers', 'l')->join('l.bookLecturers', 'b')->join('b.book', 'book');
//        $qb->addSelect('book.id')->distinct(true);
        $qb->addSelect('(SELECT COUNT(lec.id) FROM App\Entity\Lecturer AS lec WHERE l.unit=u) as j');
//        $qb->groupBy('u.id');

        echo "<pre>";
        print_r($qb->getQuery()->getResult());
        return new Response();
    }

    /**
     * @Route("/last-year")
     */
    public function lastYears()
    {
        $repo = $this->getDoctrine()->getRepository(Year::class);
        $qb = $repo->createQueryBuilder("y");
        $qb->select('y.year');
        $qb->orderBy('y.year', 'desc');
        $qb->join('y.journals', "j");
        $qb->join('j.journalLecturers', 'jl');
        $qb->addSelect("count(j.id)");
        $qb->groupBy('y.year');
        $qb->andWhere($qb->expr()->eq('jl.lecturer', 6));

        return new Response();
    }

    public function last3Years(array $options =[])
    {
        $l = range(date("Y")-2, date("Y"));
        $v = array_fill(0, count($l), 0);
        $data = array_combine($l, $v);

        $repo = $this->getDoctrine()->getRepository(Year::class);

        $journals= $repo->journalNumber($options);
        foreach ($journals as $journal) {
            if (key_exists($journal['year'], $data))
                $data[$journal['year']] += $journal['jum'];
        }

        $conferences= $repo->conferenceNumber($options);
        foreach ($conferences as $conference) {
            if (key_exists($conference['year'], $data))
                $data[$conference['year']] += $conference['jum'];
        }

        $books= $repo->bookNumber($options);
        foreach ($books as $book) {
            if (key_exists($book['year'], $data))
                $data[$book['year']] += $book['jum'];
        }


        return [
            'years_pub' => array_keys($data),
            'years_pub_stat' => array_values($data),
        ];
    }

}
