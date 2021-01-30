<?php

declare(strict_types=1);

namespace App\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $newSubmenu = $menu
            ->addChild('new')
            ->setLabel('Courses')
        ;

        $newSubmenu
            ->addChild('new-subitem', [
                'route' => 'app_admin_course_index',
            ])
            ->setLabel('Course')
        ;
    }
}
