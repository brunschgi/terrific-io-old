<?php

namespace Terrific\Composition\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\SerializerBundle\Annotation\ReadOnly;
use JMS\SerializerBundle\Annotation\Type;
use JMS\SerializerBundle\Annotation\Exclude;

/**
 * Terrific\Composition\Entity\Project
 *
 * @ORM\Table(name="project")
 * @ORM\Entity(repositoryClass="Terrific\Composition\Entity\ProjectRepository")
 */
class Project
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
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Type("string")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="projects")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @Exclude
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="Module", mappedBy="project")
     * @Type("Terrific\Composition\Entity\Module")
     */
    protected $modules;

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
     * Set name
     *
     * @param string $name
     * @return Project
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }



    /**
     * Set user
     *
     * @param Terrific\Composition\Entity\User $user
     * @return Project
     */
    public function setUser(\Terrific\Composition\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return Terrific\Composition\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set style
     *
     * @param Terrific\Composition\Entity\Snippet $style
     * @return Project
     */
    public function setStyle(\Terrific\Composition\Entity\Snippet $style = null)
    {
        $this->style = $style;

        return $this;
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
     * @return Project
     */
    public function setScript(\Terrific\Composition\Entity\Snippet $script = null)
    {
        $this->script = $script;

        return $this;
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
     * Constructor
     */
    public function __construct()
    {
        $this->modules = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add modules
     *
     * @param Terrific\Composition\Entity\Module $modules
     * @return Project
     */
    public function addModule(\Terrific\Composition\Entity\Module $modules)
    {
        $this->modules[] = $modules;
    
        return $this;
    }

    /**
     * Remove modules
     *
     * @param Terrific\Composition\Entity\Module $modules
     */
    public function removeModule(\Terrific\Composition\Entity\Module $modules)
    {
        $this->modules->removeElement($modules);
    }

    /**
     * Get modules
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getModules()
    {
        return $this->modules;
    }
}