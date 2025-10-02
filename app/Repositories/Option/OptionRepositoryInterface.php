<?php

namespace App\Repositories\Option;

interface OptionRepositoryInterface
{
    public function optionIndex();
    public function optionStore($request);
}
