<?php

declare(strict_types=1);

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
    protected int $applicationId = 0;
    protected string $name = '';
    protected ApplicationStatus $status;
    protected array $packages = [];
    protected array $repositories = [];
    protected array $tags = [];

    public function __construct()
    {
        $this->status = ApplicationStatus::UNKNOWN;
    }

    public function getApplicationId(): int
    {
        return $this->applicationId;
    }

    public function setApplicationId(int $applicationId): Report
    {
        $this->applicationId = $applicationId;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Report
    {
        $this->name = $name;

        return $this;
    }

    public function getStatus(): ApplicationStatus
    {
        return $this->status;
    }

    public function setStatus(ApplicationStatus $status): Report
    {
        $this->status = $status;

        return $this;
    }

    public function getPackages(): array
    {
        return $this->packages;
    }

    public function setPackages(array $packages): Report
    {
        $this->packages = $packages;

        return $this;
    }

    public function getRepositories(): array
    {
        return $this->repositories;
    }

    public function setRepositories(array $repositories): Report
    {
        $this->repositories = $repositories;

        return $this;
    }
}
