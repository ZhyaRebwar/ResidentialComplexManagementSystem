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
            if( !empty($allValues) )
                return $allValues;
            else
                return ['result' => 'the table is empty'];
        }
    }

    public function getValueId($model = null, $id = null)
    {
        if(is_null($model)) 
        { 
            return ['result' => 'no model added'];
        } else 
        {
            $value = $model::find( $id );
            if( !empty($value) )
                return $value;
            else
                return ['result' => 'the table is empty'];
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
}
