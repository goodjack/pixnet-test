<?php

namespace App\Services;

class NumService
{
    public function genNumSet($count)
    {
        $numSet = array();

        for ($i = 0; $i < $count; $i++) {
            $randNum = rand(0, 9);
            if (!$this->checkNum($numSet, $randNum)) {
                $i--;
            } else {
                $numSet[] = $randNum;
            }
        }

        return $numSet;
    }

    private function checkNum($numSet, $randNum)
    {
        foreach ($numSet as $item) {
            if ($item == $randNum) {
                return false;
            }
        }
        return true;
    }
}
