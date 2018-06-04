<?php

namespace craftcms\oauth2\client\test\provider;

use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use PHPUnit_Framework_TestCase;
use Eloquent\Phony\Phpunit\Phony;
use craftcms\oauth2\client\provider\CraftId;
use League\OAuth2\Client\Token\AccessToken;

class CraftIdTest extends PHPUnit_Framework_TestCase
{
    protected $provider;

    protected function setUp()
    {
        $this->provider = new CraftId([
            'clientId' => 'mock_client_id',
            'clientSecret' => 'mock_secret',
            'redirectUri' => 'none',
        ]);
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

        $this->assertContains('purchasePlugins', $query['scope']);
        $this->assertContains('existingPlugins', $query['scope']);
        $this->assertContains('transferPluginLicense', $query['scope']);
        $this->assertContains('deassociatePluginLicense', $query['scope']);

        $this->assertAttributeNotEmpty('state', $this->provider);
    }

    public function testBaseAccessTokenUrl()
    {
        $url = $this->provider->getBaseAccessTokenUrl([]);
        $uri = parse_url($url);
        $this->assertEquals('/oauth/token', $uri['path']);
    }

    public function testResourceOwnerDetailsUrl()
    {
        $token = $this->mockAccessToken();
        $url = $this->provider->getResourceOwnerDetailsUrl($token);
        $uri = parse_url($url);
        $this->assertEquals('/api/account', $uri['path']);
        $this->assertNotContains('mock_access_token', $url);
    }

    public function testUserData()
    {
        // Mock
        $response = json_decode('{"id": "12345","name": "mock_name", "email": "mock_email", "purchasedPlugins": []}', true);
        $token = $this->mockAccessToken();
        $provider = Phony::partialMock(CraftId::class);
        $provider->fetchResourceOwnerDetails->returns($response);
        $craft = $provider->get();
        // Execute
        $user = $craft->getResourceOwner($token);
        // Verify
        Phony::inOrder(
            $provider->fetchResourceOwnerDetails->called()
        );
        $this->assertInstanceOf('League\OAuth2\Client\Provider\ResourceOwnerInterface', $user);
        $this->assertEquals(12345, $user->getId());
        $this->assertEquals('mock_name', $user->getName());
        $this->assertEquals('mock_email', $user->getEmail());
        $user = $user->toArray();
        $this->assertArrayHasKey('id', $user);
        $this->assertArrayHasKey('name', $user);
        $this->assertArrayHasKey('email', $user);
        $this->assertArrayHasKey('purchasedPlugins', $user);
    }

    public function testErrorResponse()
    {
        // Mock
        $error_json = '{"error": {"code": 400, "message": "I am an error"}}';
        $response = Phony::mock('GuzzleHttp\Psr7\Response');
        $response->getHeader->returns(['application/json']);
        $response->getBody->returns($error_json);
        $provider = Phony::partialMock(CraftId::class);
        $provider->getResponse->returns($response);
        $craftId = $provider->get();
        $token = $this->mockAccessToken();

        // Expect
        $this->expectException(IdentityProviderException::class);

        // Execute
        $user = $craftId->getResourceOwner($token);

        // Verify
        Phony::inOrder(
            $provider->getResponse->calledWith($this->instanceOf('GuzzleHttp\Psr7\Request')),
            $response->getHeader->called(),
            $response->getBody->called()
        );
    }

    public function testEmptyErrorResponse()
    {
        // Mock
        $error_json = '{}';
        $response = Phony::mock('GuzzleHttp\Psr7\Response');
        $response->getHeader->returns(['application/json']);
        $response->getBody->returns($error_json);
        $provider = Phony::partialMock(CraftId::class);
        $provider->getResponse->returns($response);
        $craftId = $provider->get();
        $token = $this->mockAccessToken();

        // Expect
        $this->expectException(IdentityProviderException::class);

        // Execute
        $user = $craftId->getResourceOwner($token);

        // Verify
        Phony::inOrder(
            $provider->getResponse->calledWith($this->instanceOf('GuzzleHttp\Psr7\Request')),
            $response->getHeader->called(),
            $response->getBody->called()
        );
    }

    /**
     * @return AccessToken
     */
    private function mockAccessToken()
    {
        return new AccessToken([
            'access_token' => 'mock_access_token',
        ]);
    }
}