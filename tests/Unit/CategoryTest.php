<?php


namespace app\tests\Unit;


use app\core\Database;
use app\models\Category;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Dotenv\Dotenv;

class CategoryTest extends TestCase
{
    function testCanPushToDB()
    {
        $dotenv = new Dotenv();
        $dotenv->load(dirname(__DIR__).'/../.env');
        $db = Database::getInstance();
        Category::refreshData($db);
        $count = Category::query()->count();
        $this->assertEquals(count(Category::NEEDLE_CATEGORIES), $count);
    }
}
