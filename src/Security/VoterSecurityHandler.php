<?php


namespace App\Security;


use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Security\Handler\SecurityHandlerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;

class VoterSecurityHandler implements SecurityHandlerInterface
{
    private $authorizationChecker;

    private $superAdminRoles;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, array $superAdminRoles)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->superAdminRoles = $superAdminRoles;
    }

    /**
     * @param AdminInterface $admin
     * @param array|string $attributes
     * @param mixed|null $object
     * @return bool
     */
    public function isGranted(AdminInterface $admin, $attributes, $object = null)
    {

        if (!is_array($attributes))
            $attributes = [$attributes];
        foreach ($attributes as $pos => $attribute) {
            $attributes[$pos] = sprintf($this->getBaseRole($admin), $attribute);
        }


        $allRole = sprintf($this->getBaseRole($admin), 'ALL');
//        echo "<br>";
//        echo sprintf("%s<br>", print_r($attributes, true));
//        echo $this->authorizationChecker->isGranted($this->superAdminRoles) ? "Yes":"No"; echo "<br>";
//        echo $this->authorizationChecker->isGranted($attributes, $object) ? "Yes":"No"; echo "<br>";
//        echo $this->authorizationChecker->isGranted([$allRole], $object) ? "Yes":"No"; echo "<br>";
//        echo "<br>";
//        print_r($attributes);

        try{
            $x =  $this->authorizationChecker->isGranted($this->superAdminRoles)
                || $this->authorizationChecker->isGranted($attributes, $object)
                || $this->authorizationChecker->isGranted([$allRole], $object);
//            echo $x == true ? "e": "f";


            return $x;

        } catch (AuthenticationCredentialsNotFoundException $e) {
            return true;
        }


    }

    /**
     * @param AdminInterface $admin
     * @return string
     */
    public function getBaseRole(AdminInterface $admin)
    {
        return 'ROLE_'.str_replace('.', '_',strtoupper($admin->getCode())).'_%s';
    }

    /**
     * @param AdminInterface $admin
     * @return mixed
     */
    public function buildSecurityInformation(AdminInterface $admin)
    {
        return [];
    }

    /**
     * @param AdminInterface $admin
     * @param mixed $object
     * @return mixed
     */
    public function createObjectSecurity(AdminInterface $admin, $object)
    {

    }

    /**
     * @param AdminInterface $admin
     * @param mixed $object
     * @return mixed
     */
    public function deleteObjectSecurity(AdminInterface $admin, $object)
    {

    }

}