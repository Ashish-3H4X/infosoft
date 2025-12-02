<x-layouts.admin :title="'Invoice Details'">

    <div class="bg-white p-6 rounded shadow">

        <!-- HEADER -->
        <div class="flex justify-between items-center border-b pb-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold">Invoice #{{ $invoice->invoice_no }}</h1>
                <p class="text-gray-600">Date: {{ $invoice->invoice_date }}</p>
                <p class="text-gray-600">Due Date: {{ $invoice->due_date }}</p>
            </div>

            <div>
                @if($invoice->status == 'paid')
                    <span class="px-4 py-2 bg-green-100 text-green-700 rounded-full font-semibold">
                        PAID
                    </span>
                @else
                    <span class="px-4 py-2 bg-red-100 text-red-700 rounded-full font-semibold">
                        UNPAID
                    </span>
                @endif
            </div>
        </div>

        <!-- CUSTOMER & SELLER DETAILS -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

            <!-- Seller -->
            <div class="p-4 border rounded bg-gray-50">
                <h2 class="text-lg font-semibold mb-2">Your Details</h2>
                <p class="font-bold text-gray-700">{{ $company_name ?? "XYZ Seller" }}</p>
                <p class="text-gray-600">{{ $company_address ?? "123 East Street, Orange County" }}</p>
                <p class="text-gray-600">{{ $company_contact ?? "9876543210" }}</p>
            </div>

            <!-- Customer -->
            <div class="p-4 border rounded bg-gray-50">
                <h2 class="text-lg font-semibold mb-2">Client Details</h2>
                <p class="font-bold text-gray-700">{{ $invoice->customer->name }}</p>
                <p>{{ $invoice->customer->billing_address ?? 'No Address Available' }}</p>
                <p class="text-gray-600">{{ $invoice->customer->email }}</p>
            </div>
        </div>

        <!-- ITEMS TABLE -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-4">Invoice Items</h2>

            <table class="w-full border-collapse border rounded overflow-hidden">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="p-3 border">Task</th>
                        <th class="p-3 border">Qty</th>
                        <th class="p-3 border">Rate</th>
                        <th class="p-3 border">Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($invoice->items as $item)
                        <tr class="border-b">
                            <td class="p-3 border">{{ $item->description }}</td>
                            <td class="p-3 border">{{ $item->quantity }}</td>
                            <td class="p-3 border">₹{{ number_format($item->unit_price, 2) }}</td>
                            <td class="p-3 border">₹{{ number_format($item->line_total, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-3 text-center text-gray-500">
                                No items found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- SUMMARY -->
        <div class="w-full md:w-1/3 ml-auto bg-gray-50 p-4 border rounded">
            <table class="w-full">
                <tr>
                    <td class="py-2 font-medium">Subtotal</td>
                    <td class="py-2 text-right">₹{{ number_format($invoice->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td class="py-2 font-medium">Tax</td>
                    <td class="py-2 text-right">₹{{ number_format($invoice->tax_total, 2) }}</td>
                </tr>
                <tr>
                    <td class="py-2 font-bold text-lg border-t mt-2">Total</td>
                    <td class="py-2 text-right font-bold text-lg border-t">
                        ₹{{ number_format($invoice->total, 2) }}
                    </td>
                </tr>
            </table>
        </div>

        <!-- ACTION BUTTONS -->
        <div class="flex gap-3 mt-8">

            <a href="{{ route('invoices.print', $invoice->id) }}"
               target="_blank"
               class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
               Print Invoice
            </a>

            <a href="{{ route('invoices.pdf', $invoice->id) }}"
               class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700">
               Download PDF
            </a>

            <a href="{{ route('invoices.edit', $invoice->id) }}"
               class="px-5 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
               Edit Invoice
            </a>

            <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST"
                  onsubmit="return confirm('Are you sure you want to delete this invoice?');">
                @csrf
                @method('DELETE')
                <button class="px-5 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Delete Invoice
                </button>
            </form>

            <a href="{{ route('invoices.index') }}"
               class="px-5 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
               Back
            </a>

        </div>

    </div>

</x-layouts.admin>
