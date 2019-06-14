<?php
declare(strict_types=1);

namespace Validate\Test;

use Validate\Password;
use PHPUnit\Framework\TestCase;

final class PasswordTest extends TestCase
{
    /**
     *
     * @group fast
     * @return void
     */
    public function testValidate()
    {
        $this->assertEquals(false, Password::validate('99919-3898'));
        $this->assertEquals(true, Password::validate('(21) 99919-3898'));
    }


    /**
     *
     * @group fast
     * @return void
     */
    public function testToDatabase()
    {
        $this->assertNotEquals('q1w2e3r4', Password::toDatabase('q1w2e3r4'));
        $this->assertNotEquals('123456', Password::toDatabase('123456'));
        $this->assertNotEquals('abcdef', Password::toDatabase('abcdef'));
    }

    /**
     *
     * @group fast
     * @return void
     */
    public function testIsSame()
    {
        $this->assertEquals(true, Password::isSame('(21) 99919-3898', '2199919-3898'));
    }
}
