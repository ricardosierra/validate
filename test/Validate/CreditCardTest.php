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
        $this->assertEquals(true, CreditCard::validate('411111111111111'));
        $this->assertEquals(false, CreditCard::validate('111111111111111'));
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

    /**
     *
     * @group fast
     * @return void
     */
    public function testExpirationIsValid()
    {
        $this->assertEquals(true, CreditCard::expirationIsValid('12', '2028'));
        $this->assertEquals(false, CreditCard::expirationIsValid('03', '2019'));
        $this->assertEquals(false, CreditCard::expirationIsValid('12', '2018'));
    }
}
