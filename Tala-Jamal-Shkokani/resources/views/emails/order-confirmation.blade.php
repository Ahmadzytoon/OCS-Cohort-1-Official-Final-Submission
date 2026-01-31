<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #000;
        }

        .hero {
            background: #fdfdfd;
            border: 1px solid #eee;
            padding: 30px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 30px;
        }

        .order-number {
            font-size: 14px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .items-table th {
            text-align: left;
            border-bottom: 2px solid #eee;
            padding: 10px 0;
            font-size: 12px;
            text-transform: uppercase;
            color: #888;
        }

        .items-table td {
            padding: 15px 0;
            border-bottom: 1px solid #f9f9f9;
        }

        .product-name {
            font-weight: bold;
            font-size: 14px;
            margin: 0;
        }

        .product-meta {
            font-size: 12px;
            color: #888;
        }

        .total-row td {
            padding-top: 20px;
            font-weight: bold;
            font-size: 18px;
        }

        .delivery-box {
            background: #000;
            color: #fff;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 30px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #aaa;
            margin-top: 40px;
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: #000;
            color: #fff;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo">CHIC & CO.</div>
        </div>

        <div class="hero">
            <h2 style="font-family: serif; font-size: 24px;">Thank you for your purchase, {{ $user->name }}</h2>
            <p>Your order for curated luxury is being prepared with elegance.</p>
            <div class="order-number">Order #{{ $order->order_number }}</div>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th style="text-align: center;">Qty</th>
                    <th style="text-align: right;">Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>
                            <p class="product-name">{{ $item->product->name }}</p>
                            @if($item->size || $item->color)
                                <span class="product-meta">
                                    @if($item->size) Size: {{ $item->size }} @endif
                                    @if($item->color) | Color: <span style="display:inline-block; width:10px; height:10px; border-radius:50%; background-color: {{$item->color}}; border: 1px solid #eee;"></span> @endif
                                </span>
                            @endif
                        </td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: right;">{{ number_format($item->price, 0) }} JOD</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="2">Total</td>
                    <td style="text-align: right;">{{ number_format($order->total_amount, 0) }} JOD</td>
                </tr>
            </tbody>
        </table>

        <div class="delivery-box">
            <p style="margin: 0; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Estimated Delivery
            </p>
            <h3 style="margin: 5px 0 0 0; font-size: 20px;">{{ $deliveryEstimate }}</h3>
            <p style="margin: 10px 0 0 0; font-size: 13px; opacity: 0.8;">Our courier will reach out to schedule your
                luxury arrival.</p>
        </div>

        <div style="text-align: center;">
            <a href="{{ route('dashboard') }}" class="btn">Track Your Order</a>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Chic & Co. Luxury Retailers. Amman, Jordan.</p>
            <p>If you have any questions, reply to this email or contact our concierge.</p>
        </div>
    </div>
</body>

</html>