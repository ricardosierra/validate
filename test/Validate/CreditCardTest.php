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
        $this->assertEquals(CreditCard::validate('4111111111111111'), true);
    }

    /**
     *
     * @group fast
     * @return void
     */
    public function testYearFilter()
    {
        $this->assertEquals((string) CreditCard::year('21'), '2021');
        $this->assertEquals((string) CreditCard::year('91'), '1991');
    }
}
