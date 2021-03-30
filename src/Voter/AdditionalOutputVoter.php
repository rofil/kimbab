<?php


namespace App\Voter;

use App\Entity\AdditionalOutput;
use App\Entity\Book;
use App\Entity\Conference;
use App\Entity\Lecturer;
use App\Repository\LecturerRepository;
use App\Service\RoleAttributeService;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class AdditionalOutputVoter extends Voter
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
//        return true;
        return $subject instanceof AdditionalOutput && in_array($attribute, [
            'ROLE_ADMIN_ADDITIONAL_OUTPUT_LIST',
            'ROLE_ADMIN_ADDITIONAL_OUTPUT_VIEW',
            'ROLE_ADMIN_ADDITIONAL_OUTPUT_EDIT',
            'ROLE_ADMIN_ADDITIONAL_OUTPUT_CREATE',
            'ROLE_ADMIN_ADDITIONAL_OUTPUT_DELETE',
            'ROLE_ADMIN_ADDITIONAL_OUTPUT_EXPORT',
            'ROLE_ADMIN_ADDITIONAL_OUTPUT_SHOW',
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

        if (in_array($attribute, [
            'ROLE_ADMIN_ADDITIONAL_OUTPUT_VIEW' ])){
            return true;
        }

        if (in_array('ROLE_SUPER_ADMIN', $user->getRoles()) || in_array('ROLE_ADMIN', $user->getRoles())){
            return true;
        }

        if (in_array('ROLE_LECTURER', $user->getRoles())) {
            $lecturer = $this->getLecturer();
            if ($lecturer->getAdditionalOutputs()->contains($subject)) {
                return true;
            }

            if (in_array($attribute, [
                'ROLE_ADMIN_ADDITIONAL_OUTPUT_CREATE' ])){
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