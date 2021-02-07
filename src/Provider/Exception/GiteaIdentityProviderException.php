<?php


namespace FoxDeveloper\OAuth2\Client\Provider\Exception;

use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Psr\Http\Message\ResponseInterface;

final class GiteaIdentityProviderException extends IdentityProviderException
{
	public static function clientException(ResponseInterface $response, $data)
	{
		return static::fromResponse(
			$response,
			isset($data['message']) ?: $response->getReasonPhrase()
		);
	}


	public static function oauthException(ResponseInterface $response, $data)
	{
		return static::fromResponse(
            $response,
            isset($data['error']) ?: $response->getReasonPhrase()
        );
	}

	protected static function fromResponse(ResponseInterface $response, $message = null)
    {
        return new static($message, $response->getStatusCode(), (string) $response->getBody());
    }
}