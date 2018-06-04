<?php

namespace LitEmoji;

class LitEmojiTest extends \PHPUnit_Framework_TestCase
{
    public function testUnicodeToShortcode()
    {
        $text = LitEmoji::encodeShortcode('My mixtape is 🔥. Made in 🇦🇺!');
        $this->assertEquals('My mixtape is :fire:. Made in :flag-au:!', $text);
    }

    public function testHtmlToShortcode()
    {
        $text = LitEmoji::encodeShortcode('My mixtape is &#x1F525;. Made in &#x1F1E6;&#x1F1FA;!');
        $this->assertEquals('My mixtape is :fire:. Made in :flag-au:!', $text);
    }

    public function testShortcodeToHtml()
    {
        $text = LitEmoji::encodeHtml('My mixtape is :fire:. Made in :flag-au:!');
        $this->assertEquals('My mixtape is &#x1F525;. Made in &#x1F1E6;&#x1F1FA;!', $text);
    }

    public function testUnicodeToHtml()
    {
        $text = LitEmoji::encodeHtml('My mixtape is 🔥. Made in 🇦🇺!');
        $this->assertEquals('My mixtape is &#x1F525;. Made in &#x1F1E6;&#x1F1FA;!', $text);
    }

    public function testShortcodeToUnicode()
    {
        $text = LitEmoji::encodeUnicode('My mixtape is :fire:. Made in :flag-au:!');
        $this->assertEquals('My mixtape is 🔥. Made in 🇦🇺!', $text);
    }

    public function testHtmlToUnicode()
    {
        $text = LitEmoji::encodeUnicode('My mixtape is &#x1f525;. Made in &#x1f1e6;&#x1f1fa;!');
        $this->assertEquals('My mixtape is 🔥. Made in 🇦🇺!', $text);
    }

    public function testUnicodeToShortcodeTiming()
    {
        $text = LitEmoji::encodeShortcode(file_get_contents(__DIR__ . '/UnicodeIpsum'));
        $this->assertEquals(file_get_contents(__DIR__ . '/ShortcodeIpsum'), $text);
    }

    public function testConfigExcludeShortcodes()
    {
        LitEmoji::config('excludeShortcodes', ['mobile', 'android']);
        $this->assertEquals(':iphone:', LitEmoji::encodeShortcode('📱'));
    }
}
