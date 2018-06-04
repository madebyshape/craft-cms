<?php
/**
 * These are the default Craft requirements for [RequirementsChecker]] to use.
 */

/** @var RequirementsChecker $this */
$requirements = array(
    array(
        'name' => 'PHP 7.0+',
        'mandatory' => true,
        'condition' => version_compare(PHP_VERSION, '7.0.0', '>='),
        'memo' => 'PHP 7.0 or higher is required.',
    ),
);

$conn = $this->getDbConnection();

switch ($this->dbDriver) {
    case 'mysql':
        $requirements[] = array(
            'name' => 'PDO MySQL extension',
            'mandatory' => true,
            'condition' => extension_loaded('pdo_mysql'),
            'memo' => 'The <http://php.net/manual/en/ref.pdo-mysql.php>PDO MySQL</a> extension is required.'
        );
        if ($conn !== false) {
            $requirements[] = array(
                'name' => "MySQL {$this->requiredMySqlVersion}+",
                'mandatory' => true,
                'condition' => $this->checkDatabaseServerVersion($conn, $this->requiredMySqlVersion),
                'memo' => "MySQL {$this->requiredMySqlVersion} or higher is required to run Craft CMS.",
            );
            $requirements[] = array(
                'name' => 'MySQL InnoDB support',
                'mandatory' => true,
                'condition' => $this->isInnoDbSupported($conn),
                'memo' => 'Craft CMS requires the MySQL InnoDB storage engine to run.',
            );
        }
        break;
    case 'pgsql':
        $requirements[] = array(
            'name' => 'PDO PostgreSQL extension',
            'mandatory' => true,
            'condition' => extension_loaded('pdo_pgsql'),
            'memo' => 'The <https://secure.php.net/manual/en/ref.pdo-pgsql.php>PDO PostgreSQL</a> extension is required.'
        );
        if ($conn !== false) {
            $requirements[] = array(
                'name' => "PostgreSQL {$this->requiredPgSqlVersion}+",
                'mandatory' => true,
                'condition' => $this->checkDatabaseServerVersion($conn, $this->requiredPgSqlVersion),
                'memo' => "PostgresSQL {$this->requiredPgSqlVersion} or higher is required to run Craft CMS.",
            );
        }
        break;
}

// Only run this requirement check if we're running in the context of Craft.
if (class_exists('Craft')) {
    $requirements[] = array(
        'name' => 'Sensitive Craft folders should not be publicly accessible',
        'mandatory' => false,
        'condition' => $this->checkWebRoot(),
        'memo' => $this->webRootFolderMessage,
    );
}

