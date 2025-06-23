<?php

namespace App\Http\Filters\V1;

// THE BUILDER IS BEING IMPORTED FROM HERE
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

// this is a base class for ticket filter
abstract class QueryFilter
{
    protected $builder;

    protected $request;

    protected $sortable = [];

    public function __construct(Request $request)
    {

        $this->request = $request;
    }

    protected function filter($arr)
    {
        foreach ($arr as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);

            }

        }

        return $this->builder;

    }

    public function apply(Builder $builder)
    {

        $this->builder = $builder;

        // iterates over the query param
        foreach ($this->request->all() as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);

            }

        }

        return $builder;
    }

    // function for the sort query
    protected function sort($value)
    {
        $sortAttirbutes = explode(',', $value);
        foreach ($sortAttirbutes as $sortAttirbute) {
            $direction = 'asc';

            // if the the attributes is -ve sign that means it is descnding order otherwise ascending
            if (strpos($sortAttirbute, '-') == 0) {
                $direction = 'desc';
                $sortAttirbute = substr($sortAttirbute, 1);
            }

            // not in case, if the user sends random keyword not in query its filtered out

            if (! in_array($sortAttirbute, $this->sortable) && ! array_key_exists($sortAttirbute, $this->sortable)) {
                continue;
            }

            $columnName = $this->sortable[$sortAttirbute] ?? null;

            if ($columnName == null) {

                $columnName = $sortAttirbute;
            }

            // after we get ascending / descending direction we can use the bukder to build the string accoridngly

            $this->builder->orderBy($columnName, $direction);

        }

    }
}
