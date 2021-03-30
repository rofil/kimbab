<?php

// src/EventListener/MenuBuilderListener.php

namespace App\EventListener;

use Sonata\AdminBundle\Event\ConfigureMenuEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class MenuBuilderListener
{
    protected $user;

    public function __construct(TokenStorage $tokenStorage)
    {
        $this->user = $tokenStorage->getToken()->getUser();

    }

    public function addMenuItems(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu();

//        $child = $menu->addChild('profile', [
//            'label' => 'Profile',
//            'route' => 'admin_app_lecturer_my_profile',
//        ])->setExtras([
//            'icon' => '<i class="fa fa-user"></i>',
//        ]);

        if (in_array("ROLE_LECTURER", $this->user->getRoles())) {
            $child = $menu->addChild('reports', [
                'label' => 'Profile',
//            'route' => 'admin_app_lecturer_my_profile',
            ])->setExtras([
                'icon' => '<i class="fa fa-user"></i>',
            ]);
            $child->addChild("profile", [
                'label' => 'Profile',
                'route' => 'admin_app_lecturer_my_profile',
            ]);
            $child->addChild("edit", [
                'label' => 'Edit Profile',
                'route' => 'admin_app_lecturer_my_profile_edit',
            ]);
        }


    }
}