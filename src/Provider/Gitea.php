<?php


namespace FoxDeveloper\OAuth2\Client\Provider;

use FoxDeveloper\OAuth2\Client\Provider\Exception\GiteaIdentityProviderException;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

class Gitea extends AbstractProvider
{
	use BearerAuthorizationTrait;

	public $baseUrl;


	public function __construct(array $params)
	{
		parent::__construct($params);
        $this->baseUrl = $params['baseUrl'];
	}
	
	public function getBaseUrl(): string
	{

        return $this->baseUrl;
	}

	/**
	 * @inheritdoc
	 */
	public function getBaseAuthorizationUrl()
	{

        return $this->getBaseUrl().'/login/oauth/authorize';
	}

	/**
	 * @inheritdoc
	 */
	public function getBaseAccessTokenUrl(array $params)
	{
		

        return $this->getBaseUrl().'/login/oauth/access_token';
	}

	/**
	 * @inheritdoc
	 */
	public function getResourceOwnerDetailsUrl(AccessToken $token)
	{
		return $this->getBaseUrl().'/api/v1/user';
		
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
        if ($response->getStatusCode() >= 400) {
            throw GiteaIdentityProviderException::clientException($response, $data);
        } elseif (isset($data['error'])) {
            throw GiteaIdentityProviderException::oauthException($response, $data);
        }
		
	}

	/**
	 * @inheritdoc
	 */
	protected function createResourceOwner(array $response, AccessToken $token)
	{
        $user = new GiteaResourceOwner($response);

        return $user;
		
	}
}