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
        $this->assertEquals(Name::toDatabase('Ricardo Sierra'), 'RICARDO SIERRA');
    }

    /**
     *
     * @group fast
     * @return void
     */
    public function testValidate()
    {
        // Nome incompleto deve retornar false
        $this->assertEquals(Name::validate('Ricardo'), false);

        $this->assertEquals(Name::validate('Sierra Testador'), false);
        $this->assertEquals(Name::validate('Ricardo Sierra'), true);

        $this->assertEquals(Name::validate('Ricardo Si2erra'), false);

        $this->assertEquals(Name::validate('Teste Sierra'), false);
    }

    /**
     *
     * @group fast
     * @return void
     */
    public function testBreak()
    {
        $name = Name::break('RICARDO R SIERRA');
        $this->assertEquals((string) $name['first'], 'RICARDO');
        $this->assertEquals((string) $name['last'], 'SIERRA');
        $name = Name::break('Ricardo Sierra');
        $this->assertEquals((string) $name['first'], 'RICARDO');
        $this->assertEquals((string) $name['last'], 'SIERRA');
    }
}
