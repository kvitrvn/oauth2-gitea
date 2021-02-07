<?php
/*
 * Gitea OAuth2 Provider
 * (c) Benjamin Gaudé <dev@foxdeveloper.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FoxDeveloper\OAuth2\Client\Test\Provider;

use FoxDeveloper\OAuth2\Client\Provider\Gitea;
use GuzzleHttp\ClientInterface;
use League\OAuth2\Client\Tool\QueryBuilderTrait;
use PHPUnit\Framework\TestCase;
use Mockery as m;
use Mockery\MockInterface;

/**
 * GiteaTest.
 * 
 * @author Benjamin Gaudé <dev@foxdeveloper.io>
 */
class GiteaTest extends TestCase
{
	use QueryBuilderTrait;

	/** @var Gitea */
	protected $provider;

	protected function setUp(): void
	{
		$this->provider = new Gitea([
			'clientId' => 'mock_client_id',
			'clientSecret' => 'mock_client_secret',
			'redirectUri' => 'none',
			'baseUrl' => 'https://gitea.example.com',
		]);
	}


	public function tearDown(): void
	{
		m::close();
        parent::tearDown();
	}

	public function testAuthorizationUrl()
	{
		$url = $this->provider->getAuthorizationUrl();
        $uri = parse_url($url);
		parse_str($uri['query'], $query);
		
		$this->assertArrayHasKey('client_id', $query);
        $this->assertArrayHasKey('redirect_uri', $query);
        $this->assertArrayHasKey('state', $query);
        $this->assertArrayHasKey('scope', $query);
        $this->assertArrayHasKey('response_type', $query);
        $this->assertArrayHasKey('approval_prompt', $query);
        $this->assertNotNull($this->provider->getState());
	}

	public function testScopes()
    {
        $options = ['scope' => [uniqid(), uniqid()]];

		$url = $this->provider->getAuthorizationUrl($options);
		
		$this->assertStringContainsString(rawurlencode(implode(',', $options['scope'])), $url);
    }

    public function testGetAuthorizationUrl()
    {
        $url = $this->provider->getAuthorizationUrl();
        $uri = parse_url($url);

        $this->assertEquals('/login/oauth/authorize', $uri['path']);
    }

    public function testGetBaseAccessTokenUrl()
    {
        $params = [];

        $url = $this->provider->getBaseAccessTokenUrl($params);
        $uri = parse_url($url);

        $this->assertEquals('/login/oauth/access_token', $uri['path']);
    }

    public function testGetAccessToken()
    {
		/** @var MockInterface */
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->andReturn('{"access_token":"mock_access_token", "scope":"repo,gist", "token_type":"bearer"}');
        $response->shouldReceive('getHeader')->andReturn(['content-type' => 'json']);
        $response->shouldReceive('getStatusCode')->andReturn(200);

		/** @var MockInterface|ClientInterface */
        $client = m::mock('GuzzleHttp\ClientInterface');
        $client->shouldReceive('send')->times(1)->andReturn($response);
        $this->provider->setHttpClient($client);

        $token = $this->provider->getAccessToken('authorization_code', ['code' => 'mock_authorization_code']);

        $this->assertEquals('mock_access_token', $token->getToken());
        $this->assertNull($token->getExpires());
        $this->assertNull($token->getRefreshToken());
    }
}