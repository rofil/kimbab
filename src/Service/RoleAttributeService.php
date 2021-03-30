<?php


namespace App\Service;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RoleAttributeService
{
    protected $roles;

    public function __construct(ContainerInterface $container)
    {
        $this->roles = $container->getParameter("security.role_hierarchy.roles");
    }

    public function fetchRoleAttributes(): Collection
    {
        $roles = new ArrayCollection();
        foreach ($this->roles as $role=>$attributes) {
            $roles->set($role, new ArrayCollection($this->_f($attributes)));
        }
        return $roles;
    }

    protected function _f(array $attributes): array
    {
        $atr = [];
        foreach ($attributes as $attribute){
            if (in_array($attribute, array_keys($this->roles))) {
                $r = $this->_f($this->roles[$attribute]);
                $atr = array_merge($atr, $r);
            } else{
                $atr[] = $attribute;
            }
        }


        return $atr;
    }

}