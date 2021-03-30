<?php

namespace App\Security;

use App\Entity\Lecturer;
use App\Entity\Program;
use App\Entity\Roles;
use App\Entity\Unit;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;

    private $entityManager;
    private $router;
    private $urlGenerator;
    private $csrfTokenManager;
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, RouterInterface $router, UrlGeneratorInterface $urlGenerator, CsrfTokenManagerInterface $csrfTokenManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->router = $router;
        $this->urlGenerator = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function supports(Request $request)
    {
        return 'app_login' === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        $credentials = [
            'username' => $request->request->get('username'),
            'password' => $request->request->get('password'),
            'role' => $request->request->get('role'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['username']
        );

        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }
        
        if ($credentials['role'] == "DOSEN") {
            $this->checkFromSia($credentials);
        }

//        print_r($credentials);


        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $credentials['username']]);
//        echo $user->getPassword();
//        die;
        if (!$user) {
            // fail authentication with a custom error
            throw new CustomUserMessageAuthenticationException('Username could not be found.');
        }

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        if ($credentials['role'] == "DOSEN") {
            return true;
        }
        return $credentials['password'] == $user->getPassword(); //$this->passwordEncoder->isPasswordValid($user, $credentials['password']);
        // Check the user's password or other credentials and return true or false
        // If there are no credentials to check, you can just return true
//        throw new \Exception('TODO: check the credentials inside '.__FILE__);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
            return new RedirectResponse($targetPath);
        }
        return new RedirectResponse($this->urlGenerator->generate('homepage'));

        // For example : return new RedirectResponse($this->urlGenerator->generate('some_route'));
        throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
    }

    protected function getLoginUrl()
    {
        return $this->urlGenerator->generate('app_login');
    }

    public function checkFromSia(array $credentials)
    {
        $url = 'https://apitelkomsel.unmul.ac.id/member/login';

        $account = array(
            'userid' => $credentials['username'],
            'password' => $credentials['password'],
            "usertype" => 'DSN'
        );

        
        $client = new Client();
        try{
            # Request for authentication from URL
            $response = $client->post($url, [RequestOptions::JSON => $account]);
            $content = $response->getBody()->getContents();
            $data = json_decode($content);

            $this->getLecturerAndUser($data, $credentials);

            return true;
        }catch (RequestException $exception) {
            return false;
        }
    }

    public function getRoles()
    {
        $repo = $this->entityManager->getRepository(Roles::class);
        return $repo->getInitLecturerRoles();

    }

    protected function getFacultyId($name)
    {
        if (strpos(strtolower($name), "ekonomi"))
            return 1;
        if (strpos(strtolower($name), "politik"))
            return 2;
        if (strpos(strtolower($name), "pertanian"))
            return 3;
        if (strpos(strtolower($name), "kehutanan"))
            return 4;
        if (strpos(strtolower($name), "keguruan"))
            return 5;
        if (strpos(strtolower($name), "perikanan"))
            return 6;
        if (strpos(strtolower($name), "teknik"))
            return 7;
        if (strpos(strtolower($name), "matematika"))
            return 8;
        if (strpos(strtolower($name), "kedokteran"))
            return 9;
        if (strpos(strtolower($name), "masyarakat"))
            return 10;
        if (strpos(strtolower($name), "hukum"))
            return 11;
        if (strpos(strtolower($name), "farmasi"))
            return 12;
        if (strpos(strtolower($name), "budaya"))
            return 13;
        if (strpos(strtolower($name), "komputer"))
            return 14;

        return null;
    }

    public function getFacultyByName($name): ? Unit
    {
        $repo = $this->entityManager->getRepository(Unit::class);

        return $repo->find($this->getFacultyId($name));
    }

    protected function createProgram($name, Unit $unit): Program
    {
        $em = $this->entityManager;
        $program = new Program();
        $program->setName($name);
        $program->setUnit($unit);
        $em->persist($program);
        $em->flush();
        return $program;
    }

    protected function getProgram($data, Unit $unit): ?Program
    {
        $program = $this->entityManager->getRepository(Program::class)->findOneBy(["name" => $data->studyProgramName]);

        if ($program == null && property_exists($data, "studyProgramName")) {
            $program = $this->createProgram($data->studyProgramName, $unit);
        }

        return $program;
    }

    protected function getUnit($name): Unit
    {
        $repo = $this->entityManager->getRepository(Unit::class);

        $unitId = $this->getFacultyId($name);

        if ($unitId == null) {
            $unit = new Unit();
            $unit->setName($name);
            $unit->setAbbreviation("U");
            $unit->setUnitType(Unit::TYPE_FACULTY);
            $em = $this->entityManager;
            $em->persist($unit);
            $em->flush();
            return $unit;
        }


        return $repo->find($unitId);
    }

    protected function getLecturerAndUser($data, $credentials)
    {
        $lecturerRepo = $this->entityManager->getRepository(Lecturer::class);
        $userRepo = $this->entityManager->getRepository(User::class);

        $lecturer = $lecturerRepo->findOneBy(['nip' => $data->nip]);
        $user = $userRepo->findOneBy(['username' => $data->nip]);
        $unit = $this->getUnit($data->facultyName);
        $program = $this->getProgram($data, $unit);


        if($lecturer == null) {

            $lecturer = new Lecturer();
            $lecturer->setName($data->name);
            $lecturer->setNip($data->nip);
            $lecturer->setUnit($unit);
            $lecturer->setStatus(1);
            $lecturer->setAffiliation("Universitas Mulawarman");
            $lecturer->setFunctional(0);
            $lecturer->setProgram($program);
            $this->entityManager->persist($lecturer);
        }



        if($user == null) {
            $user = new User();
            $user->setUsername($data->nip);
            $user->setPassword($credentials['password']);
            $roles = $this->getRoles();
            foreach ($roles as $role) {
                $user->addGroup($role);
            }
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }

    }
}
