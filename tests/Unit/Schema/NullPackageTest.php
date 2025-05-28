<?php

namespace DWenzel\ReporterApi\Tests\Unit\Schema;

use DWenzel\ReporterApi\Schema\NullPackage;
use DWenzel\ReporterApi\Schema\NullPackageSource;
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
class NullPackageTest extends UnitTestCase
{
    /**
     * @var NullPackage
     */
    protected $subject;

    public function setUp()
    {
        $this->subject = new NullPackage();
    }

    public function testGetNameReturnsEmptyString(): void
    {
        self::assertSame(
            '',
            $this->subject->getName()
        );
    }

    public function testNameCanNotBeSet(): void
    {
        $name = 'bas';
        $this->subject->setName($name);
        self::assertSame(
            '',
            $this->subject->getName()
        );
    }

    public function testTypeReturnsEmptyString(): void
    {
        self::assertSame(
            '',
            $this->subject->getType()
        );
    }

    public function testTypeCanNotBeSet(): void
    {
        $type = 'zut';
        $this->subject->setType($type);
        self::assertSame(
            '',
            $this->subject->getType()
        );
    }

    public function testGetSourceReturnsNullPackage(): void
    {
        self::assertInstanceOf(
            NullPackageSource::class,
            $this->subject->getSource()
        );
    }

    public function testSourceCanNotBeSet(): void
    {
        $source = new PackageSource();
        $this->subject->setSource($source);

        self::assertInstanceOf(
            NullPackageSource::class,
            $this->subject->getSource()
        );
    }
}
