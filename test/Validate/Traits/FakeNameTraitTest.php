<?php
declare(strict_types=1);

namespace Validate\Test\Traits;

use Validate\Traits\FakeNameTrait;
use PHPUnit\Framework\TestCase;

class OnlyForTest
{
    use FakeNameTrait;
}

final class FakeNameTraitTest extends TestCase
{
    /**
     *
     * @group fast
     * @return void
     */
    public function testIncluiInArray()
    {
        $this->assertEquals(OnlyForTest::incluiInArray('MASCULINO', ['MASCULINO']), true);
    }
}
