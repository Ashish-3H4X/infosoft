<x-app-layout>
    <div class="py-8 px-6 max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold">Admin Dashboard</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Welcome, {{ auth()->user()->name }}. Here’s a quick overview of your system.
                </p>
            </div>

            <a href="{{ route('admin.users.index') }}"
               class="inline-flex items-center px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
                Manage Users
            </a>
        </div>

        {{-- Stats cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white shadow-sm rounded-xl p-4">
                <p class="text-xs text-gray-500">Total Customers</p>
                <p class="mt-2 text-2xl font-semibold">{{ $totalCustomers }}</p>
            </div>

            <div class="bg-white shadow-sm rounded-xl p-4">
                <p class="text-xs text-gray-500">Total Invoices</p>
                <p class="mt-2 text-2xl font-semibold">{{ $totalInvoices }}</p>
            </div>

            <div class="bg-white shadow-sm rounded-xl p-4">
                <p class="text-xs text-gray-500">Paid Invoices</p>
                <p class="mt-2 text-2xl font-semibold text-green-600">{{ $paidInvoices }}</p>
            </div>

            <div class="bg-white shadow-sm rounded-xl p-4">
                <p class="text-xs text-gray-500">Unpaid Invoices</p>
                <p class="mt-2 text-2xl font-semibold text-red-600">{{ $unpaidInvoices }}</p>
            </div>
        </div>

        {{-- Revenue + Recent invoices --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Revenue card --}}
            <div class="bg-white shadow-sm rounded-xl p-4 lg:col-span-1">
                <p class="text-xs text-gray-500">Total Revenue (Paid)</p>
                <p class="mt-2 text-3xl font-semibold">
                    ₹{{ number_format($totalRevenue, 2) }}
                </p>

                <div class="mt-6">
                    <p class="text-xs text-gray-500 mb-2">Revenue (last months)</p>
                    <canvas id="revenueChart" class="w-full h-40"></canvas>
                </div>
            </div>

            {{-- Recent invoices table --}}
            <div class="bg-white shadow-sm rounded-xl p-4 lg:col-span-2">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-sm font-semibold text-gray-700">Recent Invoices</h2>
                    <a href="{{ route('invoices.index') }}" class="text-xs text-indigo-600 hover:underline">
                        View all
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                        <tr class="border-b text-xs text-gray-500">
                            <th class="py-2 text-left">Invoice #</th>
                            <th class="py-2 text-left">Customer</th>
                            <th class="py-2 text-left">Date</th>
                            <th class="py-2 text-right">Total</th>
                            <th class="py-2 text-center">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($recentInvoices as $invoice)
                            <tr class="border-b last:border-0">
                                <td class="py-2">
                                    <a href="{{ route('invoices.show', $invoice->id) }}"
                                       class="text-indigo-600 hover:underline text-xs">
                                        {{ $invoice->invoice_no }}
                                    </a>
                                </td>
                                <td class="py-2 text-xs">
                                    {{ $invoice->customer->name ?? 'N/A' }}
                                </td>
                                <td class="py-2 text-xs">
                                    {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}
                                </td>
                                <td class="py-2 text-right text-xs">
                                    ₹{{ number_format($invoice->total, 2) }}
                                </td>
                                <td class="py-2 text-center">
                                    @if($invoice->status === 'paid')
                                        <span class="inline-flex px-2 py-1 rounded-full text-[10px] font-medium bg-green-100 text-green-700">
                                            Paid
                                        </span>
                                    @else
                                        <span class="inline-flex px-2 py-1 rounded-full text-[10px] font-medium bg-yellow-100 text-yellow-700">
                                            Unpaid
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-xs text-gray-400">
                                    No invoices yet.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Simple chart using Chart.js (CDN) --}}
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
                    tension: 0.3
                }]
            },
            options: {
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: { ticks: { font: { size: 10 } } },
                    y: { ticks: { font: { size: 10 } } }
                }
            }
        });
    </script>
</x-app-layout>
