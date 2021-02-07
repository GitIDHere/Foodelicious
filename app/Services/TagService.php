<?php

namespace App\Services;

class TagService
{
    /**
     * @param $term
     * @return array
     */
    public function getListByTerm($table, $field, $term)
    {
        if (!empty($term) && is_string($term))
        {
            return $table::where($field, 'LIKE', $term.'%')
                ->orderBy($field)
                ->take(5)
                ->get()
                ->toArray()
                ;   
        }
        return [];
    }
}