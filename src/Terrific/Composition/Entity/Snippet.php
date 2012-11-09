<?php

namespace Terrific\Composition\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;
use JMS\SerializerBundle\Annotation\ReadOnly;
use JMS\SerializerBundle\Annotation\Type;
use JMS\SerializerBundle\Annotation\Groups;

/**
 * Terrific\Composition\Entity\Snippet
 *
 * @ORM\Table(name="snippet")
 * @ORM\Entity(repositoryClass="Terrific\Composition\Entity\SnippetRepository")
 */
class Snippet
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ReadOnly
     * @Groups({"module_details"})
     */
    private $id;

    /**
     * @var text $code
     *
     * @ORM\Column(name="code", type="text")
     * @Type("string")
     * @Groups({"module_details"})
     */
    private $code;

    /**
     * @var string $mode
     *
     * @ORM\Column(name="mode", type="string", length=255)
     * @Type("string")
     * @Groups({"module_details"})
     */
    private $mode;


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
     * Set code
     *
     * @param text $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * Get code
     *
     * @return text
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set mode
     *
     * @param string $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    /**
     * Get mode
     *
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }
}