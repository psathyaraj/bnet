<?php
namespace AppBundle\Utils\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

class ApiUserProvider implements UserProviderInterface
{
	private $em;
	
	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function loadUserByUsername($username)
	{
		if($username == 'anonymous') {
			return new User(
					$username,
					null,
					array('IS_AUTHENTICATED_ANONYMOUSLY')
			);
		}
		
		return $this->em->getRepository('AppBundle:Users')->loadUserByAuthToken($token);
		
	}

	public function refreshUser(UserInterface $user)
	{
		throw new UnsupportedUserException();
	}

	public function supportsClass($class)
	{
		return ('Symfony\Component\Security\Core\User\User' === $class || 'AppBundle\Entity\CustomerReg' === $class); 
	}
}