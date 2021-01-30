<?php

declare(strict_types=1);

namespace App\Entity\Course;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;
use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Component\Resource\Model\TranslationInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_course")
 */
class Course implements TranslatableInterface, ResourceInterface
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
     * @ORM\Column(type="string")
     */
    private $code;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(
     *     targetEntity="CoursePage",
     *     mappedBy="course",
     *     orphanRemoval=true,
     *     cascade={"all"}
     * )
     */
    private $pages;

    public function __construct()
    {
        $this->pages = new ArrayCollection();
        $this->translations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    protected function createTranslation(): TranslationInterface
    {
        return new CourseTranslation();
    }

    /**
     * @return Collection|CoursePage[]
     */
    public function getPages(): Collection
    {
        return $this->pages;
    }

    public function addPage(CoursePage $page): self
    {
        if (!$this->pages->contains($page)) {
            $this->pages[] = $page;
            $page->setCourse($this);
        }

        return $this;
    }

    public function removePage(CoursePage $page): self
    {
        if ($this->pages->removeElement($page)) {
            // set the owning side to null (unless already changed)
            if ($page->getCourse() === $this) {
                $page->setCourse(null);
            }
        }

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return CourseTranslation
     */
    public function getTranslation(?string $locale = null): TranslationInterface
    {
        /** @var CourseTranslation $translation */
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

    public function __toString(): string
    {
        return (string) $this->getName();
    }
}
