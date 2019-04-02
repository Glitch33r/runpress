<?php

namespace FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WpTermTaxonomy
 *
 * @ORM\Table(name="wp_term_taxonomy", uniqueConstraints={@ORM\UniqueConstraint(name="term_id_taxonomy", columns={"term_id", "taxonomy"})}, indexes={@ORM\Index(name="taxonomy", columns={"taxonomy"})})
 * @ORM\Entity
 */
class WpTermTaxonomy
{
    /**
     * @var int
     *
     * @ORM\Column(name="term_taxonomy_id", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $termTaxonomyId;

    /**
     * @var int
     *
     * @ORM\Column(name="term_id", type="bigint", nullable=false, options={"unsigned"=true})
     */
    private $termId = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="taxonomy", type="string", length=32, nullable=false)
     */
    private $taxonomy = '';

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=0, nullable=false)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="parent", type="bigint", nullable=false, options={"unsigned"=true})
     */
    private $parent = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="count", type="bigint", nullable=false)
     */
    private $count = '0';

    public function getTermTaxonomyId(): ?int
    {
        return $this->termTaxonomyId;
    }

    public function getTermId(): ?int
    {
        return $this->termId;
    }

    public function setTermId(int $termId): self
    {
        $this->termId = $termId;

        return $this;
    }

    public function getTaxonomy(): ?string
    {
        return $this->taxonomy;
    }

    public function setTaxonomy(string $taxonomy): self
    {
        $this->taxonomy = $taxonomy;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getParent(): ?int
    {
        return $this->parent;
    }

    public function setParent(int $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }


}
