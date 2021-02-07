<?php

namespace FoxDeveloper\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Tool\ArrayAccessorTrait;

class GiteaResourceOwner implements ResourceOwnerInterface
{
	use ArrayAccessorTrait;
	
	/**
	 * Raw response
	 * 
	 * @var array
	 */
	protected $response;

	public function __construct(array $response = [])
	{
        $this->response = $response;
	}

	/**
	 * @inheritdoc
	 */
	public function getId()
	{

        return $this->getValueByKey($this->response, 'id');
	}

	/**
	 * @inheritdoc
	 */
	public function toArray()
	{

        return $this->response;
	}
}