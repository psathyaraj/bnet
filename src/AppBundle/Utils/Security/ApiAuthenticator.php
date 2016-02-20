<?php 
namespace AppBundle\Utils\Security;

use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use AppBundle\Utils\Security\ApiUserProvider;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiAuthenticator implements SimplePreAuthenticatorInterface
{
	protected $userProvider;
	protected $em;
	protected $container;

	public function __construct(ApiUserProvider $userProvider, EntityManager $em, ContainerInterface $container)
	{
		$this->userProvider = $userProvider;
		$this->em = $em;
		$this->container = $container;
	}

	public function createToken(Request $request, $providerKey)
	{
		if(strpos($request->get("_route"), 'nelmio_api_doc_index') !== false) {
			$token = "anonymous";
		}else{
			
			$token = $request->headers->get('Token');
			
			
			if (!isset($token)) {
				$token = "anonymous";
			}
			
		}
		
		return new PreAuthenticatedToken(
				'anon.',
				$token,
				$providerKey
		);
	}

	public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
	{
		$apiKey = $token->getCredentials();

		$user = $this->userProvider->loadUserByUsername($apiKey);

		return new PreAuthenticatedToken(
				$user,
				$apiKey,
				$providerKey,
				$user->getRoles()
		);
	}

	public function supportsToken(TokenInterface $token, $providerKey)
	{
		return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
	}
	
	public function generateSignature($privateKey, $timeStamp)
	{
		return urlencode(base64_encode(hash_hmac('sha256', $timeStamp.$privateKey, $privateKey, true)));
	}
}