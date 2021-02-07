<?php
/*
 * Gitea OAuth2 Provider
 * (c) Benjamin Gaudé <dev@foxdeveloper.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FoxDeveloper\OAuth2\Client\Provider;

use FoxDeveloper\OAuth2\Client\Provider\Exception\GiteaIdentityProviderException;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

/**
 * Gitea.
 *
 * @author Benjamin Gaudé <dev@foxdeveloper.io>
 */
class Gitea extends AbstractProvider
{
	use BearerAuthorizationTrait;

	/**
	 * Gitea base URL 
	 * 
	 * @var string
	 */
	public $baseUrl;

	public function __construct(array $params)
	{
		parent::__construct($params);
        $this->baseUrl = $params['baseUrl'];
	}
	
	/**
	 * Get the Gitea base URL 
	 * 
	 * @return string
	 */
	public function getBaseUrl()
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