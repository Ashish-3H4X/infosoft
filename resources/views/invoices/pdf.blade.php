<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $invoice->invoice_no }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container { width: 92%; margin: auto; }

        /* HEADER */
        .top-header {
            width: 100%;
            padding: 25px 0 10px 0;
            /* removed border */
        }

        .status-badge {
            background: #d4f8d4;
            color: #1a7f2a;
            padding: 6px 14px;
            border-radius: 18px;
            font-weight: bold;
            font-size: 13px;
            text-transform: uppercase;
        }

        /* DETAILS (NO BORDER) */
        .details-box {
            padding: 10px 5px;
            height: 115px;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 18px;
        }

        th {
            background: #f5f5f5;
            padding: 10px;
            border: 1px solid #ddd;
            font-weight: bold;
        }

        td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        /* SUMMARY */
        .summary-box {
            width: 38%;
            border: 1px solid #ddd;
            padding: 14px;
            float: right;
            margin-top: 15px;
            border-radius: 6px;
        }

        .summary-box td {
            border: none;
            padding: 8px 4px;
            font-size: 14px;
        }

        .total-bold {
            font-weight: bold;
            font-size: 16px;
        }
    </style>
</head>

<body>
<div class="container">

    <!-- HEADER -->
    <table class="top-header">
        <tr>
            <td>
                <h2 style="font-size: 22px; font-weight: bold;">Invoice #{{ $invoice->invoice_no }}</h2>
                <p>Date: {{ $invoice->invoice_date }}</p>
                <p>Due Date: {{ $invoice->due_date }}</p>
            </td>

            <td align="right" valign="top">
                @if($invoice->status == 'paid')
                    <span class="status-badge">PAID</span>
                @else
                    <span class="status-badge" style="background:#ffd6d6; color:#a00000;">UNPAID</span>
                @endif
            </td>
        </tr>
    </table>

    <br>

    <!-- DETAILS (NO BORDER) -->
    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <!-- Seller -->
            <td width="48%" class="details-box" valign="top">
                <h3>Your Details</h3>
                <p><strong>XYZ Seller</strong></p>
                <p>123 East Street, Orange County</p>
                <p>9876543210</p>
            </td>

            <td width="4%"></td>

            <!-- Client -->
            <td width="48%" class="details-box" valign="top">
                <h3>Client Details</h3>
                <p><strong>{{ $invoice->customer->name }}</strong></p>
                <p>{{ $invoice->customer->billing_address ?? 'No Billing Address' }}</p>
                <p>{{ $invoice->customer->email }}</p>
            </td>
        </tr>
    </table>

    <br><br>

    <h3 style="margin-top: 10px;">Invoice Items</h3>

    <!-- ITEMS -->
    <table>
        <thead>
        <tr>
            <th>Task</th>
            <th style="width: 60px;">Qty</th>
            <th style="width: 120px;">Rate</th>
            <th style="width: 140px;">Subtotal</th>
        </tr>
        </thead>

        <tbody>
        @foreach ($invoice->items as $item)
            <tr>
                <td>{{ $item->description }}</td>
                <td>{{ $item->quantity }}</td>
                <td>₹{{ number_format($item->unit_price, 2) }}</td>
                <td>₹{{ number_format($item->line_total, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- SUMMARY -->
    <div class="summary-box">
        <table width="100%">
            <tr>
                <td>Subtotal</td>
                <td align="right">₹{{ number_format($invoice->subtotal, 2) }}</td>
            </tr>
            <tr>
                <td>Tax</td>
                <td align="right">₹{{ number_format($invoice->tax_total, 2) }}</td>
            </tr>
            <tr class="total-bold">
                <td>Total</td>
                <td align="right">₹{{ number_format($invoice->total, 2) }}</td>
            </tr>
        </table>
    </div>

</div>
</body>
</html>
