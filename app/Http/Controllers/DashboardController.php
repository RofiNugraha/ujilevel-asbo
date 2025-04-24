<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kasir;
use App\Models\Pengeluaran;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\Layanan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        Log::info('Dashboard controller is running');
        
        try {
            // Get contact data
            $contacts = Contact::with('user:id,name,image,email')->latest()->paginate(10);
            
            // Financial metrics
            $totalIncome = (float) Kasir::where('status_transaksi', 'success')->sum('total_harga');
            $totalExpense = (float) Pengeluaran::sum('harga');
            $netProfit = $totalIncome - $totalExpense;

            // Customer counts
            $bookingCustomers = (int) Kasir::whereNotNull('booking_id')
                ->whereNotNull('user_id')
                ->distinct('user_id')
                ->count();
                
            $nonBookingCustomers = (int) Kasir::where(function($query) {
                $query->whereNull('booking_id')->orWhereNull('user_id');
            })->count();

            // Services count
            $totalServices = (int) Layanan::count();

            // Recent data
            $recentTransactions = Kasir::with('user')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            $recentExpenses = Pengeluaran::orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            // Process popular services
            $popularServices = $this->getPopularServices();

            // Monthly data
            $monthlyData = $this->getMonthlyData();

            return view('admin.dashboard', [
                'contacts' => $contacts,
                'totalIncome' => $totalIncome,
                'totalExpense' => $totalExpense,
                'netProfit' => $netProfit,
                'bookingCustomers' => $bookingCustomers,
                'nonBookingCustomers' => $nonBookingCustomers,
                'totalServices' => $totalServices,
                'recentTransactions' => $recentTransactions,
                'recentExpenses' => $recentExpenses,
                'popularServices' => $popularServices,
                'monthlyIncome' => $monthlyData['monthlyIncome'],
                'monthlyExpense' => $monthlyData['monthlyExpense'],
                'monthlyProfit' => $monthlyData['monthlyProfit'],
                'storeExpenses' => $monthlyData['storeExpenses'],
                'personalExpenses' => $monthlyData['personalExpenses'],
            ]);
            
        } catch (\Exception $e) {
            Log::error('Dashboard error: ' . $e->getMessage());
            
            return view('admin.dashboard', [
                'contacts' => collect(),
                'totalIncome' => 0,
                'totalExpense' => 0,
                'netProfit' => 0,
                'bookingCustomers' => 0,
                'nonBookingCustomers' => 0,
                'totalServices' => 0,
                'recentTransactions' => collect(),
                'recentExpenses' => collect(),
                'popularServices' => collect(),
                'monthlyIncome' => array_fill(0, 12, 0),
                'monthlyExpense' => array_fill(0, 12, 0),
                'monthlyProfit' => array_fill(0, 12, 0),
                'storeExpenses' => array_fill(0, 12, 0),
                'personalExpenses' => array_fill(0, 12, 0),
                'contacts',
            ]);
        }
    }

    private function getPopularServices()
    {
        try {
            $serviceCounter = [];
            $transactions = Kasir::where('status_transaksi', 'success')->get();

            foreach ($transactions as $transaction) {
                $layananIds = is_array($transaction->layanan_id) 
                    ? $transaction->layanan_id 
                    : (json_decode($transaction->layanan_id, true) ?? []);

                foreach ((array)$layananIds as $id) {
                    if ($layanan = Layanan::find($id)) {
                        $serviceName = $layanan->nama_layanan;
                        $serviceCounter[$serviceName] = ($serviceCounter[$serviceName] ?? 0) + 1;
                    }
                }
            }

            arsort($serviceCounter);
            return collect(array_slice($serviceCounter, 0, 5, true))
                ->map(function ($count, $name) {
                    return (object)['nama_layanan' => $name, 'count' => $count];
                });
                
        } catch (\Exception $e) {
            Log::error('Popular services error: ' . $e->getMessage());
            return collect();
        }
    }

    private function getMonthlyData()
    {
        try {
            $currentYear = Carbon::now()->year;
            $data = [
                'monthlyIncome' => [],
                'monthlyExpense' => [],
                'monthlyProfit' => [],
                'storeExpenses' => [],
                'personalExpenses' => []
            ];

            for ($month = 1; $month <= 12; $month++) {
                $start = Carbon::create($currentYear, $month, 1)->startOfMonth();
                $end = $start->copy()->endOfMonth();

                $income = (float) Kasir::where('status_transaksi', 'success')
                    ->whereBetween('created_at', [$start, $end])
                    ->sum('total_harga');
                    
                $expense = (float) Pengeluaran::whereBetween('created_at', [$start, $end])
                    ->sum('harga');
                    
                $storeExpense = (float) Pengeluaran::where('kategori', 'toko')
                    ->whereBetween('created_at', [$start, $end])
                    ->sum('harga');
                    
                $personalExpense = (float) Pengeluaran::where('kategori', 'pribadi')
                    ->whereBetween('created_at', [$start, $end])
                    ->sum('harga');

                $data['monthlyIncome'][] = $income;
                $data['monthlyExpense'][] = $expense;
                $data['monthlyProfit'][] = $income - $expense;
                $data['storeExpenses'][] = $storeExpense;
                $data['personalExpenses'][] = $personalExpense;
            }

            return $data;
            
        } catch (\Exception $e) {
            Log::error('Monthly data error: ' . $e->getMessage());
            return [
                'monthlyIncome' => array_fill(0, 12, 0),
                'monthlyExpense' => array_fill(0, 12, 0),
                'monthlyProfit' => array_fill(0, 12, 0),
                'storeExpenses' => array_fill(0, 12, 0),
                'personalExpenses' => array_fill(0, 12, 0)
            ];
        }
    }
}