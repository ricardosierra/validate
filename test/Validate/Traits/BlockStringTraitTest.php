<?php
declare(strict_types=1);

namespace Validate\Test\Traits;

use Validate\Traits\BlockStringTrait;
use PHPUnit\Framework\TestCase;

class OnlyForTestBlockString
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
        $this->assertEquals(OnlyForTestBlockString::foundInArray('MASCULINO', ['MASCULINO']), true);
    }
}
