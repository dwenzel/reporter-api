<?php

namespace DWenzel\ReporterApi\Tests\Unit\Schema;

use DWenzel\ReporterApi\Schema\Category;
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
class CategoryTest extends UnitTestCase
{
    /**
     * @var Category
     */
    protected $subject;

    public function setUp()
    {
        $this->subject = new Category();
    }

    public function testGetIdInitiallyReturnsZero(): void
    {
        self::assertSame(
            0,
            $this->subject->getId()
        );
    }

    public function testIdCanBeSet(): void
    {
        $id = 1234;
        $this->subject->setId($id);

        self::assertSame(
            $id,
            $this->subject->getId()
        );
    }

    public function testGetNameInitiallyReturnsEmptyString(): void
    {
        self::assertSame(
            '',
            $this->subject->getName()
        );
    }

    public function testNameCanBeSet(): void
    {
        $name = 'pu';
        $this->subject->setName($name);

        self::assertSame(
            $name,
            $this->subject->getName()
        );
    }
}
