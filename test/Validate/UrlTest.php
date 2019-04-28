<?php
declare(strict_types=1);

namespace Validate\Test;

use Validate\Url;
use PHPUnit\Framework\TestCase;

final class UrlTest extends TestCase
{
    /**
     *
     * @group fast
     * @return void
     */
    public function testValidate()
    {
        // Nome incompleto deve retornar false
        $this->assertEquals(Url::validate('cozinha mineira'), false);
        $this->assertEquals(Url::validate('http://anima10.net'), true);
        $this->assertEquals(Url::validate('https://anima10.net'), true);
    }


    /**
     *
     * @group fast
     * @return void
     */
    public function testToDatabase()
    {
        $this->assertEquals('anima10.net', Url::toDatabase('http://anima10.net'));
        $this->assertEquals('anima10.net', Url::toDatabase('https://anima10.net'));
    }


    /**
     *
     * @group fast
     * @return void
     */
    public function testToUser()
    {
        $this->assertEquals('anima10.net', Url::toDatabase('https://anima10.net'));
    }

    /**
     *
     * @group fast
     * @return void
     */
    public function testBreak()
    {
        $urlString = 'https://anima10.net';
        $url = Url::break($urlString);
        $this->assertEquals($urlString, $url['path']);
    }

    /**
     *
     * @group fast
     * @return void
     */
    public function testParseDir()
    {
        $urlString = 'https://anima10.net/conteudo/';
        $this->assertEquals($urlString, Url::parseDir($urlString.'ola'));
    }

    // /**
    //  *
    //  * @group fast
    //  * @return void
    //  */
    // public function testCleanLink()
    // {
    //     $urlParentString = 'https://anima10.net/conteudo/';
    //     $urlString = 'https://anima10.net/conteudo/';
    //     var_dump( Url::cleanLink($urlString, $urlParentString));
    //     $this->assertEquals($urlString, Url::cleanLink($urlString, $urlParentString));
    // }
}
