<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Checkout</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

  <style>
    /* ===== Quick theme for checkout (matches your pricing look) ===== */
    .checkout-wrap{
      padding:70px 0;
      background: #fbfbfc;
      min-height: 100vh;
    }
    .checkout-card{
      max-width: 980px;
      margin: 0 auto;
      padding: 28px;
      border: 1px solid rgba(0,0,0,.08);
      border-radius: 18px;
      background: #fff;
      box-shadow: 0 12px 30px rgba(0,0,0,.06);
    }
    .checkout-title{
      font-size: 44px;
      font-weight: 800;
      letter-spacing: .3px;
      color: #1f2937;
      text-align: center;
      margin: 0 0 10px;
    }
    .checkout-subtitle{
      text-align:center;
      color:#6b7280;
      margin: 0 0 26px;
      font-size: 16px;
    }

    .alert-success{
      margin: 14px auto 18px;
      padding: 12px 14px;
      border: 1px solid rgba(34,197,94,.35);
      background: rgba(34,197,94,.08);
      border-radius: 12px;
      color: #14532d;
      display:flex;
      align-items:center;
      gap:10px;
      max-width: 760px;
    }
    .alert-success .icon{
      width: 20px;
      height: 20px;
      border-radius: 6px;
      background: rgba(34,197,94,.18);
      display:flex;
      align-items:center;
      justify-content:center;
      font-weight: 900;
    }

    .pay-box{
      max-width: 760px;
      margin: 0 auto;
      padding: 18px 18px;
      border-radius: 16px;
      border: 1px solid rgba(0,0,0,.08);
      background: rgba(250, 204, 21, .08); /* soft gold */
    }
    .pay-box h3{
      margin:0 0 10px;
      font-size: 18px;
      color:#111827;
    }
    .pay-box ul{
      margin:0;
      padding-left: 18px;
      color:#374151;
      line-height: 1.7;
    }

    .checkout-actions{
      display:flex;
      justify-content:center;
      margin-top: 18px;
    }

    /* Button tweaks to match your gold style */
    .btn.btn-outline{
      border: 1px solid rgba(184, 134, 11, .55);
      color: #b8860b;
      background: transparent;
      padding: 12px 22px;
      border-radius: 12px;
      font-weight: 700;
      text-decoration: none;
      display: inline-block;
    }
    .btn.btn-outline:hover{
      background: rgba(250, 204, 21, .12);
    }

    @media (max-width: 768px){
      .checkout-title{ font-size: 32px; }
      .checkout-card{ padding: 18px; border-radius: 14px; }
      .pay-box{ padding: 14px; border-radius: 14px; }
    }
  </style>
</head>
<body>

  <section class="checkout-wrap">
    <div class="checkout-card">

      <h2 class="checkout-title">Complete Your Payment</h2>
      <p class="checkout-subtitle">
        Payments will be enabled soon. For now, please contact us to confirm your subscription.
      </p>

      @if(session('success'))
        <div class="alert-success">
          <div class="icon">✓</div>
          <div>{{ session('success') }}</div>
        </div>
      @endif

      <div class="pay-box">
        <h3>Temporary payment method</h3>
        <ul>
          <li>WhatsApp: <strong>+962 XXX XXX XXX</strong></li>
          <li>Email: <strong>support@yourdomain.com</strong></li>
          <li>After payment confirmation, your plan will be activated.</li>
        </ul>
      </div>

      <div class="checkout-actions">
        <a href="{{ route('pricing') }}" class="btn btn-outline">Back to Pricing</a>
      </div>

    </div>
  </section>

</body>
</html>
