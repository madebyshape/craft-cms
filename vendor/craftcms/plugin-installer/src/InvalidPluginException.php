<?php
/**
 * @link    https://craftcms.com/
 * @license MIT
 */

namespace craft\composer;

use Composer\Package\PackageInterface;
use Throwable;

class InvalidPluginException extends \Exception
{
    /**
     * @var PackageInterface
     */
    private $package;

    /**
     * @var string
     */
    private $error;

    /**
     * Constructor.
     *
     * @param PackageInterface $package
     * @param string           $error
     * @param Throwable|null   $previous
     */
    public function __construct(PackageInterface $package, $error = '', Throwable $previous = null)
    {
        $this->package = $package;
        $this->error = $error;

        parent::__construct("Couldn't install ".$package->getPrettyName().': '.$error, 0, $previous);
    }

    /**
     * @return PackageInterface
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }
}
