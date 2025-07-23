<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\ActivityLog;
use Carbon\Carbon;


class DashboardController extends Controller
{
    /**
     * Menampilkan ringkasan informasi untuk dashboard admin:
     * - Jumlah produk
     * - Jumlah transaksi masuk & keluar
     * - Grafik stok barang
     * - Aktivitas pengguna terbaru
     */
    public function summary(Request $request)
    {
        // 1. Total Produk
        $totalProducts = Product::count();

        // 2. Transaksi IN dan OUT (default: 30 hari terakhir)
        $startDate = $request->start_date ?? Carbon::now()->subDays(30)->toDateString();
        $endDate = $request->end_date ?? Carbon::now()->toDateString();

        $transactions = StockTransaction::select('type')
            ->selectRaw('COUNT(*) as total')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('type')
            ->get()
            ->pluck('total', 'type');

        $inCount = $transactions['IN'] ?? 0;
        $outCount = $transactions['OUT'] ?? 0;

        // 3. Grafik Stok Barang - Top 10 Produk dengan stok terbanyak
        $topStocks = Product::select('name', 'stock')
            ->orderByDesc('stock')
            ->limit(10)
            ->get();

        // 4. Aktivitas Pengguna Terbaru
        $latestActivities = ActivityLog::with('user:id,name')
            ->latest()
            ->limit(10)
            ->get(['id', 'user_id', 'action', 'model_type', 'model_id', 'created_at']);

        return response()->json([
            'total_products' => $totalProducts,
            'transaction_in' => $inCount,
            'transaction_out' => $outCount,
            'top_stocks' => $topStocks,
            'latest_activities' => $latestActivities,
        ]);
    }
}