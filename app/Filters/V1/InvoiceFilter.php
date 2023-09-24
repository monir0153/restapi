<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class InvoiceFilter extends ApiFilter{

    protected $safeParms = [
        'customer_id' => ['eq'],
        'amount' => ['eq','lt','gt','lte','gte'],
        'status' => ['eq','ne'],
        'billed_dated' => ['eq','lt','gt','lte','gte'],
        'paid_dated' => ['eq','lt','gt','lte','gte'],
    ];

    protected $columnMap = [
        'customerId' => 'customer_id',
        'billedDated' => 'billed_dated',
        'paidDated' => 'paid_dated',
    ];

    protected $operatorMap = [
        'eq' => '=',
        'gt'=> '>',
        'lt'=> '<',
        'lte'=> '<=',
        'gte'=> '>=',
        'ne' => '!='
    ];

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
