<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class ProductExportController extends Controller
{
    public function create()
    {
        // $products = Product::with('category')->all()->sortBy('product_name');
        $products = Product::with('category')->get()->sortBy('product_name');


        $product_array[] = array(
            'Nama Produk',
            'Kategori',
            'Kode Produk',
            'Jumlah Stok',
            'Stok Minimum',
            'Harga Beli',
            'Harga Jual',
            'Gambar Produk',
            'Catatan'
        );

        foreach ($products as $product) {
            $product_array[] = array(
                $product->name,
                $product->category->name,
                $product->code,
                $product->quantity,
                $product->quantity_alert,
                $product->buying_price,
                $product->selling_price,
                $product->product_image,
                $product->notes
            );
        }

        $this->store($product_array);
    }

    public function store($products)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');

        try {
            $spreadSheet = new Spreadsheet();
            $spreadSheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
            $spreadSheet->getActiveSheet()->fromArray($products);
            $Excel_writer = new Xls($spreadSheet);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="daftar-produk.xls"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $Excel_writer->save('php://output');
            exit();
        } catch (Exception $e) {
            return;
        }
    }
}
