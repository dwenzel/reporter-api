<?php

namespace DWenzel\ReporterApi\Schema;

use DWenzel\ReporterApi\Traits\JsonSerialize;
use DWenzel\ReporterApi\Traits\ToArray;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2019 Dirk Wenzel <wenzel@cps-it.de>
 *  All rights reserved
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the text file GPL.txt and important notices to the license
 * from the author is found in LICENSE.txt distributed with these scripts.
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
class Package
{
    use ToArray, JsonSerialize;

    const SERIALIZABLE_PROPERTIES = [
        'name',
        'version',
        'type',
        'sourceReference',
        'source'
    ];
    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var string
     */
    protected $version = '';

    /**
     * @var string
     */
    protected $type = '';

    /**
     * @var string
     */
    protected $sourceReference = '';

    /**
     * @var PackageSource
     */
    protected $source;

    public function __construct(
        string $name = '',
        string $version = '',
        string $sourceReference = '',
        PackageSource $source = null
    )
    {
        $this->name = $name;
        $this->version = $version;
        $this->sourceReference = $sourceReference;
        $this->source = ($source) ? $source : new NullPackageSource();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return PackageSource
     */
    public function getSource(): PackageSource
    {
        return $this->source;
    }

    /**
     * @param PackageSource $source
     */
    public function setSource(PackageSource $source): void
    {
        $this->source = $source;
    }

    /**
     * @return string
     */
    public function getSourceReference(): string
    {
        return $this->sourceReference;
    }

    /**
     * @param string $sourceReference
     */
    public function setSourceReference(string $sourceReference): void
    {
        $this->sourceReference = $sourceReference;
    }
}
