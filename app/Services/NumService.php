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

    public function checkSame($inputNumStr)
    {
        $inputNum = str_split($inputNumStr);

        if (count($inputNum) === count(array_unique($inputNum))) {
            return false;
        } else {
            return true;
        }
    }

    public function checkPastInput($inputNumStr, $guessHistory)
    {
        return preg_match('/' . $inputNumStr . '/', $guessHistory);
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

        $ansA = $this->checkA($numSet, $inputNum);
        $ansB = $this->checkB($numSet, $inputNum, $ansA);

        return $ansA . 'A' . $ansB . 'B';
    }

    private function checkA($numSet, $inputNum)
    {
        $counterA = 0;
        foreach ($numSet as $key => $value) {
            if ($inputNum[$key] === $value) {
                $counterA++;
            }
        }
        return $counterA;
    }

    private function checkB($numSet, $inputNum, $ansA)
    {
        $counterB = 0;
        foreach ($numSet as $value) {
            if (in_array($value, $inputNum)) {
                $counterB++;
            }
        }
        return $counterB - $ansA;
    }

    /*public function addGuessHistory($inputNumStr, $guessResult, $guessHistory)
    {
        print_r('3.'.$guessHistory.'  ');
        if ($guessResult !== '4A0B') {
            return $guessHistory . $inputNumStr . ': ' . $guessResult . '<br>';
        } else {
            return $guessHistory . $inputNumStr . ': ' . '正解\n';
        }
        //return $guessHistory;
    }*/


}
