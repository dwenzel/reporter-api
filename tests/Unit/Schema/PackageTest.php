<?php

namespace DWenzel\ReporterApi\Tests\Unit\Schema;

use DWenzel\ReporterApi\Schema\NullPackageSource;
use DWenzel\ReporterApi\Schema\Package;
use DWenzel\ReporterApi\Schema\PackageSource;
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
class PackageTest extends UnitTestCase
{
    /**
     * @var Package
     */
    protected $subject;

    public function setUp()
    {
        $this->subject = new Package();
    }

    public function testGetNameInitiallyReturnsEmptyString(): void
    {
        $this->assertSame(
            '',
            $this->subject->getName()
        );
    }

    public function testNameCanBeSet(): void
    {
        $name = 'bas';
        $this->subject->setName($name);
        $this->assertSame(
            $name,
            $this->subject->getName()
        );
    }

    public function testTypeInitiallyReturnsEmptyString(): void
    {
        $this->assertSame(
            '',
            $this->subject->getType()
        );
    }

    public function testTypeCanBeSet(): void
    {
        $type = 'zut';
        $this->subject->setType($type);
        $this->assertSame(
            $type,
            $this->subject->getType()
        );
    }

    public function testGetSourceInitiallyReturnsNullPackage(): void
    {
        $this->assertInstanceOf(
            NullPackageSource::class,
            $this->subject->getSource()
        );
    }

    public function testSourceCanBeSet(): void
    {
        $source = new PackageSource();
        $this->subject->setSource($source);

        $this->assertSame(
            $source,
            $this->subject->getSource()
        );
    }
}
