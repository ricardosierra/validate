<?php
declare(strict_types=1);

namespace Validate\Test;

use Validate\Date;
use PHPUnit\Framework\TestCase;

final class DateTest extends TestCase
{
    /**
     *
     * @group fast
     * @return void
     */
    public function testValidate()
    {
        $this->assertEquals(true, Date::validate('28/08/1991'));
        $this->assertEquals(true, Date::validate('28/08/2091'));
    }


    /**
     *
     * @group fast
     * @return void
     */
    public function testToDatabase()
    {
        $this->assertEquals('1991-08-28', Date::toDatabase('28/08/1991'));
        $this->assertEquals('2091-08-28', Date::toDatabase('28/08/2091'));
    }

    /**
     *
     * @group fast
     * @return void
     */
    public function testIsSame()
    {
        $this->assertEquals(true, Date::isSame('1991-08-28', '28/08/1991'));
    }

    /**
     *
     * @group fast
     * @return void
     */
    public function testYearToDatabase()
    {
        $this->assertEquals('1991', Date::yearToDatabase('1991'));
        $this->assertEquals('2091', Date::yearToDatabase('2091'));
        $this->assertEquals('1991', Date::yearToDatabase('91'));
        $this->assertEquals('2005', Date::yearToDatabase('05'));
    }

}
