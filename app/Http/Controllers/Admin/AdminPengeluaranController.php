<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengeluaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminPengeluaranController extends Controller
{
    public function index(Request $request)
    {
        // Filter tanggal
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : Carbon::now()->startOfMonth();
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : Carbon::now()->endOfDay();
        
        // Filter kategori
        $kategori = $request->input('kategori', 'all'); // 'all', 'pribadi', 'toko'
        
        // Base query
        $query = Pengeluaran::whereBetween('created_at', [$startDate, $endDate]);
            
        if ($kategori !== 'all') {
            $query->where('kategori', $kategori);
        }
        
        $pengeluarans = $query->orderBy('created_at', 'desc')->paginate(10);
        
        $totalPengeluaran = $query->sum('harga');
        
        $summaryByKategori = [
            'pribadi' => Pengeluaran::whereBetween('created_at', [$startDate, $endDate])
                ->where('kategori', Pengeluaran::KATEGORI_PRIBADI)
                ->sum('harga'),
                
            'toko' => Pengeluaran::whereBetween('created_at', [$startDate, $endDate])
                ->where('kategori', Pengeluaran::KATEGORI_TOKO)
                ->sum('harga')
        ];
        
        return view('admin.pengeluaran.index', compact(
            'pengeluarans', 
            'totalPengeluaran', 
            'summaryByKategori',
            'startDate',
            'endDate',
            'kategori'
        ));
    }
    
    public function create()
    {
        return view('admin.pengeluaran.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'kategori' => 'required|in:pribadi,toko',
            'harga' => 'required|integer|min:1',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle file upload with move()
        $file = $request->file('bukti_pembayaran');
        $fileName = time() . '_' . Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
        
        $destinationPath = storage_path('app/public/bukti_pembayaran');
        
        // Ensure directory exists
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
        
        // Move file to destination
        $file->move($destinationPath, $fileName);

        // Create record
        Pengeluaran::create([
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'bukti_pembayaran' => $fileName,
        ]);

        return redirect()->route('admin.pengeluaran.index')
            ->with('success', 'Data pengeluaran berhasil ditambahkan.');
    }
    
    public function show($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        return view('admin.pengeluaran.show', compact('pengeluaran'));
    }
    
    public function edit($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        return view('admin.pengeluaran.edit', compact('pengeluaran'));
    }
    
    public function update(Request $request, $id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:pribadi,toko',
            'harga' => 'required|integer|min:1',
            'bukti_pembayaran' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        $data = $request->only(['nama', 'kategori', 'harga']);
        
        // Handle file upload if exists
        if ($request->hasFile('bukti_pembayaran')) {
            try {
                // Delete old file if exists
                if ($pengeluaran->bukti_pembayaran) {
                    $oldFilePath = storage_path('app/public/bukti_pembayaran/'.$pengeluaran->bukti_pembayaran);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                
                // Upload new file with move()
                $file = $request->file('bukti_pembayaran');
                $fileName = time() . '_' . Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
                
                $destinationPath = storage_path('app/public/bukti_pembayaran');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                
                $file->move($destinationPath, $fileName);
                $data['bukti_pembayaran'] = $fileName;
                
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal mengunggah bukti pembayaran: ' . $e->getMessage());
            }
        }
        
        $pengeluaran->update($data);
        
        return redirect()->route('admin.pengeluaran.index')
            ->with('success', 'Data pengeluaran berhasil diperbarui.');
    }
    
    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        
        // Hapus bukti pembayaran
        if ($pengeluaran->bukti_pembayaran) {
            Storage::delete('public/bukti_pembayaran/' . $pengeluaran->bukti_pembayaran);
        }
        
        $pengeluaran->delete();
        
        return redirect()->route('admin.pengeluaran.index')
            ->with('success', 'Data pengeluaran berhasil dihapus.');
    }
    
    public function export(Request $request)
    {
        // Filter tanggal
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : Carbon::now()->startOfMonth();
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : Carbon::now()->endOfDay();
        
        // Filter kategori
        $kategori = $request->input('kategori', 'all');
        
        // Base query
        $query = Pengeluaran::whereBetween('created_at', [$startDate, $endDate]);
            
        // Filter berdasarkan kategori
        if ($kategori !== 'all') {
            $query->where('kategori', $kategori);
        }
        
        $pengeluarans = $query->orderBy('created_at', 'desc')->get();
        
        // Generate Excel file
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Header
        $sheet->setCellValue('A1', 'Laporan Pengeluaran');
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getFont()->setSize(14);
        
        $sheet->setCellValue('A2', 'Periode: ' . $startDate->format('d-m-Y') . ' s/d ' . $endDate->format('d-m-Y'));
        $sheet->mergeCells('A2:E2');
        
        // Table header
        $sheet->setCellValue('A4', 'ID');
        $sheet->setCellValue('B4', 'Tanggal');
        $sheet->setCellValue('C4', 'Nama');
        $sheet->setCellValue('D4', 'Kategori');
        $sheet->setCellValue('E4', 'Jumlah (Rp)');
        
        $sheet->getStyle('A4:E4')->getFont()->setBold(true);
        
        // Fill data
        $row = 5;
        $totalAmount = 0;
        
        foreach ($pengeluarans as $pengeluaran) {
            $sheet->setCellValue('A' . $row, $pengeluaran->id);
            $sheet->setCellValue('B' . $row, $pengeluaran->created_at->format('d/m/Y H:i'));
            $sheet->setCellValue('C' . $row, $pengeluaran->nama);
            $sheet->setCellValue('D' . $row, ucfirst($pengeluaran->kategori));
            $sheet->setCellValue('E' . $row, $pengeluaran->harga);
            
            $totalAmount += $pengeluaran->harga;
            $row++;
        }
        
        // Summary
        $row += 2;
        $sheet->setCellValue('A' . $row, 'Total Pengeluaran:');
        $sheet->setCellValue('E' . $row, $totalAmount);
        $sheet->getStyle('A' . $row . ':E' . $row)->getFont()->setBold(true);
        
        $row += 2;
        $sheet->setCellValue('A' . $row, 'Pengeluaran Pribadi:');
        $sheet->setCellValue('E' . $row, $pengeluarans->where('kategori', Pengeluaran::KATEGORI_PRIBADI)->sum('harga'));
        
        $row++;
        $sheet->setCellValue('A' . $row, 'Pengeluaran Toko:');
        $sheet->setCellValue('E' . $row, $pengeluarans->where('kategori', Pengeluaran::KATEGORI_TOKO)->sum('harga'));
        
        // Styling
        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Format currency
        $sheet->getStyle('E5:E' . ($row))->getNumberFormat()->setFormatCode('#,##0');
        
        // Create file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'Laporan_Pengeluaran_' . $startDate->format('d-m-Y') . '_' . $endDate->format('d-m-Y') . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
    }
}