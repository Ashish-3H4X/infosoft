<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        // High level stats
        $totalCustomers   = Customer::count();
        $totalInvoices    = Invoice::count();
        $paidInvoices     = Invoice::where('status', 'paid')->count();
        $unpaidInvoices   = Invoice::where('status', 'unpaid')->count();
        $totalRevenue     = Invoice::where('status', 'paid')->sum('total');

        // Recent invoices
        $recentInvoices = Invoice::with('customer')
            ->latest()
            ->take(5)
            ->get();

        // Simple monthly revenue for last 6 months (for chart)
        $monthlyRevenue = Invoice::selectRaw('DATE_FORMAT(invoice_date, "%Y-%m") as month, SUM(total) as total')
            ->where('status', 'paid')
            ->groupBy('month')
            ->orderBy('month')
            ->take(6)
            ->get();

        return view('admin.dashboard', [
            'totalCustomers' => $totalCustomers,
            'totalInvoices'  => $totalInvoices,
            'paidInvoices'   => $paidInvoices,
            'unpaidInvoices' => $unpaidInvoices,
            'totalRevenue'   => $totalRevenue,
            'recentInvoices' => $recentInvoices,
            'monthlyRevenue' => $monthlyRevenue,
        ]);
    }
}
