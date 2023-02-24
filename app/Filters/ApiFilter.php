<?php

namespace App\Filters;

use App\Http\Requests;

class ApiFilter
{
    protected $safeParams = [];

    protected $columnMap = [];

    protected $operatorMap = [
        'eq' => '=',
        'neq' => '!=',
        'gt' => '>',
        'gte' => '>=',
        'lt' => '<',
        'lte' => '<=',
        'like' => 'like',
        'in' => 'in',
        'between' => 'between',
    ];

    public function transform($request)
    {
        $eloQuery = [];
        /*
        Explanation of the code below:
            1. loop through the safeParams array
            2. check if the query param is set
            3. if it is set, check if the param is in the columnMap array
            4. if it is, use the value as the column name, otherwise use the param as the column name
            5. loop through the operators array
            6. check if the query param is set
            7. if it is set, check if the operator is in the operatorMap array
            8. if it is, use the value as the operator, otherwise use the operator as the operator
            9. add the column, operator, and query to the eloQuery array
        */
        foreach($this->safeParams as $param => $operators) {
            $query = $request->query($param);
            if(!isset($query)) {
                continue;
            }
            $column = $this->columnMap[$param] ?? $param;
            foreach($operators as $operator) {
                $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
            }
        }

        return $eloQuery;
    }
}