<?php

namespace App\Http\Controllers;

use App\Services\NumService;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (is_null($request->cookie('numSet')) || $request->input('reset') == 1) {
            $numSetStr = $this->numService->genNumSet(4);

            return response()
                ->view('index', compact('numSetStr'))
                ->cookie('numSetStr', $numSetStr);
        } else {
            $numSetStr = $request->cookie('numSetStr');

            return response()->view('index', compact('numSetStr'));
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function guess(Request $request)
    {
        $numSetStr = $request->cookie('numSetStr');
        $inputNumStr = $request->inputNumStr;

        $guessResult = $this->numService->checkAB($numSetStr, $inputNumStr);

        return view('index', compact('numSetStr', 'inputNumStr', 'guessResult'));
    }
}
