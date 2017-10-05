<?php

namespace App\Filters;
use App\User;
use Illuminate\Http\Request;
use App\Filters\Filters;

/**
*
*/
abstract class Filters
{
    protected $filters = [];
    protected $request;
    protected $builder;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            if ( method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    public function getFilters()
    {
        return $this->request->only($this->filters);
    }
}
