<?php


namespace App\Voter;

use App\Entity\Book;
use App\Entity\Conference;
use App\Entity\Lecturer;
use App\Repository\LecturerRepository;
use App\Service\RoleAttributeService;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class BookVoter extends Voter
{
    protected $container;
    protected $rolesAndAttributes;

    public function __construct(RoleAttributeService $rolesAndAttributes, ContainerInterface $container)
    {
        $this->rolesAndAttributes = $rolesAndAttributes;
        $this->container = $container;
    }

    public function getLecturer(): Lecturer
    {
        return $this->container->get("lecturer.logged_in")->getLecturer();
    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @return bool
     */
    protected function supports($attribute, $subject)
    {
        $roles= $this->rolesAndAttributes->fetchRoleAttributes()->get('ROLE_BOOK_ADMIN')->toArray();
        $x =  $subject instanceof Book && in_array($attribute, $roles);
        return $x;
    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
//        return true;
        $user = $token->getUser();

        if (in_array('ROLE_SUPER_ADMIN', $user->getRoles()) || in_array('ROLE_ADMIN', $user->getRoles())){
            return true;
        }
        if (in_array('ROLE_LECTURER', $user->getRoles())) {
            $lecturer = $this->getLecturer();
            if ($lecturer->getBooks()->contains($subject)) {
                return true;
            }
            /**
             * For CREATE
             */
            if (in_array($attribute, [
                'ROLE_ADMIN_COM_BOOK_CREATE', 'ROLE_ADMIN_RESEARCH_BOOK_CREATE',
                'ROLE_ADMIN_BOOK_CREATE' ])){
                return true;
            }
        }

        /**
         * For READER
         */
        if (in_array($attribute, [
            'ROLE_ADMIN_COM_BOOK_VIEW', 'ROLE_ADMIN_RESEARCH_BOOK_VIEW',
            'ROLE_ADMIN_BOOK_VIEW' ])){
            return true;
        }
        
        return false;
    }
}