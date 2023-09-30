<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Invoice;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\InvoiceResource;
use App\Http\Resources\V1\InvoiceCollection;
use App\Filters\V1\InvoiceFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Http\Requests\V1\BulkStoreInvoiceRequest;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new InvoiceFilter();
        $queryItems = $filter->transform($request);// [['column','oparator','value']]

        if(count($queryItems) == 0){
            return new InvoiceCollection(Invoice::paginate());
        }else{
            $invoices = Invoice::where($queryItems)->paginate();
            return new InvoiceCollection($invoices->appends($request->query()));
        }



    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return new InvoiceResource($invoice);
    }
    
    public function bulkStore(BulkStoreInvoiceRequest $request){
        // $bulk = collect($request->all())->map(function($arr, $key){
        //     return Arr::except($arr, ['customerId','billedDate','paidDate']);
        // });

        // Invoice::insert($bulk->toArray());
        return new InvoiceResource(Invoice::create($request->all()));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
