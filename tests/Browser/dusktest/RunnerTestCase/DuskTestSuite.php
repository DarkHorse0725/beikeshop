<?php

use PHPUnit\Framework\TestSuite;
use Tests\DuskTestCase;

require_once __DIR__ . '/../page/front/LoginTest.php';
require_once __DIR__ . '/../page/front/RegisterTest.php';
class DuskTestSuite extends DuskTestCase
{
    public static function suite()
    {
        $suite = new TestSuite('Dusk Tests');

        $suite->addTestFile(__DIR__ . '/../page/front/LoginTest.php');
        $suite->addTestFile(__DIR__ . '/../page/front/RegisterTest.php');

        return $suite;
    }
}
