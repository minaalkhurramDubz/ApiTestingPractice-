<?php



namespace App\Http\Filters\V1;

// THE BUILDER IS BEING IMPORTED FROM HERE 
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

// this is a base class for ticket filter 
abstract class QueryFilter{

    protected $builder;
    protected $request;


    public function __construct(Request $request) 
    {

        $this->request = $request;
    }

    protected function filter($arr)
    {
         foreach ($arr as $key => $value)

        {
            if(method_exists($this,$key))
            {
                $this->$key($value);

            }

        }

        return $this->builder;
        


    }
    public function apply(Builder $builder){

        $this-> builder = $builder;


        // iterates over the query param 
       foreach ($this->request->all() as $key => $value)

        {
            if(method_exists($this,$key))
            {
                $this->$key($value);

            }

        }
          

        return $builder;
    }


}