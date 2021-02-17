<?php

/*
 * Gitea OAuth2 Provider
 * (c) Benjamin Gaudé <dev@foxdeveloper.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FoxDeveloper\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Tool\ArrayAccessorTrait;

/**
 * GiteaResourceOwner.
 *
 * @author Benjamin Gaudé <dev@foxdeveloper.io>
 */
class GiteaResourceOwner implements ResourceOwnerInterface
{
    use ArrayAccessorTrait;

    /**
     * Raw response.
     *
     * @var array
     */
    protected $response;

    /**
     * Creates new resource owner.
     */
    public function __construct(array $response = [])
    {
        $this->response = $response;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getValueByKey($this->response, 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return $this->response;
    }

    /**
     * Get the username.
     */
    public function getUsername(): string
    {
        return $this->getValueByKey($this->response, 'username');
    }

    /**
     * Get the fullname.
     */
    public function getFullname(): string
    {
        return $this->getValueByKey($this->response, 'full_name');
    }

    /**
     * User is an admin ?
     */
    public function isAdmin(): bool
    {
        return $this->getValueByKey($this->response, 'is_admin');
    }

    /**
     * Get the user  email.
     */
    public function getEmail(): string
    {
        return $this->getValueByKey($this->response, 'email');
    }

    /**
     * Get the login.
     */
    public function getLogin(): string
    {
        return $this->getValueByKey($this->response, 'login');
    }

    /**
     * Get the user avatar URL.
     */
    public function getAvatarURL(): ?string
    {
        return $this->getValueByKey($this->response, 'avatar_url');
    }
}
