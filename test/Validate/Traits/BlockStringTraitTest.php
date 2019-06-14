<?php
declare(strict_types=1);

namespace Validate\Test\Traits;

use Validate\Traits\BlockStringTrait;
use PHPUnit\Framework\TestCase;

class OnlyForTest
{
    use BlockStringTrait;
}

final class BlockStringTraitTest extends TestCase
{
    /**
     *
     * @group fast
     * @return void
     */
    public function testIncluiInArray()
    {
        $this->assertEquals(OnlyForTest::foundInArray('MASCULINO', ['MASCULINO']), true);
    }
}