$requirements = array_merge($requirements, array(
    array(
        'name' => 'Reflection extension',
        'mandatory' => true,
        'condition' => extension_loaded('reflection'),
        'memo' => 'The <a target="_blank" href="http://php.net/manual/en/class.reflectionextension.php">Reflection</a> extension is required.',
    ),
    array(
        'name' => 'PCRE extension (with UTF-8 support)',
        'mandatory' => true,
        'condition' => extension_loaded('pcre') && preg_match('/./u', 'Ü') === 1,
        'memo' => 'The <a target="_blank" href="http://php.net/manual/en/book.pcre.php">PCRE</a> extension is required and it must be compiled to support UTF-8.',
    ),
    array(
        'name' => 'SPL extension',
        'mandatory' => true,
        'condition' => extension_loaded('SPL'),
        'memo' => 'The <a target="_blank" href="http://php.net/manual/en/book.spl.php">SPL</a> extension is required.'
    ),
    array(
        'name' => 'PDO extension',
        'mandatory' => true,
        'condition' => extension_loaded('pdo'),
        'memo' => 'The <a target="_blank" href="http://php.net/manual/en/book.pdo.php">PDO</a> extension is required.'
    ),
    array(
        'name' => 'Multibyte String extension (with Function Overloading disabled)',
        'mandatory' => true,
        'condition' => extension_loaded('mbstring') && ini_get('mbstring.func_overload') == 0,
        'memo' => 'Craft CMS requires the <a target="_blank" href="http://www.php.net/manual/en/book.mbstring.php">Multibyte String</a> extension with <a target="_blank" href="http://php.net/manual/en/mbstring.overload.php">Function Overloading</a> disabled in order to run.'
    ),
    array(
        'name' => 'GD extension or ImageMagick extension',
        'mandatory' => true,
        'condition' => extension_loaded('gd') || extension_loaded('imagick'),
        'memo' => 'The <a target="_blank" href="http://php.net/manual/en/book.image.php">GD</a> or <a target="_blank" href="http://php.net/manual/en/book.imagick.php">ImageMagick</a> extension is required, however ImageMagick is recommended as it adds animated GIF support, and preserves 8-bit and 24-bit PNGs during image transforms.'
    ),
    array(
        'name' => 'OpenSSL extension',
        'mandatory' => true,
        'condition' => extension_loaded('openssl'),
        'memo' => 'The <a target="_blank" href="http://php.net/manual/en/book.openssl.php">OpenSSL</a> extension is required.'
    ),
    array(
        'name' => 'cURL extension',
        'mandatory' => true,
        'condition' => extension_loaded('curl'),
        'memo' => 'The <a target="_blank" href="http://php.net/manual/en/book.curl.php">cURL</a> extension is required.',
    ),
    array(
        'name' => 'ini_set calls',
        'mandatory' => true,
        'condition' => $this->checkIniSet(),
        'memo' => $this->iniSetMessage,
    ),
    array(
        'name' => 'Intl extension',
        'mandatory' => false,
        'condition' => $this->checkPhpExtensionVersion('intl', '1.0.2', '>='),
        'memo' => 'The <a target="_blank" href="http://www.php.net/manual/en/book.intl.php">Intl</a> extension version 1.0.2 is highly '.
            'recommended especially if you will be using any non-English languages for this Craft CMS installation.'
    ),
    array(
        'name' => 'Fileinfo extension',
        'mandatory' => false,
        'condition' => extension_loaded('fileinfo'),
        'memo' => 'The <a target="_blank" href="http://php.net/manual/en/book.fileinfo.php">Fileinfo</a> extension is recommended for more accurate '.
            'mime-type detection for uploaded files. If it is not available a Craft CMS will fall back to determining the mime-type '.
            'by the file extension.'
    ),
    array(
        'name' => 'DOM extension',
        'mandatory' => true,
        'condition' => extension_loaded('dom'),
        'memo' => 'The <a target="_blank" href="http://php.net/manual/en/book.dom.php">DOM</a> extension is required.',
    ),
    array(
        'name' => 'iconv extension',
        'mandatory' => false,
        'condition' => function_exists('iconv'),
        'memo' => '<a target="_blank" href="http://php.net/manual/en/book.iconv.php">iconv</a> is recommended for more robust character set conversion support.',
    ),
    array(
        'name' => 'Max Upload File Size',
        'mandatory' => false,
        'condition' => true,
        'memo' => 'upload_max_filesize is set to '.ini_get('upload_max_filesize').'.',
    ),
    array(
        'name' => 'Max POST Size',
        'mandatory' => false,
        'condition' => true,
        'memo' => 'post_max_size is set to '.ini_get('post_max_size').'.',
    ),
    array(
        'name' => 'Memory Limit',
        'mandatory' => false,
        'condition' => $this->checkMemory(),
        'memo' => $this->memoryMessage,
    ),
    array(
        'name' => 'password_hash()',
        'mandatory' => true,
        'condition' => function_exists('password_hash'),
        'memo' => 'The <a target="_blank" href="https://secure.php.net/manual/en/function.password-hash.php">password_hash()</a> function is required so Craft can create secure passwords.',
    ),
    array(
        'name' => 'Zip extension',
        'mandatory' => true,
        'condition' => extension_loaded('zip'),
        'memo' => 'The <a target="_blank" href="https://secure.php.net/manual/en/book.zip.php">zip</a> extension is required for zip and unzip operations.',
    ),
));

return $requirements;
