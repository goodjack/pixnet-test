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
        if (is_null($request->cookie('numSet')) || $request->input('reset')) {
            $numSet = $this->numService->genNumSet(4);
        } else {
            $numSet = $request->cookie('numSet');
        }

        return response()->view('index', compact('numSet'))->cookie('numSet', $numSet);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function guess(Request $request)
    {
        $numSet = $request->cookie('numSet');

        $inputNum = $request->inputNum;

        return view('index', compact('numSet', 'inputNum'));
    }
}
