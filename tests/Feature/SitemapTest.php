<?php

namespace Tests\Feature;

use Tests\TestCase;

class SitemapTest extends TestCase
{
    public function test_sitemap_xml_exists()
    {
        $response = $this->get('/sitemap.xml');
        $response->assertOk();
        
        $this->assertStringContainsString('<?xml', $response->body, 'Sitemap should be valid XML');
    }

    public function test_all_sitemap_urls_are_accessible()
    {
        $response = $this->get('/sitemap.xml');
        $response->assertOk();
        
        // Parse all URLs from nested sitemaps
        $urls = $this->parseAllSitemapUrls($response->body);
        
        $this->assertNotEmpty($urls, 'Sitemap should contain at least one URL');
        
        // Test each URL from the sitemap
        foreach ($urls as $url) {
            $pageResponse = $this->get($url);
            $pageResponse->assertOk();
            
            // Additional assertion to ensure we got a response
            $this->assertNotEmpty($pageResponse->body, "Response body should not be empty for {$url}");
        }
    }

    public function test_sitemap_urls_have_h1_tags()
    {
        $response = $this->get('/sitemap.xml');
        $response->assertOk();
        
        $urls = $this->parseAllSitemapUrls($response->body);
        
        foreach ($urls as $url) {
            $pageResponse = $this->get($url);
            $pageResponse->assertOk();
            
            // Check for H1 tag
            $this->assertStringContainsString('<h1', $pageResponse->body, "Page {$url} should have an H1 tag");
            $this->assertStringContainsString('</h1>', $pageResponse->body, "Page {$url} should have a closing H1 tag");
            
            // Check that H1 has content
            preg_match_all('/<h1[^>]*>(.*?)<\/h1>/i', $pageResponse->body, $matches);
            if (!empty($matches[1])) {
                foreach ($matches[1] as $index => $content) {
                    $trimmedContent = trim(strip_tags($content));
                    $this->assertNotEmpty($trimmedContent, "Page {$url} H1 tag #{$index} should have content");
                }
            }
        }
    }

    /**
     * Parse all URLs from nested sitemaps
     */
    private function parseAllSitemapUrls(string $mainSitemapContent): array
    {
        $allUrls = [];
        
        // First, check if this is a sitemap index (contains nested sitemaps)
        if (strpos($mainSitemapContent, '<sitemap>') !== false) {
            // This is a sitemap index, parse nested sitemaps
            $nestedSitemaps = $this->parseNestedSitemaps($mainSitemapContent);
            
            foreach ($nestedSitemaps as $sitemapUrl) {
                $sitemapResponse = $this->get($sitemapUrl);
                if ($sitemapResponse->status === 200) {
                    $urls = $this->parseSitemapUrls($sitemapResponse->body);
                    $allUrls = array_merge($allUrls, $urls);
                }
            }
        } else {
            // This is a regular sitemap, parse URLs directly
            $allUrls = $this->parseSitemapUrls($mainSitemapContent);
        }
        
        return $allUrls;
    }

    /**
     * Parse nested sitemap URLs from sitemap index
     */
    private function parseNestedSitemaps(string $sitemapIndexContent): array
    {
        $sitemaps = [];
        
        // Extract sitemap URLs from sitemap index
        preg_match_all('/<sitemap>.*?<loc>(.*?)<\/loc>.*?<\/sitemap>/is', $sitemapIndexContent, $matches);
        
        if (isset($matches[1])) {
            foreach ($matches[1] as $sitemapUrl) {
                $sitemapUrl = trim($sitemapUrl);
                
                // Convert full URLs to relative paths for testing
                $baseUrl = $_ENV['PRIMARY_SITE_URL'] ?? 'http://localhost:8080';
                if (strpos($sitemapUrl, $baseUrl) === 0) {
                    $relativeUrl = substr($sitemapUrl, strlen($baseUrl));
                    $sitemaps[] = $relativeUrl;
                } else {
                    // If it's already a relative URL, use it as is
                    $sitemaps[] = $sitemapUrl;
                }
            }
        }
        
        return $sitemaps;
    }

    /**
     * Parse URLs from individual sitemap XML content
     */
    private function parseSitemapUrls(string $sitemapContent): array
    {
        $urls = [];
        
        // Simple regex to extract URLs from sitemap
        preg_match_all('/<loc>(.*?)<\/loc>/i', $sitemapContent, $matches);
        
        if (isset($matches[1])) {
            foreach ($matches[1] as $url) {
                $url = trim($url);
                
                // Convert full URLs to relative paths for testing
                $baseUrl = $_ENV['PRIMARY_SITE_URL'] ?? 'http://localhost:8080';
                if (strpos($url, $baseUrl) === 0) {
                    $relativeUrl = substr($url, strlen($baseUrl));
                    $urls[] = $relativeUrl;
                } else {
                    // If it's already a relative URL, use it as is
                    $urls[] = $url;
                }
            }
        }
        
        return $urls;
    }
} 