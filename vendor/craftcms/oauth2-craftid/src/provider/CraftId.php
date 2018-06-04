<?php

namespace craftcms\oauth2\client\provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

class CraftId extends AbstractProvider
{
    use BearerAuthorizationTrait;

    const ACCESS_TOKEN_RESOURCE_OWNER_ID = 'id';
    
    public $oauthEndpointUrl = 'https://api.craftcms.com/oauth';

    public $apiEndpointUrl = 'https://api.craftcms.com';

    public function getBaseAuthorizationUrl()
    {
        return $this->oauthEndpointUrl.'/authorize';
    }

    public function getBaseAccessTokenUrl(array $params)
    {
        return $this->oauthEndpointUrl.'/access-token';
    }

    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return $this->apiEndpointUrl.'/api/account';
    }

    protected function getDefaultScopes()
    {
        return [
            'purchasePlugins',
            'existingPlugins',
            'transferPluginLicense',
            'deassociatePluginLicense',
        ];
    }

    protected function getScopeSeparator()
    {
        return ' ';
    }

    protected function checkResponse(ResponseInterface $response, $data)
    {
        if (!empty($data['error'])) {
            $code  = 0;
            $error = $data['error'];

            if (is_array($error)) {
                $code  = $error['code'];
                $error = $error['message'];
            }

            throw new IdentityProviderException($error, $code, $data);
        }
    }

    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new CraftIdUser($response);
    }
}
