<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #ddd; }
        th { background-color: #f5f5f5; }
        .total-row { font-weight: bold; }
    </style>
</head>
<body>
<h1>Invoice #{{ $invoice->invoice_number }}</h1>

<div style="margin-bottom: 20px;">
    <h3>Bill To:</h3>
    <p>{{ $invoice->customer->name }}</p>
    <p>{{ $invoice->customer->email }}</p>
    <p>{{ $invoice->customer->phone }}</p>
</div>

<table>
    <thead>
    <tr>
        <th>Item</th>
        <th>Price</th>
        <th>Qty</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($invoice->items as $item)
        <tr>
            <td>{{ $item->product->name }}</td>
            <td>${{ number_format($item->price, 2) }}</td>
            <td>{{ $item->quantity }}</td>
            <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<div style="margin-top: 20px; float: right; width: 300px;">
    <p>Subtotal: ${{ number_format($invoice->subtotal, 2) }}</p>
    @if($invoice->discount)
        <p>Discount: -${{ number_format($invoice->discount, 2) }}</p>
    @endif
    <p>Tax ({{ $invoice->tax_rate }}%): ${{ number_format($invoice->tax_amount, 2) }}</p>
    <p class="total-row">Total: ${{ number_format($invoice->total_amount, 2) }}</p>
</div>
</body>
</html>
