<?php

namespace App\Services\V1;

use Illuminate\Http\Request;

class CustomerQuery {
    protected $safeParms = [
        'name' => ['eq'],
        'type' => ['eq'],
        'email' => ['eq'],
        'address' => ['eq'],
        'city' => ['eq'],
        'state' => ['eq'],
        'postalCode' => ['eq','gt','lt']
    ];

    protected $columnMap = [
        'postalCode' => 'postal_code',
    ];

    protected $operatorMap = [
        'eq' => '=',
        'gt'=> '>',
        'lt'=> '<',
        'lte'=> '<=',
        'gte'=> '=>',
    ];

    // public function transform(Request $request){
    //     $eloQuery = [];

    //     foreach($this->safeParms as $parm => $operators){
    //         $query = $request->query($parm);

    //         if(!isset($query)){
    //             continue;
    //         }

    //         $column = $this->columnMap[$parm] ?? $parm;

    //         foreach ($operators as $operator){
    //             $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
    //         }
    //     }


    //     return $eloQuery;
    // }
    public function transform(Request $request)
    {
        $eloQuery = [];

        foreach ($this->safeParms as $parm => $operators) {
            if (!$request->has($parm)) {
                continue;
            }

            $query = $request->input($parm);
            $column = $this->columnMap[$parm] ?? $parm;

            foreach ($operators as $operator) {
                if (isset($query[$operator])) {
                    $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
                } else {
                    // Handle the case where the operator is missing in the query
                    // You can log an error or throw an exception as needed.
                }
            }
        }

        return $eloQuery;
    }

}
?>
