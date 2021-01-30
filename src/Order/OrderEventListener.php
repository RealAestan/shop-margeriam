<?php

namespace App\Order;

use App\Entity\Product\ProductVariant;
use App\Entity\User\ShopUser;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Sylius\Component\Core\Model\OrderInterface;
use Webmozart\Assert\Assert;

final class OrderEventListener
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function postUpdate(LifecycleEventArgs $args): void
    {
        $object = $args->getObject();
        if (!$object instanceof OrderInterface || $object->getState() !== OrderInterface::STATE_FULFILLED) {
            return;
        }
        foreach ($object->getItems() as $orderItem) {
            /** @var ProductVariant $variant */
            $variant = $orderItem->getVariant();
            if (!empty($variant->getCourses())) {
                foreach ($variant->getCourses() as $course) {
                    /** @var ShopUser $user */
                    $user = $object->getUser();
                    $user->addCourse($course);
                    $this->entityManager->persist($user);
                }
                $this->entityManager->flush();
            }
        }
    }
}
