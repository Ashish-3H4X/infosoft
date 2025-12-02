<x-app-layout>
    <div class="py-10 px-6 max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <p class="text-xs font-semibold tracking-[0.20em] text-slate-400 uppercase">
                    Overview
                </p>
                <h1 class="text-3xl font-bold text-slate-900 mt-1">Admin Dashboard</h1>
                <p class="text-sm text-slate-500 mt-1">
                    Welcome, {{ auth()->user()->name }}. Here’s your system summary.
                </p>
            </div>

            <a href="{{ route('admin.users.index') }}"
               class="inline-flex items-center px-5 py-2.5 rounded-xl bg-indigo-600 text-white 
                      shadow-sm hover:bg-indigo-700 transition font-medium text-sm">
                Manage Users
            </a>
        </div>

        {{-- Stats cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            
            <div class="bg-white/90 backdrop-blur border border-slate-100 shadow-sm rounded-2xl p-5">
                <p class="text-xs text-slate-500">Total Customers</p>
                <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $totalCustomers }}</p>
            </div>

            <div class="bg-white/90 backdrop-blur border border-slate-100 shadow-sm rounded-2xl p-5">
                <p class="text-xs text-slate-500">Total Invoices</p>
                <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $totalInvoices }}</p>
            </div>

            <div class="bg-white/90 backdrop-blur border border-slate-100 shadow-sm rounded-2xl p-5">
                <p class="text-xs text-slate-500">Paid Invoices</p>
                <p class="mt-2 text-3xl font-semibold text-green-600">{{ $paidInvoices }}</p>
            </div>

            <div class="bg-white/90 backdrop-blur border border-slate-100 shadow-sm rounded-2xl p-5">
                <p class="text-xs text-slate-500">Unpaid Invoices</p>
                <p class="mt-2 text-3xl font-semibold text-red-500">{{ $unpaidInvoices }}</p>
            </div>
        </div>

        {{-- Revenue + Recent invoices --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Revenue card --}}
            <div class="bg-white/90 backdrop-blur border border-slate-100 shadow-sm rounded-2xl p-6">
                <p class="text-xs text-slate-500">Total Revenue (Paid)</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">
                    ₹{{ number_format($totalRevenue, 2) }}
                </p>

                <div class="mt-6">
                    <p class="text-xs text-slate-500 mb-2">Revenue (Last Months)</p>
                    <canvas id="revenueChart" class="w-full h-40"></canvas>
                </div>
            </div>

            {{-- Recent invoices table --}}
            <div class="bg-white/90 backdrop-blur border border-slate-100 shadow-sm rounded-2xl p-6 lg:col-span-2">
                
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base font-semibold text-slate-900">Recent Invoices</h2>
                    <a href="{{ route('invoices.index') }}"
                       class="text-sm text-indigo-600 hover:underline">
                        View all
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                        <tr class="border-b text-xs text-slate-500">
                            <th class="py-2 text-left">Invoice #</th>
                            <th class="py-2 text-left">Customer</th>
                            <th class="py-2 text-left">Date</th>
                            <th class="py-2 text-right">Total</th>
                            <th class="py-2 text-center">Status</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($recentInvoices as $invoice)
                            <tr class="border-b last:border-0 hover:bg-slate-50/60 transition">
                                <td class="py-2">
                                    <a href="{{ route('invoices.show', $invoice->id) }}"
                                       class="text-indigo-600 hover:underline text-xs">
                                        {{ $invoice->invoice_no }}
                                    </a>
                                </td>
                                <td class="py-2 text-xs text-slate-700">
                                    {{ $invoice->customer->name ?? 'N/A' }}
                                </td>
                                <td class="py-2 text-xs text-slate-700">
                                    {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}
                                </td>
                                <td class="py-2 text-right text-xs text-slate-800">
                                    ₹{{ number_format($invoice->total, 2) }}
                                </td>
                                <td class="py-2 text-center">
                                    @if($invoice->status === 'paid')
                                        <span class="inline-flex px-2 py-1 rounded-full text-[10px] font-medium 
                                                     bg-green-100 text-green-700">
                                            Paid
                                        </span>
                                    @else
                                        <span class="inline-flex px-2 py-1 rounded-full text-[10px] font-medium 
                                                     bg-yellow-100 text-yellow-700">
                                            Unpaid
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5"
                                    class="py-4 text-center text-xs text-slate-400">
                                    No invoices found.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>

    {{-- Chart CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const revenueData = @json($monthlyRevenue->pluck('total'));
        const revenueLabels = @json($monthlyRevenue->pluck('month'));

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: revenueLabels,
                datasets: [{
                    label: 'Revenue',
                    data: revenueData,
                    fill: false,
                    borderColor: '#6366f1',
                    backgroundColor: '#6366f1',
                    tension: 0.4,
                    borderWidth: 2,
                    pointRadius: 3
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: {
                    x: { ticks: { font: { size: 11 } } },
                    y: { ticks: { font: { size: 11 } } }
                }
            }
        });
    </script>

</x-app-layout>
