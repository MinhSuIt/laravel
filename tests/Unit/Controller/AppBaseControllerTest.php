<?php

namespace Tests\Unit\Controller;

use PHPUnit\Framework\TestCase;

class AppBaseControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }
    
    public function testConstruct()
    {
        //tạo 1 trong các controller đã thừa kế appBase và gọi 
        $this->assertTrue(true);
    }
}
