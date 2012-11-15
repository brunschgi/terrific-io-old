<?php

namespace Terrific\Composition\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\SerializerBundle\Annotation\ReadOnly;
use JMS\SerializerBundle\Annotation\Type;
use JMS\SerializerBundle\Annotation\Exclude;
use JMS\SerializerBundle\Annotation\Groups;
use JMS\SerializerBundle\Annotation\Accessor;

/**
 * Terrific\Composition\Entity\Module
 *
 * @ORM\Table(name="module")
 * @ORM\Entity(repositoryClass="Terrific\Composition\Entity\ModuleRepository")
 */
class Module
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"project_list", "project_details", "module_list", "module_details"})
     * @ReadOnly
     */
    private $id;

    /**
     * @ORM\Column(name="in_work", type="boolean")
     * @Type("boolean")
     * @Groups({"project_list", "project_details", "module_list", "module_details"})
     */
    private $inWork = false;

    /**
     * @ORM\Column(name="shared", type="boolean")
     * @Type("boolean")
     * @Groups({"project_list", "project_details", "module_list", "module_details"})
     */
    private $shared = false;

    /**
     * @ORM\Column(name="title", type="string", length=255)
     * @Type("string")
     * @Groups({"project_list", "project_details", "module_list", "module_details"})
     */
    private $title;

    /**
     * @ORM\Column(name="description", type="text")
     * @Type("string")
     * @Groups({"project_list", "project_details", "module_list", "module_details"})
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Project")
     * @Type("integer")
     * @Groups({"module_details"})
     */
    private $project;

    /**
     * @ORM\OneToOne(targetEntity="Snippet")
     * @Type("Terrific\Composition\Entity\Snippet")
     * @Groups({"module_details"})
     */
    private $markup;

    /**
     * @ORM\OneToOne(targetEntity="Snippet")
     * @Type("Terrific\Composition\Entity\Snippet")
     * @Groups({"module_details"})
     */
    private $style;

    /**
     * @ORM\OneToOne(targetEntity="Snippet")
     * @Type("Terrific\Composition\Entity\Snippet")
     * @Groups({"module_details"})
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

    /**
     * Set inWork
     *
     * @param boolean $inWork
     * @return Module
     */
    public function setInWork($inWork)
    {
        $this->inWork = $inWork;

        return $this;
    }

    /**
     * Get inWork
     *
     * @return boolean
     */
    public function getInWork()
    {
        return $this->inWork;
    }

    /**
     * Set shared
     *
     * @param boolean $shared
     * @return Module
     */
    public function setShared($shared)
    {
        $this->shared = $shared;

        return $this;
    }

    /**
     * Get shared
     *
     * @return boolean
     */
    public function getShared()
    {
        return $this->shared;
    }
}