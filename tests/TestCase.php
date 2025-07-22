<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use craft\helpers\App;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->loadEnvironmentVariables();
    }

    /**
     * Load environment variables from .env file
     */
    protected function loadEnvironmentVariables(): void
    {
        // Load Craft's bootstrap to get environment variables
        require_once dirname(__DIR__) . '/bootstrap.php';
    }

    /**
     * Make a GET request to the given URL
     */
    protected function get(string $url, array $headers = []): TestResponse
    {
        return $this->makeRequest('GET', $url, [], $headers);
    }

    /**
     * Make a POST request to the given URL
     */
    protected function post(string $url, array $data = [], array $headers = []): TestResponse
    {
        return $this->makeRequest('POST', $url, $data, $headers);
    }

    /**
     * Make a PUT request to the given URL
     */
    protected function put(string $url, array $data = [], array $headers = []): TestResponse
    {
        return $this->makeRequest('PUT', $url, $data, $headers);
    }

    /**
     * Make a DELETE request to the given URL
     */
    protected function delete(string $url, array $headers = []): TestResponse
    {
        return $this->makeRequest('DELETE', $url, [], $headers);
    }

    /**
     * Make an HTTP request
     */
    protected function makeRequest(string $method, string $url, array $data = [], array $headers = []): TestResponse
    {
        // Get the base URL from environment or use localhost
        $baseUrl = App::env('PRIMARY_SITE_URL');
        
        if (!$baseUrl) {
            throw new \Exception('PRIMARY_SITE_URL is not set');
        }
        
        // Build the full URL
        $fullUrl = $baseUrl . $url;
        
        // Initialize cURL
        $ch = curl_init();
        
        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $fullUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        
        // Set headers
        $headerLines = [];
        foreach ($headers as $key => $value) {
            $headerLines[] = "$key: $value";
        }
        if (!empty($headerLines)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headerLines);
        }
        
        // Set data for POST/PUT requests
        if (!empty($data) && in_array($method, ['POST', 'PUT'])) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }
        
        // Execute the request
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            throw new \Exception("cURL error: $error");
        }
        
        // Parse response headers and body
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $responseHeaders = substr($response, 0, $headerSize);
        $responseBody = substr($response, $headerSize);
        
        return new TestResponse($httpCode, $responseHeaders, $responseBody);
    }
}

/**
 * Simple response class for testing
 */
class TestResponse
{
    public int $status;
    public string $headers;
    public string $body;
    
    public function __construct(int $status, string $headers, string $body)
    {
        $this->status = $status;
        $this->headers = $headers;
        $this->body = $body;
    }
    
    public function assertOk(): self
    {
        if ($this->status !== 200) {
            throw new \Exception("Expected status 200, got {$this->status}");
        }
        return $this;
    }
    
    public function assertStatus(int $status): self
    {
        if ($this->status !== $status) {
            throw new \Exception("Expected status {$status}, got {$this->status}");
        }
        return $this;
    }
    
    public function assertSee(string $text): self
    {
        if (strpos($this->body, $text) === false) {
            throw new \Exception("Expected to see '{$text}' in response");
        }
        return $this;
    }
    
    public function assertHeader(string $name, string $value): self
    {
        if (strpos($this->headers, "$name: $value") === false) {
            throw new \Exception("Expected header '{$name}: {$value}' not found");
        }
        return $this;
    }
}
