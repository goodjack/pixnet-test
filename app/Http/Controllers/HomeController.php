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
        if (is_null($request->cookie('numSet')) || $request->input('reset') == 1) {
            $numSetStr = $this->numService->genNumSet(4);

            return response()
                ->view('index', compact('numSetStr'))
                ->cookie('numSetStr', $numSetStr)
                ->cookie('guessHistory', '');
        } else {
            $numSetStr = $request->cookie('numSetStr');

            return response()->view('index', compact('numSetStr'));
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

        $guessHistory = $request->cookie('guessHistory');

        // STEP 1
        $checkSame = $this->numService->checkSame($inputNumStr);
        if ($checkSame) {
            return response()
                ->view('index', compact('numSetStr', 'inputNumStr', 'checkSame', 'guessHistory'));
        }

        // STEP 2
        $checkPastInput = $this->numService->checkPastInput($inputNumStr, $guessHistory);
        if ($checkPastInput) {
            return response()
                ->view('index', compact('numSetStr', 'inputNumStr', 'checkPastInput', 'guessHistory'));
        }

        // STEP 3
        $guessResult = $this->numService->checkAB($numSetStr, $inputNumStr);

        //$guessHistory = $this->numService->addGuessHistory($inputNumStr, $guessResult, $guessHistory);
        if ($guessResult !== '4A0B') {
            $guessHistory = $guessHistory . $inputNumStr . ': ' . $guessResult . "\n";
        } else {
            $guessHistory = $guessHistory . $inputNumStr . ': ' . "正解\n";
        }

        return response()
            ->view('index', compact('numSetStr', 'inputNumStr', 'guessResult', 'guessHistory'))
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
