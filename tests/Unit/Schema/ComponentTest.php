<?php

namespace DWenzel\ReporterApi\Tests\Unit\Schema;

use DWenzel\ReporterApi\Schema\Component;
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
class ComponentTest extends UnitTestCase
{
    /**
     * @var Component
     */
    protected $subject;

    public function setUp()
    {
        $this->subject = new Component();
    }

    public function testGetIdInitiallyReturnsEmptyString(): void
    {
        $this->assertSame(
            '',
            $this->subject->getId()
        );
    }

    public function testIdCanBeSet(): void
    {
        $id = 'bas';
        $this->subject->setId($id);
        $this->assertSame(
            $id,
            $this->subject->getId()
        );
    }

    public function testNameInitiallyReturnsEmptyString(): void
    {
        $this->assertSame(
            '',
            $this->subject->getName()
        );
    }

    public function testNameCanBeSet(): void
    {
        $name = 'zut';
        $this->subject->setName($name);
        $this->assertSame(
            $name,
            $this->subject->getName()
        );
    }
}
