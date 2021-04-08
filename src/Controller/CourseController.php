<?php

namespace App\Controller;

use App\Entity\Course\Course;
use App\Entity\Course\CoursePage;
use App\Entity\Course\CourseTranslation;
use App\Entity\User\ShopUser;
use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CourseController extends AbstractController
{
    public function listAction()
    {
        if (!$this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            throw new AccessDeniedException('You have to be registered user to access this section.');
        }

        /** @var ShopUser $user */
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        return $this->render(
            'Account/course/list.html.twig',
            ['courses' => $user->getCourses()]
        );
    }

    public function courseAction(string $slug, EntityRepository $courseTranslationRepository)
    {

        $courseTranslation = $courseTranslationRepository->findOneBy(['slug' => $slug]);
        if (!$courseTranslation instanceof CourseTranslation) {
            return $this->redirectToRoute('sylius_shop_account_courses');
        }
        /** @var Course $course */
        $course = $courseTranslation->getTranslatable();
        /** @var ShopUser $user */
        $user = $this->getUser();
        $courses = $user->getCourses();
        if (!$courses->contains($course)) {
            return $this->redirectToRoute('sylius_shop_account_courses');
        }

        $iterator = $courseTranslation->getTranslatable()->getPages()->getIterator();
        $iterator->uasort(function ($a, $b) {
            return ($a->getPosition() < $b->getPosition()) ? -1 : 1;
        });
        $pages = new ArrayCollection(iterator_to_array($iterator));

        return $this->render(
            'Account/course/view.html.twig',
            [
                'course' => $courseTranslation->getTranslatable(),
                'pages' => $pages,
            ]
        );
    }

    public function coursePageAction(string $slug, string $pageSlug, EntityRepository $courseTranslationRepository)
    {
        $courseTranslation = $courseTranslationRepository->findOneBy(['slug' => $slug]);
        if (!$courseTranslation instanceof CourseTranslation) {
            return $this->redirectToRoute('sylius_shop_account_courses');
        }
        /** @var Course $course */
        $course = $courseTranslation->getTranslatable();
        /** @var ShopUser $user */
        $user = $this->getUser();
        $courses = $user->getCourses();
        if (!$courses->contains($course)) {
            return $this->redirectToRoute('sylius_shop_account_courses');
        }

        $coursePage = null;
        foreach ($courseTranslation->getTranslatable()->getPages() as $page) {
            if ($page->getSlug() === $pageSlug) {
                $coursePage = $page;
            }
        }
        if (!$coursePage instanceof CoursePage) {
            return $this->redirectToRoute('sylius_shop_account_course', ['slug' => $slug]);
        }

        return $this->render(
            'Account/course/page.html.twig',
            ['coursePage' => $coursePage]
        );
    }
}
