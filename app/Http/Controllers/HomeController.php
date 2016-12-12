<?php

namespace App\Http\Controllers;

use App\Services\NumService;

class HomeController extends Controller
{
    private $numService;

    public function __construct(NumService $numService)
    {
        $this->numService = $numService;
    }

    public function index()
    {
        $numSet = $this->numService->genNumSet(4);

        return view('index', compact('numSet'));
    }
}
