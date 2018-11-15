<?php

namespace Anax\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class IPControllerTest extends TestCase
{
    /**
     * Test the route "index".
     */
    public function testIPAction()
    {
        $controller = new IPController();
        $res = $controller->ipActionGet();
        $this->assertContains("is a valid IP address", $res);
    }
    /**
     * Test the route "index".
     */
    public function testIPSelfWorkAction()
    {
        $controller = new IPController();
        $res = $controller->ipSelfActionGet("212.212.100.110");
        $this->assertContains("is a valid IP address", $res);
    }
    /**
     * Test the route "index".
     */
    public function testIPSelfFailedAction()
    {
        $controller = new IPController();
        $res = $controller->ipSelfActionGet("212.212.100.1120");
        $this->assertContains("is not a valid IP address", $res);
    }
}
