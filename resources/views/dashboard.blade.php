<x-app-layout>

    <div class="py-10 px-6 max-w-7xl mx-auto">

        {{-- Greeting Card --}}
        <div class="bg-white/90 backdrop-blur border border-slate-100 rounded-2xl p-6 shadow-sm">
            <p class="text-xs font-semibold tracking-[0.20em] text-slate-400 uppercase">
                Overview
            </p>

            <h1 class="text-3xl font-bold text-slate-900 mt-1">
                Hello, {{ auth()->user()->name }}
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Here’s a quick overview of your business.
            </p>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-10">

            <div class="bg-white/90 backdrop-blur border border-slate-100 shadow-sm rounded-2xl p-5">
                <p class="text-xs text-slate-500">Customers</p>
                <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $totalCustomers }}</p>
            </div>

            <div class="bg-white/90 backdrop-blur border border-slate-100 shadow-sm rounded-2xl p-5">
                <p class="text-xs text-slate-500">Services</p>
                <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $totalServices }}</p>
            </div>

            <div class="bg-white/90 backdrop-blur border border-slate-100 shadow-sm rounded-2xl p-5">
                <p class="text-xs text-slate-500">Invoices</p>
                <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $totalInvoices }}</p>
            </div>

            <div class="bg-white/90 backdrop-blur border border-slate-100 shadow-sm rounded-2xl p-5">
                <p class="text-xs text-slate-500">Paid Invoices</p>
                <p class="mt-2 text-3xl font-semibold text-green-600">{{ $paidInvoices }}</p>
            </div>

        </div>

        {{-- Quick Actions --}}
        <div class="mt-12">
            <h3 class="text-sm font-semibold tracking-wide uppercase text-slate-600 mb-4">
                Quick Actions
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

                <a href="{{ route('customers.index') }}"
                   class="bg-white/90 backdrop-blur border border-slate-100 rounded-2xl p-5 text-center 
                          shadow-sm hover:bg-slate-50 transition text-slate-800 font-medium">
                    Customers
                </a>

                <a href="{{ route('services.index') }}"
                   class="bg-white/90 backdrop-blur border border-slate-100 rounded-2xl p-5 text-center 
                          shadow-sm hover:bg-slate-50 transition text-slate-800 font-medium">
                    Services
                </a>

                <a href="{{ route('invoices.create') }}"
                   class="bg-indigo-600 text-white rounded-2xl p-5 text-center shadow-sm hover:bg-indigo-700 
                          transition font-medium">
                    New Invoice
                </a>

            </div>
        </div>

    </div>

</x-app-layout>
