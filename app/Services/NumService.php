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

            if (!$this->checkNumErr($numSet, $randNum)) {
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
    private function checkNumErr($numSet, $randNum)
    {
        foreach ($numSet as $item) {
            if ($item == $randNum) {
                return false;
            }
        }
        return true;
    }


    /**
     * @param $inputNumStr
     * @param $count
     * @return bool
     */
    public function checkInputCountErr($inputNumStr, $count)
    {
        if (strlen($inputNumStr) != $count) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * @param $inputNumStr
     * @return bool
     */
    public function checkSameErr($inputNumStr)
    {
        $inputNum = str_split($inputNumStr);

        if (count($inputNum) === count(array_unique($inputNum))) {
            return false;
        } else {
            return true;
        }
    }


    /**
     * @param $inputNumStr
     * @param $guessHistory
     * @return int
     */
    public function checkPastInputErr($inputNumStr, $guessHistory)
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


    /**
     * @param $numSet
     * @param $inputNum
     * @return int
     */
    private function checkA($numSet, $inputNum)
    {
        $counterA = 0;
        foreach ($inputNum as $key => $value) {
            if ($numSet[$key] === $value) {
                $counterA++;
            }
        }
        return $counterA;
    }


    /**
     * @param $numSet
     * @param $inputNum
     * @param $ansA
     * @return int
     */
    private function checkB($numSet, $inputNum, $ansA)
    {
        $counterB = 0;
        foreach ($inputNum as $value) {
            if (in_array($value, $numSet)) {
                $counterB++;
            }
        }
        return $counterB - $ansA;
    }


//    public function addGuessHistory($inputNumStr, $guessResult, $guessHistory)
//    {
//        print_r('3.'.$guessHistory.'  ');
//        if ($guessResult !== '4A0B') {
//            return $guessHistory . $inputNumStr . ': ' . $guessResult . '<br>';
//        } else {
//            return $guessHistory . $inputNumStr . ': ' . '正解\n';
//        }
//        //return $guessHistory;
//    }
}
