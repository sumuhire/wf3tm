<?php
namespace tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Author;
use App\Entity\Task;

class CalcultationTest extends TestCase
{
    public function testGetAuthor()
    {
        $computerMock = $this->createMock(Computer::class);
        $computerMock->expects($this->once())
            ->method('execAddition')
            ->with($this->equalTo(1), $this->equalTo(2))
            ->willReturn(3);
        
        $calculate = new Calculate();
        
        $calculate->doCalc(1, 2);
    }
}

class Computer
{
    function execAddition($a, $b)
    {
        return $a + $b;
    }
}

class Calculate
{
    function doCalc($a, $b)
    {
        $computer = new Computer();
        return $computer->execAddition($a, $b);
    }
}

