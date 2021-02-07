<?php


namespace FoxDeveloper\OAuth2\Client\Test\Provider;

use FoxDeveloper\OAuth2\Client\Provider\Gitea;
use League\OAuth2\Client\Tool\QueryBuilderTrait;
use PHPUnit\Framework\TestCase;
use Mockery as m;

class GiteaTest extends TestCase
{
	use QueryBuilderTrait;

	protected $provider;

	protected function setUp(): void
	{
		$this->provider = new Gitea([
			'clientId' => 'mock_client_id',
			'clientSecret' => 'mock_client_secret',
			'redirectUri' => 'none',
		]);
	}


	public function tearDown(): void
	{
		m::close();
        parent::tearDown();
	}

	public function testAuthorizationUrl()
	{

        $this->assertTrue(false);
	}
}