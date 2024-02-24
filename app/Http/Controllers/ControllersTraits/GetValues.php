<?php

namespace App\Http\Controllers\ControllersTraits;

trait GetValues
{
    public function getAllValues($model = null)
    {
        if(is_null($model)) 
        { 
            return ['result' => 'no model added'];
        } else 
        {
            $allValues = $model::all();
            return $allValues;
        }
    }

    public function getValue($model = null, $column = 'email', $key = '')
    {
        if(is_null($model)) 
        {
            return ['result'=> 'no model added'];
        } else 
        {
            $value = $model::where($column, 'like', '%'. $key .'%')->get();

            return $this->getMultipleOrOneValue($value);

        }
    }

    public function getMultipleOrOneValue($value)
    {
        if(count($value) == 1)
            {
                return $value[0];
            }else
            {
                return $value;
            }

    }
}