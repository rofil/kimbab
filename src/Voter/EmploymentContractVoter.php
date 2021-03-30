<?php


namespace App\Voter;

use App\Entity\Conference;
use App\Entity\ConferenceOrganizer;
use App\Entity\EmploymentContract;
use App\Entity\Lecturer;
use App\Entity\Unit;
use App\Repository\LecturerRepository;
use App\Service\RoleAttributeService;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class EmploymentContractVoter extends Voter
{
    protected $container;
    protected $rolesAndAttributes;

    public function __construct(RoleAttributeService $rolesAndAttributes, ContainerInterface $container)
    {
        $this->rolesAndAttributes = $rolesAndAttributes;
        $this->container = $container;
    }

    public function getUnit(): Unit
    {
        return $this->container->get("security.token_storage")->getToken()->getUser()->getUnit();
    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @return bool
     */
    protected function supports($attribute, $subject)
    {
        $roles= $this->rolesAndAttributes->fetchRoleAttributes()->get('ROLE_EMPLOYMENT_CONTRACT_ADMIN')->toArray();
        $x =  $subject instanceof EmploymentContract && in_array($attribute, $roles);
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

        if (in_array('ROLE_SUPER_ADMIN', $user->getRoles()) || in_array('ROLE_ADMIN', $user->getRoles())){
            return true;
        }

        if (in_array('ROLE_UNIT', $user->getRoles())) {

            if ($this->getUnit()->getEmploymentContracts()->contains($subject))
                return true;

            if (in_array($attribute, [
                'ROLE_ADMIN_EMPLOYMENT_CONTRACT_VIEW' ])){
                return true;
            }

            if (in_array($attribute, [
                'ROLE_ADMIN_EMPLOYMENT_CONTRACT_CREATE' ])){
                return true;
            }
        }

        return false;
    }
}