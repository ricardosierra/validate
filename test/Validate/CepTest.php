<?php
declare(strict_types=1);

namespace Validate\Test;

use Validate\Cep;
use PHPUnit\Framework\TestCase;

final class CepTest extends TestCase
{
    /**
     *
     * @group fast
     * @return void
     */
    public function testValidate()
    {
        // Nome incompleto deve retornar false
        $this->assertEquals(true, Cep::validate('22.460-030'));
        $this->assertEquals(true, Cep::validate('22460030'));
        $this->assertEquals(false, Cep::validate('220.360-030'));
        $this->assertEquals(false, Cep::validate('2236.00-30'));
    }

    /**
     *
     * @group fast
     * @return void
     */
    public function testToDatabase()
    {
        $this->assertEquals('22460030', Cep::toDatabase('22.460-030'));
    }

}
