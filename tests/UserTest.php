<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Services\NumService;

class UserTest extends TestCase
{
    public function testGenNumSet()
    {
        $numService = new NumService();

        $count = 6;
        $numSet = $numService->genNumSet($count);

        for ($i = 0; $i < $count-1; $i++) {
            for ($j = $i+1; $j < $count; $j++) {
                $this->assertNotEquals($numSet[$i], $numSet[$j]);
            }
        }
    }

    public function testInputCountErr()
    {
        $numService = new NumService();

        $inputNumStr = "13579";
        $count = 6;
        $result = $numService->checkInputCountErr($inputNumStr, $count);
        $this->assertTrue($result);

        $inputNumStr = "2468";
        $count = 4;
        $result = $numService->checkInputCountErr($inputNumStr, $count);
        $this->assertFalse($result);
    }

    public function testDuplicateNum()
    {
        $numService = new NumService();

        $duplicateNumStr = "1123";
        $result = $numService->checkSameErr($duplicateNumStr);

        $this->assertEquals($result, true);
    }

    public function testCheckAB()
    {
        $numService = new NumService();
        $numStr = "13579";

        $inputStr = "13579";
        $result = $numService->checkAB($numStr, $inputStr);
        $this->assertEquals($result, "5A0B");

        $inputStr = "14567";
        $result = $numService->checkAB($numStr, $inputStr);
        $this->assertEquals($result, "2A1B");
    }
}

