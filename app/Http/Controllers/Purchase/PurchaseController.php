<?php

namespace App\Http\Controllers\Purchase;


use App\Enums\PurchaseStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Purchase\StorePurchaseRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetails;
use App\Models\Supplier;
use Carbon\Carbon;
use Exception;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Str;

class PurchaseController extends Controller
{
    public function index()
    {
        return view('purchases.index', [
            'purchases' => Purchase::where('user_id',auth()->id())->count()
        ]);
    }

    public function approvedPurchases()
    {
        $purchases = Purchase::with(['supplier'])
            ->where('status', PurchaseStatus::APPROVED)->get(); // 1 = approved

        return view('purchases.approved-purchases', [
            'purchases' => $purchases
        ]);
    }

    public function show($uuid)
    {
        $purchase = Purchase::where('id',$uuid)->firstOrFail();
        // N+1 Problem if load 'createdBy', 'updatedBy',
        $purchase->loadMissing(['supplier', 'details'])->get();

        $purchase->with(['supplier', 'details'])->get();
        $products = PurchaseDetails::where('purchase_id', $purchase->id)->get();

        return view('purchases.details-purchase', [
            'purchase' => $purchase,
            'products' => $products
        ]);
    }

    public function edit($uuid)
    {
        $purchase = Purchase::where('uuid',$uuid)->firstOrFail();
        // N+1 Problem if load 'createdBy', 'updatedBy',
        $purchase->with(['supplier', 'details'])->get();

        return view('purchases.edit', [
            'purchase' => $purchase
        ]);
    }

    public function create()
    {
        return view('purchases.create', [
            'categories' => Category::where('user_id',auth()->id())->select(['id', 'name'])->get(),
            'suppliers' => Supplier::where('user_id',auth()->id())->select(['id', 'name'])->get(),
        ]);
    }

    public function store(StorePurchaseRequest $request)
    {
        if (empty($request->invoiceProducts) || $request->invoiceProducts[0]['total'] == 0) {
            return redirect()
                ->back()
                ->with('error', 'Please add product!');
        }

        DB::beginTransaction();
        try {
            $purchase = Purchase::create([
                'purchase_no' => IdGenerator::generate([
                    'table' => 'purchases',
                    'field' => 'purchase_no',
                    'length' => 10,
                    'prefix' => 'PRS-'
                ]),
                'status' => PurchaseStatus::APPROVED->value,
                'created_by' => auth()->user()->id,
                'supplier_id' => $request->supplier_id,
                'date' => $request->date,
                'total_amount' => $request->total_amount,
                'uuid' => Str::uuid(),
                'user_id' => auth()->id()
            ]);

            foreach ($request->invoiceProducts as $product) {
                // Create purchase detail
                $purchase->details()->create([
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'],
                    'unitcost' => intval($product['unitcost']),
                    'total' => $product['total'],
                ]);

                // Update product quantity
                $this->updateProductQuantity($product['product_id'], $product['quantity']);
            }

            DB::commit();
            return redirect()
                ->route('purchases.index')
                ->with('success', 'Purchase has been created and inventory updated!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('error', 'Error occurred: ' . $e->getMessage());
        }
    }

    private function updateProductQuantity($productId, $quantity)
    {
        $product = Product::findOrFail($productId);

        if ($quantity <= 0) {
            throw new \Exception('Quantity must be greater than zero');
        }

        $product->update([
            'quantity' => DB::raw('quantity + ' . $quantity),
            'last_purchase_date' => now(),
        ]);
    }

    public function update($uuid)
    {
        $purchase =Purchase::where('uuid',$uuid)->firstOrFail();
        $products = PurchaseDetails::where('purchase_id', $purchase->id)->get();

        foreach ($products as $product)
        {
            Product::where('id', $product->product_id)
                    ->update(['quantity' => DB::raw('quantity+'.$product->quantity)]);
        }

        Purchase::findOrFail($purchase->id)
            ->update([
                'status' => PurchaseStatus::APPROVED,
                'updated_by' => auth()->user()->id
            ]);

        return redirect()
            ->back()
            ->with('success', 'Purchase has been approved!');
    }

    public function destroy($uuid)
    {
        $purchase = Purchase::where('uuid',$uuid)->firstOrFail();
        $purchase->delete();

        return redirect()
            ->route('purchases.index')
            ->with('success', 'Purchase has been deleted!');
    }


    public function purchaseReport()
    {
        $purchases = Purchase::with(['supplier'])
            //->where('status', 1)
            ->where('date', today()->format('Y-m-d'))
            ->get();

        return view('purchases.report-purchase', [
            'purchases' => $purchases
        ]);
    }

    public function getPurchaseReport()
    {
        return view('purchases.report-purchase');
    }

    public function exportPurchaseReport(Request $request)
{
    $rules = [
        'start_date' => 'required|string|date_format:Y-m-d',
        'end_date' => 'required|string|date_format:Y-m-d',
    ];

    $validatedData = $request->validate($rules);

    $sDate = $validatedData['start_date'];
    $eDate = $validatedData['end_date'];

    $purchases = DB::table('purchase_details')
        ->join('products', 'purchase_details.product_id', '=', 'products.id')
        ->join('purchases', 'purchase_details.purchase_id', '=', 'purchases.id')
        ->join('users', 'users.id', '=', 'purchases.created_by')
        ->join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id') // Join to get supplier details
        ->whereBetween('purchases.updated_at', [$sDate, $eDate])
        ->where('purchases.status', '1')
        ->select(
            'purchases.purchase_no',
            'purchases.updated_at',
            'suppliers.name as supplier_name', // Get the supplier name
            // 'products.code',
            'products.name',
            'purchase_details.quantity',
            // 'purchase_details.unitcost',
            'purchase_details.total',
            'users.name as created_by'
        )
        ->get();

    $purchase_array[] = array(
        'Tanggal',
        'ID Pembelian',
        'Supplier', // Change this to 'Supplier Name' if desired
        // 'Product Code',
        'Nama Produk',
        'Jumlah',
        // 'Unitcost',
        'Total',
        'Dibuat oleh'
    );

    foreach ($purchases as $purchase) {
        $purchase_array[] = array(
            'Date' => $purchase->updated_at,
            'No Purchase' => $purchase->purchase_no,
            'Supplier' => $purchase->supplier_name, // Use supplier name
            // 'Product Code' => $purchase->code,
            'Product' => $purchase->name,
            'Quantity' => $purchase->quantity,
            // 'Unitcost' => $purchase->unitcost,
            'Total' => $purchase->total,
            'Created By' => $purchase->created_by
        );
    }

    $this->exportExcel($purchase_array);
}


    public function exportExcel($products)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');

        try {
            $spreadSheet = new Spreadsheet();
            $spreadSheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
            $spreadSheet->getActiveSheet()->fromArray($products);
            $Excel_writer = new Xls($spreadSheet);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="purchase-report.xls"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $Excel_writer->save('php://output');
            exit();
        } catch (Exception $e) {
            return $e;
        }
    }
}
