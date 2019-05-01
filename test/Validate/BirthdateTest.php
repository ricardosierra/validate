<?php
declare(strict_types=1);

namespace Validate\Test;

use Validate\Birthdate;
use PHPUnit\Framework\TestCase;

final class BirthdateTest extends TestCase
{
    /**
     *
     * @group fast
     * @return void
     */
    public function testValidate()
    {
        $this->assertEquals(true, Birthdate::validate('28/08/1991'));
        $this->assertEquals(false, Birthdate::validate('28/08/2091'));
    }


    /**
     *
     * @group fast
     * @return void
     */
    public function testToDatabase()
    {
        $this->assertEquals('1991-08-28', Birthdate::toDatabase('28/08/1991'));
        $this->assertEquals('2091-08-28', Birthdate::toDatabase('28/08/2091'));
    }

    /**
     *
     * @group fast
     * @return void
     */
    public function testIsSame()
    {
        $this->assertEquals(true, Phone::isSame('1991-08-28', '28/08/1991'));
    }
}
