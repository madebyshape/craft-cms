<?php

namespace LitEmoji;

class LitEmoji
{
    const MB_REGEX = '/(
    		     \x23\xE2\x83\xA3               # Digits
    		     [\x30-\x39]\xE2\x83\xA3
    		   | \xF0\x9F[\x85-\x88][\xA6-\xBF] # Enclosed characters
    		   | \xF0\x9F[\x8C-\x97][\x80-\xBF] # Misc
    		   | \xF0\x9F\x98[\x80-\xBF]        # Smilies
    		   | \xF0\x9F\x99[\x80-\x8F]
    		   | \xF0\x9F\x9A[\x80-\xBF]        # Transport and map symbols
    		)/x';

    private static $shortcodes = [];
    private static $shortcodeCodepoints = [];
    private static $shortcodeEntities = [];
    private static $entityCodepoints = [];
    private static $excludedShortcodes = [];

    /**
     * Converts all unicode emoji and HTML entities to plaintext shortcodes.
     *
     * @param string $content
     * @return string
     */
    public static function encodeShortcode($content)
    {
        $content = self::entitiesToUnicode($content);
        $content = self::unicodeToShortcode($content);

        return $content;
    }

    /**
     * Converts all plaintext shortcodes and unicode emoji to HTML entities.
     *
     * @param string $content
     * @return string
     */
    public static function encodeHtml($content)
    {
        $content = self::unicodeToShortcode($content);
        $content = self::shortcodeToEntities($content);

        return $content;
    }

    /**
     * Converts all plaintext shortcodes and HTML entities to unicode codepoints.
     *
     * @param string $content
     * @return string
     */
    public static function encodeUnicode($content)
    {
        $content = self::shortcodeToUnicode($content);
        $content = self::entitiesToUnicode($content);

        return $content;
    }

    /**
     * Converts plaintext shortcodes to HTML entities.
     *
     * @param string $content
     * @return string
     */
    public static function shortcodeToUnicode($content)
    {
        $replacements = self::getShortcodeCodepoints();
        return str_replace(array_keys($replacements), $replacements, $content);
    }

    /**
     * Converts HTML entities to unicode codepoints.
     *
     * @param string $content
     * @return string
     */
    public static function entitiesToUnicode($content)
    {
        /* Convert HTML entities to uppercase hexadecimal */
        $content = preg_replace_callback('/\&\#(x?[a-zA-Z0-9]*?)\;/', function($matches) {
            $code = $matches[1];

            if ($code[0] == 'x') {
                return '&#x' . strtoupper(substr($code, 1)) . ';';
            }

            return '&#x' . strtoupper(dechex($code)) . ';';
        }, $content);

        $replacements = self::getEntityCodepoints();
        return str_replace(array_keys($replacements), $replacements, $content);
    }

    /**
     * Converts unicode codepoints to plaintext shortcodes.
     *
     * @param string $content
     * @return string
     */
    public static function unicodeToShortcode($content)
    {
        $replacement = '';
        $encoding = mb_detect_encoding($content);
        $codepoints = array_flip(self::getShortcodes());

        /* Break content along codepoint boundaries */
        $parts = preg_split(
            self::MB_REGEX,
            $content,
            -1,
            PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY
        );

        /* Reconstruct content using shortcodes */
        $sequence = [];
        foreach ($parts as $offset => $part) {
            if (preg_match(self::MB_REGEX, $part)) {
                $part = mb_convert_encoding($part, 'UTF-32', $encoding);
                $words = unpack('N*', $part);
                $codepoint = sprintf('%X', reset($words));

                $sequence[] = $codepoint;

                if (isset($codepoints[$codepoint])) {
                    $replacement .= ":$codepoints[$codepoint]:";
                    $sequence = [];
                } else {
                    /* Check multi-codepoint sequence */
                    $multi = implode('-', $sequence);

                    if (isset($codepoints[$multi])) {
                        $replacement .= ":$codepoints[$multi]:";
                        $sequence = [];
                    }
                }
            } else {
                $replacement .= $part;
            }
        }

        return $replacement;
    }

    /**
     * Converts plain text shortcodes to HTML entities.
     *
     * @param string $content
     * @return string
     */
    public static function shortcodeToEntities($content) {
        $replacements = self::getShortcodeEntities();
        return str_replace(array_keys($replacements), $replacements, $content);
    }

    /**
     * Sets a configuration property.
     *
     * @param string $property
     * @param mixed $value
     */
    public static function config($property, $value)
    {
        switch ($property) {
            case 'excludeShortcodes':
                self::$excludedShortcodes = [];

                if (!is_array($value)) {
                    $value = [$value];
                }

                foreach ($value as $code) {
                    if (is_string($code)) {
                        self::$excludedShortcodes[] = $code;
                    }
                }

                // Invalidate shortcode cache
                self::$shortcodes = [];
                break;
        }
    }

    private static function getShortcodes()
    {
        if (!empty(self::$shortcodes)) {
            return self::$shortcodes;
        }

        // Skip excluded shortcodes
        self::$shortcodes = array_filter(require(__DIR__ . '/shortcodes-array.php'), function($code) {
            return !in_array($code, self::$excludedShortcodes);
        }, ARRAY_FILTER_USE_KEY);

        return self::$shortcodes;
    }

    private static function getShortcodeCodepoints()
    {
        if (!empty(self::$shortcodeCodepoints)) {
            return self::$shortcodeCodepoints;
        }

        foreach (self::getShortcodes() as $shortcode => $codepoint) {
            $parts = explode('-', $codepoint);
            $codepoint = '';

            foreach ($parts as $part) {
                $codepoint .= mb_convert_encoding(pack('N', hexdec($part)), 'UTF-8', 'UTF-32');
            }

            self::$shortcodeCodepoints[':' . $shortcode . ':'] = $codepoint;
        }

        return self::$shortcodeCodepoints;
    }

    private static function getEntityCodepoints()
    {
        if (!empty(self::$entityCodepoints)) {
            return self::$entityCodepoints;
        }

        foreach (self::getShortcodes() as $shortcode => $codepoint) {
            $parts = explode('-', $codepoint);
            $entity = '';
            $codepoint = '';

            foreach ($parts as $part) {
                $entity .= '&#x' . $part . ';';
                $codepoint .= mb_convert_encoding(pack('N', hexdec($part)), 'UTF-8', 'UTF-32');
            }

            self::$entityCodepoints[$entity] = $codepoint;
        }

        return self::$entityCodepoints;
    }

    private static function getShortcodeEntities()
    {
        if (!empty(self::$shortcodeEntities)) {
            return self::$shortcodeEntities;
        }

        foreach (self::getShortcodes() as $shortcode => $codepoint) {
            $parts = explode('-', $codepoint);
            self::$shortcodeEntities[':' . $shortcode . ':'] = '';

            foreach ($parts as $part) {
                self::$shortcodeEntities[':' . $shortcode . ':'] .= '&#x' . $part .';';
            }
        }

        return self::$shortcodeEntities;
    }
}
