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
class Report implements \JsonSerializable
{
    use ToArray;
    use JsonSerialize;

    public const SERIALIZABLE_PROPERTIES = [
        'applicationId',
        'name',
        'status' ,
        'packages' ,
        'repositories' ,
        'tags',
    ];
    protected $applicationId = 0;
    protected $name = '';

    /**
     * @var ApplicationStatus
     */
    protected $status;
    protected $packages = [];
    protected $repositories = [];
    protected $tags = [];

    public function __construct()
    {
        $this->status = new ApplicationStatus(ApplicationStatus::UNKNOWN);
    }

    /**
     * @return int
     */
    public function getApplicationId(): int
    {
        return $this->applicationId;
    }

    /**
     * @param int $applicationId
     */
    public function setApplicationId(int $applicationId): Report
    {
        $this->applicationId = $applicationId;

        return $this;
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
     * @return Report
     */
    public function setName(string $name): Report
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return
     */
    public function getStatus(): ApplicationStatus
    {
        return $this->status;
    }

    /**
     * @param ApplicationStatus $status
     * @return Report
     */
    public function setStatus(ApplicationStatus $status): Report
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return array
     */
    public function getPackages(): array
    {
        return $this->packages;
    }

    /**
     * @param array $packages
     * @return Report
     */
    public function setPackages(array $packages): Report
    {
        $this->packages = $packages;

        return $this;
    }

    /**
     * @return array
     */
    public function getRepositories(): array
    {
        return $this->repositories;
    }

    /**
     * @param array $repositories
     * @return Report
     */
    public function setRepositories(array $repositories): Report
    {
        $this->repositories = $repositories;

        return $this;
    }
}
