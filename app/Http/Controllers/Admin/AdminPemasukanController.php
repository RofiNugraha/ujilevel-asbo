<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kasir;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class AdminPemasukanController extends Controller
{
    public function index(Request $request) {
         // Filter tanggal
         $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : Carbon::now()->startOfMonth();
         $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : Carbon::now()->endOfDay();
         
         // Filter jenis customer
         $customerType = $request->input('customer_type', 'all'); // 'all', 'booking', 'non-booking'
         
         // Base query
         $query = Kasir::whereBetween('created_at', [$startDate, $endDate])
             ->where('status_transaksi', 'success');
             
         // Filter berdasarkan jenis customer
         if ($customerType === 'booking') {
             $query->whereNotNull('user_id')->whereNotNull('booking_id');
         } elseif ($customerType === 'non-booking') {
             $query->whereNull('user_id')->whereNull('booking_id');
         }
         
         // Data transaksi
         $transactions = $query->orderBy('created_at', 'desc')->paginate(10);
         
         // Menghitung total pemasukan
         $totalPemasukan = $query->sum('total_harga');
         
         // Summary berdasarkan jenis customer
         $summaryByCustomerType = [
             'booking' => Kasir::whereBetween('created_at', [$startDate, $endDate])
                 ->where('status_transaksi', 'success')
                 ->whereNotNull('user_id')
                 ->whereNotNull('booking_id')
                 ->sum('total_harga'),
                 
             'non_booking' => Kasir::whereBetween('created_at', [$startDate, $endDate])
                 ->where('status_transaksi', 'success')
                 ->whereNull('user_id')
                 ->whereNull('booking_id')
                 ->sum('total_harga')
         ];
         
         // Summary berdasarkan metode pembayaran
         $summaryByPaymentMethod = Kasir::whereBetween('created_at', [$startDate, $endDate])
             ->where('status_transaksi', 'success')
             ->groupBy('metode_pembayaran')
             ->select('metode_pembayaran', DB::raw('SUM(total_harga) as total'))
             ->pluck('total', 'metode_pembayaran')
             ->toArray();
         
         return view('admin.pemasukan.index', compact(
             'transactions', 
             'totalPemasukan', 
             'summaryByCustomerType', 
             'summaryByPaymentMethod',
             'startDate',
             'endDate',
             'customerType'
         ));
    } 

    public function export(Request $request)
    {
        // Filter tanggal
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : Carbon::now()->startOfMonth();
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : Carbon::now()->endOfDay();
        
        // Filter jenis customer
        $customerType = $request->input('customer_type', 'all');
        
        // Base query
        $query = Kasir::whereBetween('created_at', [$startDate, $endDate])
            ->where('status_transaksi', 'success');
            
        // Filter berdasarkan jenis customer
        if ($customerType === 'booking') {
            $query->whereNotNull('user_id')->whereNotNull('booking_id');
        } elseif ($customerType === 'non-booking') {
            $query->whereNull('user_id')->whereNull('booking_id');
        }
        
        $transactions = $query->orderBy('created_at', 'desc')->get();
        
        // Generate Excel file
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Header
        $sheet->setCellValue('A1', 'Laporan Pemasukan');
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getFont()->setSize(14);
        
        $sheet->setCellValue('A2', 'Periode: ' . $startDate->format('d-m-Y') . ' s/d ' . $endDate->format('d-m-Y'));
        $sheet->mergeCells('A2:F2');
        
        // Table header
        $sheet->setCellValue('A4', 'ID Transaksi');
        $sheet->setCellValue('B4', 'Tanggal');
        $sheet->setCellValue('C4', 'Jenis Customer');
        $sheet->setCellValue('D4', 'Booking ID');
        $sheet->setCellValue('E4', 'Metode Pembayaran');
        $sheet->setCellValue('F4', 'Total (Rp)');
        
        $sheet->getStyle('A4:F4')->getFont()->setBold(true);
        
        // Fill data
        $row = 5;
        $totalAmount = 0;
        
        foreach ($transactions as $transaction) {
            $sheet->setCellValue('A' . $row, $transaction->id);
            $sheet->setCellValue('B' . $row, $transaction->created_at->format('d/m/Y H:i'));
            $sheet->setCellValue('C' . $row, ($transaction->user_id && $transaction->booking_id) ? 'Booking' : 'Non-Booking');
            $sheet->setCellValue('D' . $row, $transaction->booking_id ?? '-');
            $sheet->setCellValue('E' . $row, $transaction->metode_pembayaran);
            $sheet->setCellValue('F' . $row, $transaction->total_harga);
            
            $totalAmount += $transaction->total_harga;
            $row++;
        }
        
        // Summary
        $row += 2;
        $sheet->setCellValue('A' . $row, 'Total Pemasukan:');
        $sheet->setCellValue('F' . $row, $totalAmount);
        $sheet->getStyle('A' . $row . ':F' . $row)->getFont()->setBold(true);
        
        // Styling
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Format currency
        $sheet->getStyle('F5:F' . ($row))->getNumberFormat()->setFormatCode('#,##0');
        
        // Create file
        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan_Pemasukan_' . $startDate->format('d-m-Y') . '_' . $endDate->format('d-m-Y') . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
    }
}