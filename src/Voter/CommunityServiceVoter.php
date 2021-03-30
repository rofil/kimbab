<?php


namespace App\Voter;

use App\Entity\Book;
use App\Entity\CommunityService;
use App\Entity\Conference;
use App\Entity\Lecturer;
use App\Repository\LecturerRepository;
use App\Service\RoleAttributeService;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CommunityServiceVoter extends Voter
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
        return $subject instanceof CommunityService && in_array($attribute, [
            'ROLE_ADMIN_COMMUNITY_SERVICE_LIST',
            'ROLE_ADMIN_COMMUNITY_SERVICE_VIEW',
            'ROLE_ADMIN_COMMUNITY_SERVICE_EDIT',
            'ROLE_ADMIN_COMMUNITY_SERVICE_CREATE',
            'ROLE_ADMIN_COMMUNITY_SERVICE_DELETE',
            'ROLE_ADMIN_COMMUNITY_SERVICE_EXPORT',
            'ROLE_ADMIN_COMMUNITY_SERVICE_SHOW',
        ]);
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
        if (in_array($attribute, ['ROLE_ADMIN_COMMUNITY_SERVICE_VIEW']))
            return true;


        if (in_array('ROLE_LECTURER', $user->getRoles())) {
            $lecturer = $this->getLecturer();
            if ($lecturer->getCommunityServices()->contains($subject)) {
                return true;
            }
            /**
             * Add new Item
             */
            if (in_array($attribute, ['ROLE_ADMIN_COMMUNITY_SERVICE_CREATE']))
                return true;

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