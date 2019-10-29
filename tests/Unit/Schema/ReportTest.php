<?php

namespace DWenzel\ReporterApi\Tests\Unit\Schema;

use DWenzel\ReporterApi\Schema\Report;
use DWenzel\Reporter\Domain\Model\ApplicationStatus;
use Nimut\TestingFramework\TestCase\UnitTestCase;

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
class ReportTest extends UnitTestCase
{
    /**
     * @var Report
     */
    protected $subject;

    public function setUp()
    {
        $this->subject = new Report();
    }

    public function testGetApplicationIdInitiallyReturnsZero(): void
    {
        $this->assertSame(
            0,
            $this->subject->getApplicationId()
        );
    }

    public function testGetNameInitiallyReturnsEmptyString(): void
    {
        $this->assertSame(
            '',
            $this->subject->getName()
        );
    }

    public function testGetStatusInitiallyReturnsApplicationStatusUnknown(): void
    {
        $this->assertTrue(
            $this->subject->getStatus()
                ->equals(ApplicationStatus::UNKNOWNN)
        );
    }

    public function testApplicationStatusCanBeSet(): void
    {
        $status = ApplicationStatus::cast(ApplicationStatus::OK);
        $this->subject->setStatus($status);

        $this->assertSame(
            $status,
            $this->subject->getStatus()
        );
    }

    public function testGetPackagesInitiallyReturnsEmptyArray(): void
    {
        $this->assertSame(
            [],
            $this->subject->getPackages()
        );
    }

    public function testPackagesCanBeSet(): void
    {
        $packages = ['foo'];
        $this->subject->setPackages($packages);
        $this->assertSame(
            $packages,
            $this->subject->getPackages()
        );
    }

    public function testGetRepositoriesInitiallyReturnsEmptyArray(): void
    {
        $this->assertSame(
            [],
            $this->subject->getRepositories()
        );
    }

    public function testRepositoriesCanBeSet(): void
    {
        $repositories = ['bar'];
        $this->subject->setRepositories($repositories);

        $this->assertSame(
            $repositories,
            $this->subject->getRepositories()
        );
    }


}
