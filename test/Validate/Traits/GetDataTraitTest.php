<?php
declare(strict_types=1);

namespace Validate\Test\Traits;

use Validate\Traits\GetDataTrait;
use PHPUnit\Framework\TestCase;

class OnlyForTestGetData
{
    use GetDataTrait;
}

final class GetDataTraitTest extends TestCase
{
    /**
     * @todo Falta Fazzer
     * @group fast
     * @return void
     */
    public function testIncluiInArray()
    {
        // $this->assertEquals(OnlyForTestGetData::foundInArray('MASCULINO', ['MASCULINO']), true);
    }
}
