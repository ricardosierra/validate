<?php
declare(strict_types=1);

namespace Validate\Test;

use Validate\CreditCard;
use PHPUnit\Framework\TestCase;

final class CreditCardTest extends TestCase
{
    /**
     *
     * @group fast
     * @return void
     */
    public function testValidate()
    {
        $this->assertEquals(true, CreditCard::validate('4111111111111111'));
        $this->assertEquals(false, CreditCard::validate('1111111111111111'));
    }

    /**
     *
     * @group fast
     * @return void
     */
    public function testYearFilter()
    {
        $this->assertEquals('2021', (string) CreditCard::year('21'));
        $this->assertEquals('1991', (string) CreditCard::year('91'));
    }
}
