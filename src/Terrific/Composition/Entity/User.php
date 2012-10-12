<?php
namespace Terrific\Composition\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tc_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", name="github_id", nullable=true)
     */
    protected $githubId;

    /**
     * @ORM\Column(type="integer", name="twitter_id", nullable=true)
     */
    protected $twitterId;

    /**
     * @ORM\OneToMany(targetEntity="Project", mappedBy="user")
     */
    protected $projects;


    public function __construct()
    {
        parent::__construct();
    }

    public function setGithubId($githubId)
    {
        $this->githubId = $githubId;
    }

    public function getGithubId()
    {
        return $this->githubId;
    }

    public function setTwitterId($twitterId)
    {
        $this->twitterId = $twitterId;
    }

    public function getTwitterId()
    {
        return $this->twitterId;
    }

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
     * Add projects
     *
     * @param Terrific\Composition\Entity\Project $projects
     * @return User
     */
    public function addProject(\Terrific\Composition\Entity\Project $projects)
    {
        $this->projects[] = $projects;
    
        return $this;
    }

    /**
     * Remove projects
     *
     * @param Terrific\Composition\Entity\Project $projects
     */
    public function removeProject(\Terrific\Composition\Entity\Project $projects)
    {
        $this->projects->removeElement($projects);
    }

    /**
     * Get projects
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getProjects()
    {
        return $this->projects;
    }
}