<?php
declare(strict_types=1);

namespace Validate\Test;

use Validate\Phone;
use PHPUnit\Framework\TestCase;

final class PhoneTest extends TestCase
{
    /**
     *
     * @group fast
     * @return void
     */
    public function testToDatabase()
    {
        $this->assertEquals((string) Phone::toDatabase('(21) 99919-3898'), '5521999193898');
        $this->assertEquals((string) Phone::toDatabase('+55 (21) 99919-3898'), '5521999193898');
        $this->assertEquals((string) Phone::toDatabase('+14 (21) 99919-3898'), '1421999193898');
    }

    /**
     *
     * @group fast
     * @return void
     */
    public function testBreak()
    {
        $phone = Phone::break('+14 (44) 99919-3898');
        $this->assertEquals((string) $phone['country'], '14');
        $this->assertEquals((string) $phone['region'], '44');
        $this->assertEquals((string) $phone['number'], '999193898');
        $phone = Phone::break('(21) 99919-3898');
        $this->assertEquals((string) $phone['country'], '55');
        $this->assertEquals((string) $phone['region'], '21');
        $this->assertEquals((string) $phone['number'], '999193898');
    }
}
