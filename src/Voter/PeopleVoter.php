<?php


namespace App\Voter;


use App\Entity\Journal;
use App\Entity\Lecturer;
use App\Service\RoleAttributeService;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class PeopleVoter extends Voter
{
    protected $roleAttributes;
    protected $container;

    public function __construct(RoleAttributeService $roleAttributes, ContainerInterface $container)
    {
        $this->roleAttributes = $roleAttributes;
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
        $roles= $this->roleAttributes->fetchRoleAttributes()->get('ROLE_PEOPLE_ADMIN')->toArray();
        $x = $subject instanceof Lecturer && in_array($attribute, $roles);
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

        $user = $token->getUser();

        if (in_array('ROLE_SUPER_ADMIN', $user->getRoles())){
            return true;
        }

        /**
         * READER
         */
        if (in_array($attribute, ['ROLE_ADMIN_PEOPLE_VIEW', 'ROLE_ADMIN_PEOPLE_VIEW', 'ROLE_ADMIN_PEOPLE_VIEW'])){
            return true;
        }

        if (in_array('ROLE_LECTURER', $user->getRoles())) {
            $lecturer = $this->getLecturer();

            if ($lecturer->getId() == $subject->getId())
                return true;
            if ($lecturer->getLecturers()->contains($subject)) {
                return true;
            }
            /**
             * READER
             */
            if (in_array($attribute, ['ROLE_ADMIN_PEOPLE_CREATE', 'ROLE_ADMIN_PEOPLE_CREATE', 'ROLE_ADMIN_PEOPLE_CREATE' ])){
                return true;
            }
        }

        return false;
    }
}