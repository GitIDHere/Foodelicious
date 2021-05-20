<?php namespace App\Classes;

use Illuminate\Pagination\LengthAwarePaginator;

class CustomPaginator extends LengthAwarePaginator
{
    
    public $items;
    
    public function __construct($items,$total,$perPage,$currentPage=null,array $options=[])
    {
        parent::__construct($items,$total,$perPage,$currentPage,$options);
    }
    
}