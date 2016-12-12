<?php

namespace App\Services;

class NumService
{

    /**
     * @param $count
     * @return string
     */
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

        return implode($numSet);
    }

    /**
     * @param $numSet
     * @param $randNum
     * @return bool
     */
    private function checkNum($numSet, $randNum)
    {
        foreach ($numSet as $item) {
            if ($item == $randNum) {
                return false;
            }
        }
        return true;
    }


    /**
     * @param $numSetStr
     * @param $inputNumStr
     * @return string
     */
    public function checkAB($numSetStr, $inputNumStr)
    {
        $numSet = str_split($numSetStr);
        $inputNum = str_split($inputNumStr);

        return "1A2B";
    }
}
