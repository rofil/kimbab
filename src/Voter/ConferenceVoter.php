<?php


namespace App\Voter;

use App\Entity\Conference;
use App\Entity\Lecturer;
use App\Repository\LecturerRepository;
use App\Service\RoleAttributeService;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ConferenceVoter extends Voter
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
        $roles= $this->rolesAndAttributes->fetchRoleAttributes()->get('ROLE_CONFERENCE_ADMIN')->toArray();
        $x =  $subject instanceof Conference && in_array($attribute, $roles);
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
            if ($lecturer->getConferences()->contains($subject)) {
                return true;
            }
            /**
             * For CREATE
             */
            if (in_array($attribute, [
                'ROLE_ADMIN_COM_CONFERENCE_CREATE', 'ROLE_ADMIN_RESEARCH_CONFERENCE_CREATE',
                'ROLE_ADMIN_APP_CONFERENCE_CREATE' ])){
                return true;
            }
        }

        /**
         * For READER
         */
        if (in_array($attribute, [
            'ROLE_ADMIN_COM_CONFERENCE_VIEW', 'ROLE_ADMIN_RESEARCH_CONFERENCE_VIEW',
            'ROLE_ADMIN_APP_CONFERENCE_VIEW' ])){
            return true;
        }

        if (in_array('ROLE_USER', $user->getRoles())) {

            $role_attributes = $this->rolesAndAttributes->fetchRoleAttributes()->get('ROLE_USER');
//            print_r($role_attributes->toArray());
//            echo sprintf("<b>%s</b>", $attribute);
            if($role_attributes instanceof ArrayCollection && $role_attributes->contains($attribute)) {
                return true;
            }
        }

        return false;
    }
}