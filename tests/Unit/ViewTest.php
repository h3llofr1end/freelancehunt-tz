<?php


namespace app\tests\Unit;


use app\core\View;
use PHPUnit\Framework\TestCase;

class ViewTest extends TestCase
{
    function testOpenNonexistView()
    {
        $this->expectException(\Exception::class);
        View::render('non-exist/null.php');
    }
}
