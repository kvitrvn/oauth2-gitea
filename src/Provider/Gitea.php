<?php


namespace FoxDeveloper\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

class Gitea extends AbstractProvider
{
	use BearerAuthorizationTrait;

	/**
	 * @inheritdoc
	 */
	public function getBaseAuthorizationUrl()
	{
        die('impleme me');
	}

	/**
	 * @inheritdoc
	 */
	public function getBaseAccessTokenUrl(array $params)
	{
		
        die('impleme me');
	}

	/**
	 * @inheritdoc
	 */
	public function getResourceOwnerDetailsUrl(AccessToken $token)
	{
        die('impleme me');
		
	}

	/**
	 * @inheritdoc
	 */
	protected function getDefaultScopes()
	{

        return [];
	}

	/**
	 * @inheritdoc
	 */
	protected function checkResponse(ResponseInterface $response, $data)
	{
        die('impleme me');
		
	}

	/**
	 * @inheritdoc
	 */
	protected function createResourceOwner(array $response, AccessToken $token)
	{
        die('impleme me');
		
	}
}