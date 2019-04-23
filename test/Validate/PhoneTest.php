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
    public function testValidate()
    {
        // Nome incompleto deve retornar false
        $this->assertEquals(false, Phone::validate('99919-3898'));
        $this->assertEquals(true, Phone::validate('(21) 99919-3898'));
    }


    /**
     *
     * @group fast
     * @return void
     */
    public function testToDatabase()
    {
        $this->assertEquals('5521999193898', Phone::toDatabase('(21) 99919-3898'));
        $this->assertEquals('5521999193898', Phone::toDatabase('+55 (21) 99919-3898'));
        $this->assertEquals('1421999193898', Phone::toDatabase('+14 (21) 99919-3898'));
    }

    /**
     *
     * @group fast
     * @return void
     */
    public function testBreak()
    {
        $phone = Phone::break('+14 (44) 99919-3898');
        $this->assertEquals('14', $phone['country']);
        $this->assertEquals('44', $phone['region']);
        $this->assertEquals('999193898', $phone['number']);
        $phone = Phone::break('(21) 99919-3898');
        $this->assertEquals('55', $phone['country']);
        $this->assertEquals('21', $phone['region']);
        $this->assertEquals('999193898', $phone['number']);
    }
}
