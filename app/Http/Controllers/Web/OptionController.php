<?php

namespace App\Http\Controllers\Web;

use App\Authorizable;
use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Repositories\Option\OptionRepositoryInterface;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    use Authorizable;

    private $optionRepository;

    public function __construct(OptionRepositoryInterface $optionRepository)
    {
        $this->optionRepository = $optionRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->optionRepository->optionIndex();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->optionRepository->optionStore($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
