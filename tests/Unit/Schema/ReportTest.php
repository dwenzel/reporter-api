<?php

declare(strict_types=1);

namespace DWenzel\ReporterApi\Tests\Unit\Schema;

use DWenzel\ReporterApi\Schema\ApplicationStatus;
use DWenzel\ReporterApi\Schema\Report;
use PHPUnit\Framework\TestCase;

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
class ReportTest extends TestCase
{
    private Report $subject;

    protected function setUp(): void
    {
        $this->subject = new Report();
    }

    public function testGetApplicationIdInitiallyReturnsZero(): void
    {
        self::assertSame(
            0,
            $this->subject->getApplicationId()
        );
    }

    public function testGetNameInitiallyReturnsEmptyString(): void
    {
        self::assertSame(
            '',
            $this->subject->getName()
        );
    }

    public function testGetStatusInitiallyReturnsApplicationStatusUnknown(): void
    {
        self::assertSame(
            ApplicationStatus::UNKNOWN,
            $this->subject->getStatus()
        );
    }

    public function testApplicationStatusCanBeSet(): void
    {
        $status = ApplicationStatus::OK;
        $this->subject->setStatus($status);

        self::assertSame(
            $status,
            $this->subject->getStatus()
        );
    }

    public function testGetPackagesInitiallyReturnsEmptyArray(): void
    {
        self::assertSame(
            [],
            $this->subject->getPackages()
        );
    }

    public function testPackagesCanBeSet(): void
    {
        $packages = ['foo'];
        $this->subject->setPackages($packages);
        self::assertSame(
            $packages,
            $this->subject->getPackages()
        );
    }

    public function testGetRepositoriesInitiallyReturnsEmptyArray(): void
    {
        self::assertSame(
            [],
            $this->subject->getRepositories()
        );
    }

    public function testRepositoriesCanBeSet(): void
    {
        $repositories = ['bar'];
        $this->subject->setRepositories($repositories);

        self::assertSame(
            $repositories,
            $this->subject->getRepositories()
        );
    }

}
