<?php

declare(strict_types=1);

namespace App\Entity\Course;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;
use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Component\Resource\Model\TranslationInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_course_page")
 */
class CoursePage implements TranslatableInterface, ResourceInterface
{
    use TranslatableTrait {
        __construct as private initializeTranslationsCollection;
        getTranslation as private doGetTranslation;
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $position;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="Course",
     *     inversedBy="pages",
     * )
     * @ORM\JoinColumn(name="course_id", onDelete="SET NULL")
     */
    private $course;

    public function getId(): ?int
    {
        return $this->id;
    }

    protected function createTranslation(): TranslationInterface
    {
        return new CoursePageTranslation();
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getCourse(): Course
    {
        return $this->course;
    }

    public function setCourse(Course $course): self
    {
        $this->course = $course;

        return $this;
    }

    /**
     * @return CoursePageTranslation
     */
    public function getTranslation(?string $locale = null): TranslationInterface
    {
        /** @var CoursePageTranslation $translation */
        $translation = $this->doGetTranslation($locale);

        return $translation;
    }

    public function getName(): ?string
    {
        return $this->getTranslation()->getName();
    }

    public function getSlug(): ?string
    {
        return $this->getTranslation()->getSlug();
    }

    public function getContent(): ?string
    {
        return $this->getTranslation()->getContent();
    }

    public function getPreviousPage(): ?CoursePage
    {
        $pages = $this->getCourse()->getPages();
        $index = $pages->indexOf($this);
        if (is_int($index)) {
            if ($index === 0) {
                return null;
            } else {
                return $pages->get(--$index);
            }
        }

        return null;
    }

    public function getNextPage(): ?CoursePage
    {
        $pages = $this->getCourse()->getPages();
        $index = $pages->indexOf($this);
        if (is_int($index)) {
            if ($index === $pages->count() - 1) {
                return null;
            } else {
                return $pages->get(++$index);
            }
        }

        return null;
    }
}
