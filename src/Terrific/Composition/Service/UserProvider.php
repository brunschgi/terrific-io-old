<?php
/*
 * This file is part of the Terrific Composer Bundle.
 *
 * (c) Remo Brunschwiler <remo@terrifically.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Terrific\Composition\Service;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use HWI\Bundle\OAuthBundle\Security\Core\User\EntityUserProvider;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Terrific\Composition\Entity\User;

/**
 * UserProvider
 */
class UserProvider extends EntityUserProvider implements UserProviderInterface, OAuthAwareUserProviderInterface
{

    private $em;

    /**
     * @var array
     */
    private $properties;

    /**
     * @var mixed
     */
    private $repository;

    /**
     * Constructor.
     *
     * @param ManagerRegistry $registry    Manager registry.
     * @param string          $class       User entity class to load.
     * @param array           $properties  Mapping of resource owners to properties
     * @param string          $managerName Optional name of the entitymanager to use
     */
    public function __construct(ManagerRegistry $registry, $class, array $properties, $managerName = null)
    {
        $this->em = $registry->getManager($managerName);
        $this->repository = $this->em->getRepository($class);
        $this->properties = $properties;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $resourceOwnerName = $response->getResourceOwner()->getName();

        if (!isset($this->properties[$resourceOwnerName])) {
            throw new \RuntimeException(sprintf("No property defined for entity for resource owner '%s'.", $resourceOwnerName));
        }

        // check whether the user already exists (matching resource owner)
        $resourceOwnerid = $response->getUsername();
        $nickname = $response->getNickname();
        $user = $this->repository->findOneBy(array($this->properties[$resourceOwnerName] => $resourceOwnerid));

        if (null === $user) {
            // check whether the username is already taken
            $user = $this->repository->findOneBy(array('username' => $nickname));

            if (null === $user) {
                // create new user
                $user = new User($nickname);
                $user->setName($response->getRealName());

                if($resourceOwnerName == 'twitter') {
                    $user->setTwitterId($response->getUsername());
                }
                else if($resourceOwnerName == 'github') {
                    $user->setGithubId($response->getUsername());
                    $user->setEmail($response->getEmail());
                    $user->setAvatar($response->getProfilePicture());
                }

                $this->em->persist($user);
                $this->em->flush();
            }
            else {
                // username already taken
                if($user->getTwitterId()) {
                    throw new AuthenticationException(sprintf("Oops… There is already a %s who uses his Twitter account!? If that's you, please try to login with Twitter.", $nickname));
                }
                else {
                    throw new AuthenticationException(sprintf("Oops… There is already a %s who uses his Github account!? If that's you, please try to login with Github.", $nickname));
                }
            }
        }

        return $user;
    }

    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param string $username The username
     *
     * @return UserInterface
     *
     * @see UsernameNotFoundException
     *
     * @throws UsernameNotFoundException if the user is not found
     *
     */
    public function loadUserByUsername($username) {
        // create new one in db if not exists
        throw new UsernameNotFoundException(sprintf("Authentication should be handled in loadUserByOAuthUserResponse – User '%s' not found.", $username));
    }

    /**
     * Refreshes the user for the account interface.
     *
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     * @param UserInterface $user
     *
     * @return UserInterface
     *
     * @throws UnsupportedUserException if the account is not supported
     */
    public function refreshUser(UserInterface $user) {
        if (!$this->supportsClass(get_class($user))) {
            throw new UnsupportedUserException(sprintf('Unsupported user class "%s"', get_class($user)));
        }

        $username = $user->getUsername();
        $user = $this->repository->findOneBy(array('username' => $username));

        if(null === $user) {
            throw new UsernameNotFoundException(sprintf("User '%s'could not be refreshed.", $username));
        }

        return $user;
    }

    /**
     * Whether this provider supports the given user class
     *
     * @param string $class
     *
     * @return Boolean
     */
    public function supportsClass($class) {
        return $class === 'Terrific\\Composition\\Entity\\User';
    }
}