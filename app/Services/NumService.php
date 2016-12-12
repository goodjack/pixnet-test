<?php

namespace App\Services;

class NumService
{
    /**
     * @param $count
     * @return array
     */
    public function genNumSet($count)
    {
        $numSet = array();
        $numSetString = "";

        for ($i = 0; $i < $count; $i++) {
            $randNum = rand(0, 9);

            if (!$this->checkNum($numSet, $randNum)) {
                $i--;
            } else {
                $numSet[] = $randNum;
                $numSetString .= $randNum;
            }
        }

        return $numSetString;
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
}
