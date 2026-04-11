<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: 'Inter', 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f4f7f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .header {
            background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%);
            padding: 30px;
            text-align: center;
            color: #ffffff;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .content {
            padding: 40px;
            color: #374151;
            line-height: 1.6;
        }

        .content h2 {
            color: #111827;
            font-size: 20px;
            margin-top: 0;
        }

        .product-card {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
            display: flex;
            align-items: center;
        }

        .product-info {
            flex-grow: 1;
        }

        .product-title {
            font-weight: 600;
            color: #111827;
            display: block;
            font-size: 16px;
        }

        .stock-badge {
            display: inline-block;
            padding: 4px 12px;
            background-color: #fee2e2;
            color: #991b1b;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 8px;
        }

        .details {
            font-size: 14px;
            color: #6b7280;
            margin-top: 5px;
        }

        .button {
            display: inline-block;
            background-color: #4f46e5;
            color: #ffffff;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin-top: 20px;
            text-align: center;
        }

        .footer {
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
            background-color: #f9fafb;
            border-top: 1px solid #eeeeee;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Stock Alert</h1>
        </div>
        <div class="content">
            <h2>Inventory Notification</h2>
            <p>Hello <strong>{{ $product->user->name }}</strong>,</p>
            <p>One of your products has reached its low stock threshold. It's time to restock to ensure your customers
                can continue purchasing.</p>

            <div class="product-card">
                <div class="product-info">
                    <span class="product-title">{{ $product->title }}</span>
                    <div class="details">Current Stock: <strong>{{ $product->stock }}</strong></div>
                    <div class="details">Threshold: <strong>{{ $product->threshold }}</strong></div>
                    <span class="stock-badge">Low Stock Action Required</span>
                </div>
            </div>

            <p>Click the button below to manage your inventory in the dashboard.</p>

            <a href="{{ config('app.url') }}/dashboard/products" class="button">Go to Dashboard</a>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.<br>
            This is an automated notification, please do not reply.
        </div>
    </div>
</body>

</html>