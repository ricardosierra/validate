<?php
declare(strict_types=1);

namespace Validate\Test;

use Validate\Gender;
use PHPUnit\Framework\TestCase;

final class GenderTest extends TestCase
{
    /**
     *
     * @group fast
     * @return void
     */
    public function filterTest()
    {
        $this->assertEquals('MASCULINO', Gender::toDatabase('HOMEM'));
        $this->assertEquals('MASCULINO', Gender::toDatabase('MALE'));
    }

    /**
     *
     * @group fast
     * @return void
     */
    public function testValidate()
    {
        $this->assertEquals(true, Gender::validate('M'));
        $this->assertEquals(false, Gender::validate('Z'));
    }


    /**
     *
     * @group fast
     * @return void
     */
    public function testToDatabase()
    {
        $this->assertEquals('M', Gender::toDatabase('MASCULINO'));
        $this->assertEquals('M', Gender::toDatabase('HOMEM'));
        $this->assertEquals('M', Gender::toDatabase('MALE'));
        $this->assertEquals('M', Gender::toDatabase('MACHO'));
        $this->assertEquals('F', Gender::toDatabase('WOMAN'));
        $this->assertEquals('F', Gender::toDatabase('FEMININO'));
        $this->assertEquals('F', Gender::toDatabase('MULHER'));
        $this->assertEquals('F', Gender::toDatabase('FEMIA'));
    }
}
