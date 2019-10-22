<?php

namespace DWenzel\ReporterApi\Schema;

use DWenzel\Reporter\Domain\Model\ApplicationStatus;

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
class Report
{
    protected $applicationId = 0;
    protected $name = '';

    /**
     * @var ApplicationStatus
     */
    protected $status;
    protected $components = [];
    protected $repositories = [];
    protected $tags = [];

    public function __construct()
    {
        $this->status = ApplicationStatus::cast(ApplicationStatus::UNKNOWNN);
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
    public function setApplicationId(int $applicationId): void
    {
        $this->applicationId = $applicationId;
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
     * @return
     */
    public function getStatus(): ApplicationStatus
    {
        return $this->status;
    }

    /**
     * @param ApplicationStatus $status
     */
    public function setStatus(ApplicationStatus $status): void
    {
        $this->status = $status;
    }

    /**
     * @return array
     */
    public function getComponents(): array
    {
        return $this->components;
    }

    /**
     * @param array $components
     */
    public function setComponents(array $components): void
    {
        $this->components = $components;
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
     */
    public function setRepositories(array $repositories): void
    {
        $this->repositories = $repositories;
    }
}
