<?php
declare(strict_types=1);

namespace Validate\Test;

use Validate\Name;
use PHPUnit\Framework\TestCase;

final class NameTest extends TestCase
{
    /**
     *
     * @group fast
     * @return void
     */
    public function testToDatabase()
    {
        $this->assertEquals('RICARDO SIERRA', Name::toDatabase('Ricardo Sierra'));
    }

    /**
     *
     * @group fast
     * @return void
     */
    public function testValidate()
    {
        // Nome incompleto deve retornar false
        $this->assertEquals(false, Name::validate('Ricardo'));

        $this->assertEquals(false, Name::validate('Sierra Testador'));
        $this->assertEquals(true, Name::validate('Ricardo Sierra'));

        $this->assertEquals(false, Name::validate('Ricardo Si2erra'));

        $this->assertEquals(false, Name::validate('Teste Sierra'));
    }

    /**
     *
     * @group fast
     * @return void
     */
    public function testBreak()
    {
        $name = Name::break('RICARDO R SIERRA');
        $this->assertEquals($name['first'], 'RICARDO');
        $this->assertEquals($name['last'], 'SIERRA');
        $name = Name::break('Ricardo Sierra');
        $this->assertEquals($name['first'], 'RICARDO');
        $this->assertEquals($name['last'], 'SIERRA');
    }

    /**
     *
     * @group fast
     * @return void
     */
    public function testIsSame()
    {
        $this->assertEquals(true, Name::isSame('Ricardo Sierra', 'RICARDO SIERRA'));
        $this->assertEquals(true, Name::isSame('Ricardo Rebello Sierra', 'RICARDO SIERRA'));
        $this->assertEquals(true, Name::isSame('Ricardo R Sierra', 'RICARDO SIERRA'));
        $this->assertEquals(false, Name::isSame('Ricardo R Sierra', 'RICARDO SILVA'));
    }
}
