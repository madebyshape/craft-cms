# Craft ID Provider for OAuth 2.0 Client

This package provides Craft ID OAuth 2.0 support for the PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

This package is compliant with [PSR-1][], [PSR-2][] and [PSR-4][]. If you notice compliance oversights, please send
a patch via pull request.

[PSR-1]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md
[PSR-2]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md
[PSR-4]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md

## Requirements

The following versions of PHP are supported.

* PHP 5.6
* PHP 7.0
* PHP 7.1
* HHVM

## Installation

To install, use composer:

```
composer require craftcms/oauth2-craftid
```

## Usage

### Authorization Code Flow

```php
$provider = new \craftcms\oauth2\client\provider\CraftId([
    'clientId'     => '{craft-app-id}',
    'clientSecret' => '{craft-app-secret}',
    'redirectUri'  => 'https://example.com/callback-url',
]);

if (!empty($_GET['error'])) {

    // Got an error, probably user denied access
    exit('Got error: ' . htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'));

} elseif (empty($_GET['code'])) {

    // If we don't have an authorization code then get one
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: ' . $authUrl);
    exit;

} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

    // State is invalid, possible CSRF attack in progress
    unset($_SESSION['oauth2state']);
    exit('Invalid state');

} else {

    // Try to get an access token (using the authorization code grant)
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    // Optional: Now you have a token you can look up a users profile data
    try {

        // We got an access token, let's now get the owner details
        $ownerDetails = $provider->getResourceOwner($token);

        // Use these details to create a new profile
        printf('Hello %s!', $ownerDetails->getName());

    } catch (Exception $e) {

        // Failed to get user details
        exit('Something went wrong: ' . $e->getMessage());

    }

    // Use this to interact with an API on the users behalf
    echo $token->getToken();

    // Use this to get a new access token if the old one expires
    echo $token->getRefreshToken();

    // Number of seconds until the access token will expire, and need refreshing
    echo $token->getExpires();
}
```

## Scopes

If needed, you can include an array of scopes when getting the authorization url. Example:

```
$authorizationUrl = $provider->getAuthorizationUrl([
    'scope' => [
        'purchasePlugins',
        'existingPlugins',
        'transferPluginLicense',
        'deassociatePluginLicense',
    ]
]);
header('Location: ' . $authorizationUrl);
exit;
```

## Testing

``` bash
$ ./vendor/bin/phpunit
```

## Credits

- [Pixel & Tonic](https://pixelandtonic.com/)
- [All Contributors](https://github.com/craftcms/oauth2-craftid/contributors)


## License

The MIT License (MIT). Please see [License File](https://github.com/craftcms/oauth2-craftid/blob/master/LICENSE.md) for more information.
