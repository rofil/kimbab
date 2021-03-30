<?php


namespace App\Voter;

use App\Entity\Conference;
use App\Entity\IntellectualProperty;
use App\Entity\Lecturer;
use App\Repository\LecturerRepository;
use App\Service\RoleAttributeService;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class IntellectualPropertyVoter extends Voter
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
        $roles= $this->rolesAndAttributes->fetchRoleAttributes()->get('ROLE_INTELLECTUAL_PROPERTY_ADMIN')->toArray();
        return $subject instanceof IntellectualProperty && in_array($attribute, $roles);
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

        if (in_array('ROLE_SUPER_ADMIN', $user->getRoles()) || in_array('ROLE_ADMIN', $user->getRoles())){
            return true;
        }
        /**
         * READER
         */
        if (in_array($attribute, [
            'ROLE_ADMIN_COM_INTELLECTUAL_PROPERTY_VIEW', 'ROLE_ADMIN_RESEARCH_INTELLECTUAL_PROPERTY_VIEW',
            'ROLE_ADMIN_INTELLECTUAL_PROPERTY_VIEW' ])){
            return true;
        }

        if (in_array('ROLE_LECTURER', $user->getRoles())) {
            $lecturer = $this->getLecturer();
            if ($lecturer->getOwnIntellectualProperties()->contains($subject)) {
                return true;
            }

            if (in_array($attribute, [
                'ROLE_ADMIN_COM_INTELLECTUAL_PROPERTY_CREATE', 'ROLE_ADMIN_RESEARCH_INTELLECTUAL_PROPERTY_CREATE',
                'ROLE_ADMIN_INTELLECTUAL_PROPERTY_CREATE' ])){
                return true;
            }

        }
        if (in_array('ROLE_USER', $user->getRoles())) {
            $role_attributes = $this->rolesAndAttributes->fetchRoleAttributes()->get('ROLE_USER');
            if($role_attributes instanceof ArrayCollection && $role_attributes->contains($attribute)) {
                return true;
            }
        }

        return false;
    }
}