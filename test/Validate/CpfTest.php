<?php
declare(strict_types=1);

namespace Validate\Test;

use Validate\Cpf;
use PHPUnit\Framework\TestCase;

final class CpfTest extends TestCase
{
    /**
     *
     * @group fast
     * @return void
     */
    public function testValidate()
    {
        $this->assertEquals(true, Cpf::validate('132.782.017-01'));
        $this->assertEquals(true, Cpf::validate('13278201701'));
        $this->assertEquals(false, Cpf::validate('132.782.017-02'));
        $this->assertEquals(false, Cpf::validate('13278201702'));
    }

    /**
     *
     * @group fast
     * @return void
     */
    public function testToDatabase()
    {
        $this->assertEquals('13278201701', Cpf::toDatabase('132.782.017-01'));
    }

}
