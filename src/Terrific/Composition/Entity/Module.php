<?php

namespace Terrific\Composition\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\SerializerBundle\Annotation\ReadOnly;
use JMS\SerializerBundle\Annotation\Type;

/**
 * Terrific\Composition\Entity\Module
 *
 * @ORM\Table(name="module")
 * @ORM\Entity(repositoryClass="Terrific\Composition\Entity\ModuleRepository")
 */
class Module
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ReadOnly
     */
    private $id;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Type("string")
     */
    private $title;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text")
     * @Type("string")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="modules")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    private $project;

    /**
     * @ORM\OneToOne(targetEntity="Snippet")
     * @Type("Terrific\Composition\Entity\Snippet")
     */
    private $markup;

    /**
     * @ORM\OneToOne(targetEntity="Snippet")
     * @Type("Terrific\Composition\Entity\Snippet")
     */
    private $style;

    /**
     * @ORM\OneToOne(targetEntity="Snippet")
     * @Type("Terrific\Composition\Entity\Snippet")
     */
    private $script;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set markup
     *
     * @param Terrific\Composition\Entity\Snippet $markup
     */
    public function setMarkup(\Terrific\Composition\Entity\Snippet $markup)
    {
        $this->markup = $markup;
    }

    /**
     * Get markup
     *
     * @return Terrific\Composition\Entity\Snippet
     */
    public function getMarkup()
    {
        return $this->markup;
    }

    /**
     * Set style
     *
     * @param Terrific\Composition\Entity\Snippet $style
     */
    public function setStyle(\Terrific\Composition\Entity\Snippet $style)
    {
        $this->style = $style;
    }

    /**
     * Get style
     *
     * @return Terrific\Composition\Entity\Snippet
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * Set script
     *
     * @param Terrific\Composition\Entity\Snippet $script
     */
    public function setScript(\Terrific\Composition\Entity\Snippet $script)
    {
        $this->script = $script;
    }

    /**
     * Get script
     *
     * @return Terrific\Composition\Entity\Snippet
     */
    public function getScript()
    {
        return $this->script;
    }

    /**
     * Set project
     *
     * @param Terrific\Composition\Entity\Project $project
     * @return Module
     */
    public function setProject(\Terrific\Composition\Entity\Project $project = null)
    {
        $this->project = $project;
    
        return $this;
    }

    /**
     * Get project
     *
     * @return Terrific\Composition\Entity\Project 
     */
    public function getProject()
    {
        return $this->project;
    }
}