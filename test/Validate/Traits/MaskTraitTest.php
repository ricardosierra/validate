<?php
declare(strict_types=1);

namespace Validate\Test\Traits;

use Validate\Traits\MaskTrait;
use PHPUnit\Framework\TestCase;

class ForTestingMaskTrait
{
    use MaskTrait;
}

final class MaskTraitTest extends TestCase
{
    /**
     *
     * @group fast
     * @return void
     */
    public function testIncluiInArray()
    {
        $this->assertEquals(ForTestingMaskTrait::maskIsValidate('1234567', '1234XXX'), true);
        $this->assertEquals(ForTestingMaskTrait::maskIsValidate('2234567', '1234XXX'), false);
        $this->assertEquals(ForTestingMaskTrait::maskIsValidate('22345678', '2234XXX'), false);
    }
}
