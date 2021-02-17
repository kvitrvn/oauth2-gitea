# Gitea Provider for OAuth 2.0 Client

![SymfonyInsight](https://insight.symfony.com/projects/e32f86e6-2312-4ec1-ac21-adb7d2fb6f33/mini.svg)

This package provides Gitea OAuth 2.0 support for the PHP League's OAuth 2.0 Client.

## Installation

To install, use composer:

```shell
composer require foxdeveloper/oauth2-gitea
```

## Usage

Usage is the same as The League's OAuth client, using `\FoxDeveloper\OAuth2\Client\Provider\Gitea` as the provider.

```php
use FoxDeveloper\OAuth2\Client\Provider\Gitea;
use FoxDeveloper\OAuth2\Client\Provider\GiteaResourceOwner;

$provider = new Gitea([
    'clientId' => '{GITEA_CLIENT_ID}',
    'clientSecret' => '{GITEA_CLIENT_SECRET}',
    'redirectUri' => 'https://example.com/callback-url',
    'baseUrl' => '{GITEA_BASE_URL}',
]);

if (!isset($_GET['code'])) {

    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: '.$authUrl);
    exit();

} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

    unset($_SESSION['oauth2state']);
    exit('Invalid state');

} else {

    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code'],
    ]);

    try {
        /** @var GiteaResourceOwner */
        $user = $provider->getResourceOwner($token);

        printf('Hello %s!', $user->getLogin());
    } catch (\Exception $e) {
        exit('Oh dear...');
    }

    echo $token->getToken();
}
```

## Testing
```shell
./vendor/bin/phpunit
```

## Credits
- [Benjamin Gaudé](https://github.com/foxdeveloper)

## License
The MIT License (MIT). Please see [License File](./LICENSE.md) for more information.
