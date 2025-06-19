<?php


namespace App\Http\Filters\V1;

class AuthorFilter extends QueryFilter{

    public function include($value)
    {
        //eagles out relations , pre fetches 
        return $this->builder->with($value);

    }

    public function id($value){

// explode akes substring , first param is the sperator value so , A,B,C will be seperated by A B and c 

        return $this->builder->whereIn('id', explode(',', $value));

    }//fix builder

    public function createdAt($value)
{
    $dates = explode(',', $value);

    if (count($dates) > 1) {
        return $this->builder->whereBetween('created_at', $dates);
    }

    // if only one date is passed, use whereDate
    return $this->builder->whereDate('created_at', $dates[0]);
}


     public function updatedAt($value)
    {
$dates=explode(',',$value);

if(count($dates)>1){
return $this->builder->whereBetween('updated_at', $dates);
}


return $this->builder->whereBetween('updated_at', $value);
    }


    public function email($value)
    {
        $likestr=str_replace('*','%',$value);
        return $this ->builder->where('email','like',$likestr);
    }


    public function name($value)
    {
        $likestr=str_replace('*','%',$value);
        return $this ->builder->where('name','like',$likestr);
    }

}