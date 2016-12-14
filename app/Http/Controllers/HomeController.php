<?php

namespace App\Http\Controllers;

use App\Services\NumService;
use Illuminate\Http\Request;
use Response;

class HomeController extends Controller
{
    private $numService;


    /**
     * HomeController constructor.
     * @param NumService $numService
     */
    public function __construct(NumService $numService)
    {
        $this->numService = $numService;
    }


    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (is_null($request->N)) {
            $count = 4;
        } else {
            $count = $request->N;
        }

        if (is_null($request->cookie('numSet')) || $request->input('reset') == 1) {
            if ($count > 10 || $count < 1) {
                $count = 4;
            }

            $numSetStr = $this->numService->genNumSet($count);

            return response()
                ->view('index', compact('count', 'numSetStr'))
                ->cookie('numSetStr', $numSetStr)
                ->cookie('guessHistory', '');
        } else {
            $numSetStr = $request->cookie('numSetStr');

            return response()->view('index', compact('count', 'numSetStr'));
        }
    }


    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\Response
     */
    public function guess(Request $request)
    {
        $numSetStr = $request->cookie('numSetStr');
        $inputNumStr = $request->inputNumStr;
        $count = $request->count;

        $guessHistory = $request->cookie('guessHistory');

        // === STEP 0 === //
        $checkInputCountErr = $this->numService->checkInputCountErr($inputNumStr, $count);
        if ($checkInputCountErr) {
            return response()
                ->view('index', compact('count', 'numSetStr', 'inputNumStr', 'checkInputCountErr', 'guessHistory'));
        }


        // === STEP 1 === //
        $checkSameErr = $this->numService->checkSameErr($inputNumStr);
        if ($checkSameErr) {
            return response()
                ->view('index', compact('count', 'numSetStr', 'inputNumStr', 'checkSameErr', 'guessHistory'));
        }

        // === STEP 2 === //
        $checkPastInputErr = $this->numService->checkPastInputErr($inputNumStr, $guessHistory);
        if ($checkPastInputErr) {
            return response()
                ->view('index', compact('count', 'numSetStr', 'inputNumStr', 'checkPastInputErr', 'guessHistory'));
        }

        // === STEP 3 === //
        $guessResult = $this->numService->checkAB($numSetStr, $inputNumStr);

        //$guessHistory = $this->numService->addGuessHistory($inputNumStr, $guessResult, $guessHistory);
        if ($guessResult !== $count . 'A0B') {
            $guessHistory = $guessHistory . $inputNumStr . '：' . $guessResult . "\n";
        } else {
            $guessHistory = $guessHistory . $inputNumStr . '：' . "正解\n";
        }

        return response()
            ->view('index', compact('count', 'numSetStr', 'inputNumStr', 'guessResult', 'guessHistory'))
            ->cookie('guessHistory', $guessHistory);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function downloadHistory(Request $request)
    {
        $fileText = "作答記錄\n" . $request->cookie('guessHistory');
        $fileName = 'History.txt';
        $headers = ['Content-type'=>'text/plain',
                    'Content-Disposition'=>sprintf('attachment; filename="%s"', $fileName),
                    'Content-Length'=>strlen($fileText)];
        return Response::make($fileText, 200, $headers);
    }
}
