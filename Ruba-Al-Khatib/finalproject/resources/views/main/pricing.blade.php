{{-- resources/views/main/pricing.blade.php --}}

@php
  $defaultTab = 'customer';
  if(auth()->check()){
    $defaultTab = auth()->user()->account_type; // customer | photographer | studio
  }

  $customerPlans     = $plans['customer'] ?? collect();
  $photographerPlans = $plans['photographer'] ?? collect();
  $studioPlans       = $plans['studio'] ?? collect();

  $p_customer_basic   = $customerPlans->firstWhere('code', 'basic');
  $p_customer_premium = $customerPlans->firstWhere('code', 'premium');
  $p_customer_vip     = $customerPlans->firstWhere('code', 'vip');

  $p_photo_free    = $photographerPlans->firstWhere('code', 'free');
  $p_photo_pro     = $photographerPlans->firstWhere('code', 'pro');
  $p_photo_premium = $photographerPlans->firstWhere('code', 'premium');

  $p_studio_starter = $studioPlans->firstWhere('code', 'starter');
  $p_studio_pro     = $studioPlans->firstWhere('code', 'pro');
  $p_studio_premium = $studioPlans->firstWhere('code', 'premium');

  $isLoggedIn = auth()->check();
  $userType = auth()->user()->account_type ?? null;

  // Current subscription + plan (for "Current Plan" button + summary)
  $activeSub = null;
  $currentPlanId = null;
  $currentPlanName = null;
  $currentPlanPrice = null;

  if($isLoggedIn){
    $activeSub = auth()->user()->activeSubscription()->with('plan')->first();
    if($activeSub && $activeSub->plan){
      $currentPlanId = $activeSub->plan->id;
      $currentPlanName = $activeSub->plan->name;
      $currentPlanPrice = $activeSub->plan->price_jod;
    }
  }
@endphp

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Pricing</title>

  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<style>
    .pricing-container[data-pricing-content]{
  display: none;
}

.pricing-container.is-active{
  display: grid;
}

    </style>
<body>

  <!-- Pricing -->
  <section class="pricing" style="padding-top:60px;">
    <div class="containerr">
      <div class="section-titlee">
        <h2>Simple & Transparent Pricing</h2>
        <p>Clear plans, no hidden fees — choose what fits your needs.</p>
      </div>

      {{-- Current plan summary --}}
      @if($isLoggedIn && $currentPlanId)
        <div style="margin:10px 0 14px; padding:12px 14px; border:1px solid rgba(0, 0, 0, 0.84); border-radius:12px; background:rgba(0, 0, 0, 0.77);">
          <strong>Your current plan:</strong>
          {{ $currentPlanName }} — {{ $currentPlanPrice }} JOD
        </div>
      @endif

      {{-- Flash messages (better look) --}}
      @if(session('success'))
        <div style="margin:12px 0; padding:12px 14px; border:1px solid rgba(34, 197, 94, 0.93); background:rgba(34, 197, 94, 0.84); border-radius:12px;">
          {{ session('success') }}
        </div>
      @endif

      @if(session('error'))
        <div style="margin:12px 0; padding:12px 14px; border:1px solid rgba(239, 68, 68, 0.98); background:rgba(239, 68, 68, 0.89); border-radius:12px;">
          {{ session('error') }}
        </div>
      @endif

      <div class="pricing-tabs">
        <button class="tab-btn {{ $defaultTab === 'customer' ? 'active' : '' }}" data-pricing="customer">For Clients</button>
        <button class="tab-btn {{ $defaultTab === 'photographer' ? 'active' : '' }}" data-pricing="photographer">For Photographers</button>
        <button class="tab-btn {{ $defaultTab === 'studio' ? 'active' : '' }}" data-pricing="studio">For Studios</button>
      </div>

      <!-- ===================== -->
      <!-- CUSTOMERS PRICING -->
      <!-- ===================== -->
     <div class="pricing-container {{ $defaultTab === 'customer' ? 'is-active' : '' }}"
     data-pricing-content="customer">
        {{-- Basic --}}
        <div class="pricing-card">
          <div class="pricing-header">
            <h3>Basic</h3>
            <div class="price">0 JOD</div>
            <p>Free forever</p>
          </div>

          <ul class="pricing-features">
            <li><i class="fas fa-check"></i> Browse photographers & studios</li>
            <li><i class="fas fa-check"></i> View portfolios & services</li>
            <li><i class="fas fa-check"></i> Basic search & filters</li>
            <li><i class="fas fa-check"></i> Request a booking</li>
            <li class="disabled"><i class="fas fa-times"></i> Priority booking</li>
            <li class="disabled"><i class="fas fa-times"></i> Booking protection</li>
          </ul>

          @if(!$isLoggedIn)
            <a href="{{ route('login') }}" class="btn btn-outline">Login to Get Started</a>
          @elseif($userType !== 'customer')
            <button class="btn btn-outline" disabled>Available for Customers only</button>
          @elseif(!$p_customer_basic)
            <button class="btn btn-outline" disabled>Plan unavailable</button>
          @elseif($currentPlanId === $p_customer_basic->id)
            <button class="btn btn-outline" disabled>Current Plan</button>
          @else
            <form action="{{ route('subscribe') }}" method="POST">
              @csrf
              <input type="hidden" name="plan_id" value="{{ $p_customer_basic->id }}">
              <button type="submit" class="btn btn-outline">Get Started</button>
            </form>
          @endif
        </div>

        {{-- Premium --}}
        <div class="pricing-card popular">
          <div class="popular-badge">Best Value</div>
          <div class="pricing-header">
            <h3>Premium</h3>
            <div class="price">4 JOD<span>/month</span></div>
            <p>Cancel anytime</p>
          </div>

          <ul class="pricing-features">
            <li><i class="fas fa-check"></i> Everything in Basic</li>
            <li><i class="fas fa-check"></i> Priority booking slots</li>
            <li><i class="fas fa-check"></i> Advanced filters</li>
            <li><i class="fas fa-check"></i> Booking protection</li>
            <li><i class="fas fa-check"></i> Easier rescheduling</li>
            <li><i class="fas fa-check"></i> Faster support</li>
          </ul>

          @if(!$isLoggedIn)
            <a href="{{ route('login') }}" class="btn btn-primary">Login to Subscribe</a>
          @elseif($userType !== 'customer')
            <button class="btn btn-primary" disabled>Available for Customers only</button>
          @elseif(!$p_customer_premium)
            <button class="btn btn-primary" disabled>Plan unavailable</button>
          @elseif($currentPlanId === $p_customer_premium->id)
            <button class="btn btn-primary" disabled>Current Plan</button>
          @else
            <form action="{{ route('subscribe') }}" method="POST">
              @csrf
              <input type="hidden" name="plan_id" value="{{ $p_customer_premium->id }}">
              <button type="submit" class="btn btn-primary">Choose Premium</button>
            </form>
          @endif
        </div>

        {{-- VIP --}}
        <div class="pricing-card">
          <div class="pricing-header">
            <h3>VIP</h3>
            <div class="price">8 JOD<span>/month</span></div>
            <p>For frequent bookings</p>
          </div>

          <ul class="pricing-features">
            <li><i class="fas fa-check"></i> Everything in Premium</li>
            <li><i class="fas fa-check"></i> Highest priority booking</li>
            <li><i class="fas fa-check"></i> Dedicated support</li>
            <li><i class="fas fa-check"></i> Exclusive deals (limited)</li>
            <li><i class="fas fa-check"></i> Faster confirmations</li>
            <li><i class="fas fa-check"></i> Early access to new studios</li>
          </ul>

          @if(!$isLoggedIn)
            <a href="{{ route('login') }}" class="btn btn-outline">Login to Subscribe</a>
          @elseif($userType !== 'customer')
            <button class="btn btn-outline" disabled>Available for Customers only</button>
          @elseif(!$p_customer_vip)
            <button class="btn btn-outline" disabled>Plan unavailable</button>
          @elseif($currentPlanId === $p_customer_vip->id)
            <button class="btn btn-outline" disabled>Current Plan</button>
          @else
            <form action="{{ route('subscribe') }}" method="POST">
              @csrf
              <input type="hidden" name="plan_id" value="{{ $p_customer_vip->id }}">
              <button type="submit" class="btn btn-outline">Go VIP</button>
            </form>
          @endif
        </div>
      </div>

      <!-- ===================== -->
      <!-- PHOTOGRAPHERS PRICING -->
      <!-- ===================== -->
      <div class="pricing-container {{ $defaultTab === 'photographer' ? 'is-active' : '' }}"
     data-pricing-content="photographer">

        {{-- Free --}}
        <div class="pricing-card">
          <div class="pricing-header">
            <h3>Free</h3>
            <div class="price">0 JOD</div>
            <p>Start listing & test the platform</p>
          </div>

          <ul class="pricing-features">
            <li><i class="fas fa-check"></i> Basic public profile</li>
            <li><i class="fas fa-check"></i> Portfolio (up to 8 photos)</li>
            <li><i class="fas fa-check"></i> Receive up to 2 booking requests / month</li>
            <li><i class="fas fa-check"></i> Basic booking management</li>
            <li class="disabled"><i class="fas fa-times"></i> Client chat & quick replies</li>
            <li class="disabled"><i class="fas fa-times"></i> Featured listing & analytics</li>
          </ul>

          @if(!$isLoggedIn)
            <a href="{{ route('login') }}" class="btn btn-outline">Login to Start</a>
          @elseif($userType !== 'photographer')
            <button class="btn btn-outline" disabled>Available for Photographers only</button>
          @elseif(!$p_photo_free)
            <button class="btn btn-outline" disabled>Plan unavailable</button>
          @elseif($currentPlanId === $p_photo_free->id)
            <button class="btn btn-outline" disabled>Current Plan</button>
          @else
            <form action="{{ route('subscribe') }}" method="POST">
              @csrf
              <input type="hidden" name="plan_id" value="{{ $p_photo_free->id }}">
              <button type="submit" class="btn btn-outline">Start Free</button>
            </form>
          @endif
        </div>

        {{-- Pro --}}
        <div class="pricing-card popular">
          <div class="popular-badge">Most Popular</div>
          <div class="pricing-header">
            <h3>Pro</h3>
            <div class="price">12 JOD<span>/month</span></div>
            <p>For photographers who book regularly</p>
          </div>

          <ul class="pricing-features">
            <li><i class="fas fa-check"></i> Unlimited portfolio & services</li>
            <li><i class="fas fa-check"></i> Full calendar & availability</li>
            <li><i class="fas fa-check"></i> Unlimited booking requests</li>
            <li><i class="fas fa-check"></i> Client chat + notifications</li>
            <li><i class="fas fa-check"></i> Lower platform commission</li>
            <li><i class="fas fa-check"></i> Reviews & social proof tools</li>
          </ul>

          @if(!$isLoggedIn)
            <a href="{{ route('login') }}" class="btn btn-primary">Login to Subscribe</a>
          @elseif($userType !== 'photographer')
            <button class="btn btn-primary" disabled>Available for Photographers only</button>
          @elseif(!$p_photo_pro)
            <button class="btn btn-primary" disabled>Plan unavailable</button>
          @elseif($currentPlanId === $p_photo_pro->id)
            <button class="btn btn-primary" disabled>Current Plan</button>
          @else
            <form action="{{ route('subscribe') }}" method="POST">
              @csrf
              <input type="hidden" name="plan_id" value="{{ $p_photo_pro->id }}">
              <button type="submit" class="btn btn-primary">Go Pro</button>
            </form>
          @endif
        </div>

        {{-- Premium --}}
        <div class="pricing-card">
          <div class="pricing-header">
            <h3>Premium</h3>
            <div class="price">25 JOD<span>/month</span></div>
            <p>Boost visibility & grow faster</p>
          </div>

          <ul class="pricing-features">
            <li><i class="fas fa-check"></i> Everything in Pro</li>
            <li><i class="fas fa-check"></i> Featured badge & priority listing</li>
            <li><i class="fas fa-check"></i> Advanced analytics & insights</li>
            <li><i class="fas fa-check"></i> Custom booking page</li>
            <li><i class="fas fa-check"></i> Lowest platform commission</li>
            <li><i class="fas fa-check"></i> Priority support</li>
          </ul>

          @if(!$isLoggedIn)
            <a href="{{ route('login') }}" class="btn btn-outline">Login to Subscribe</a>
          @elseif($userType !== 'photographer')
            <button class="btn btn-outline" disabled>Available for Photographers only</button>
          @elseif(!$p_photo_premium)
            <button class="btn btn-outline" disabled>Plan unavailable</button>
          @elseif($currentPlanId === $p_photo_premium->id)
            <button class="btn btn-outline" disabled>Current Plan</button>
          @else
            <form action="{{ route('subscribe') }}" method="POST">
              @csrf
              <input type="hidden" name="plan_id" value="{{ $p_photo_premium->id }}">
              <button type="submit" class="btn btn-outline">Become Premium</button>
            </form>
          @endif
        </div>
      </div>

      <!-- ===================== -->
      <!-- STUDIOS PRICING -->
      <!-- ===================== -->
      <div class="pricing-container {{ $defaultTab === 'studio' ? 'is-active' : '' }}"
     data-pricing-content="studio">

        {{-- Starter --}}
        <div class="pricing-card">
          <div class="pricing-header">
            <h3>Starter</h3>
            <div class="price">20 JOD<span>/month</span></div>
            <p>Perfect for a small studio</p>
          </div>

          <ul class="pricing-features">
            <li><i class="fas fa-check"></i> Studio profile + services</li>
            <li><i class="fas fa-check"></i> 1 calendar (single schedule)</li>
            <li><i class="fas fa-check"></i> Up to 2 team members</li>
            <li><i class="fas fa-check"></i> Booking requests & management</li>
            <li class="disabled"><i class="fas fa-times"></i> Multi-photographer scheduling</li>
            <li class="disabled"><i class="fas fa-times"></i> Advanced analytics</li>
          </ul>

          @if(!$isLoggedIn)
            <a href="{{ route('login') }}" class="btn btn-outline">Login to Subscribe</a>
          @elseif($userType !== 'studio')
            <button class="btn btn-outline" disabled>Available for Studios only</button>
          @elseif(!$p_studio_starter)
            <button class="btn btn-outline" disabled>Plan unavailable</button>
          @elseif($currentPlanId === $p_studio_starter->id)
            <button class="btn btn-outline" disabled>Current Plan</button>
          @else
            <form action="{{ route('subscribe') }}" method="POST">
              @csrf
              <input type="hidden" name="plan_id" value="{{ $p_studio_starter->id }}">
              <button type="submit" class="btn btn-outline">Start Starter</button>
            </form>
          @endif
        </div>

        {{-- Studio Pro --}}
        <div class="pricing-card popular">
          <div class="popular-badge">Most Popular</div>
          <div class="pricing-header">
            <h3>Studio Pro</h3>
            <div class="price">45 JOD<span>/month</span></div>
            <p>For studios with multiple bookings daily</p>
          </div>

          <ul class="pricing-features">
            <li><i class="fas fa-check"></i> Multiple calendars & time slots</li>
            <li><i class="fas fa-check"></i> Up to 8 team members</li>
            <li><i class="fas fa-check"></i> Multi-photographer scheduling</li>
            <li><i class="fas fa-check"></i> Client chat + automated updates</li>
            <li><i class="fas fa-check"></i> Lower platform commission</li>
            <li><i class="fas fa-check"></i> Reviews & highlights</li>
          </ul>

          @if(!$isLoggedIn)
            <a href="{{ route('login') }}" class="btn btn-primary">Login to Subscribe</a>
          @elseif($userType !== 'studio')
            <button class="btn btn-primary" disabled>Available for Studios only</button>
          @elseif(!$p_studio_pro)
            <button class="btn btn-primary" disabled>Plan unavailable</button>
          @elseif($currentPlanId === $p_studio_pro->id)
            <button class="btn btn-primary" disabled>Current Plan</button>
          @else
            <form action="{{ route('subscribe') }}" method="POST">
              @csrf
              <input type="hidden" name="plan_id" value="{{ $p_studio_pro->id }}">
              <button type="submit" class="btn btn-primary">Choose Studio Pro</button>
            </form>
          @endif
        </div>

        {{-- Studio Premium --}}
        <div class="pricing-card">
          <div class="pricing-header">
            <h3>Studio Premium</h3>
            <div class="price">80 JOD<span>/month</span></div>
            <p>Scale your studio with priority exposure</p>
          </div>

          <ul class="pricing-features">
            <li><i class="fas fa-check"></i> Everything in Studio Pro</li>
            <li><i class="fas fa-check"></i> Featured studio placement</li>
            <li><i class="fas fa-check"></i> Advanced analytics & reports</li>
            <li><i class="fas fa-check"></i> Custom booking page + branding</li>
            <li><i class="fas fa-check"></i> Lowest platform commission</li>
            <li><i class="fas fa-check"></i> Priority support</li>
          </ul>

          @if(!$isLoggedIn)
            <a href="{{ route('login') }}" class="btn btn-outline">Login to Subscribe</a>
          @elseif($userType !== 'studio')
            <button class="btn btn-outline" disabled>Available for Studios only</button>
          @elseif(!$p_studio_premium)
            <button class="btn btn-outline" disabled>Plan unavailable</button>
          @elseif($currentPlanId === $p_studio_premium->id)
            <button class="btn btn-outline" disabled>Current Plan</button>
          @else
            <form action="{{ route('subscribe') }}" method="POST">
              @csrf
              <input type="hidden" name="plan_id" value="{{ $p_studio_premium->id }}">
              <button type="submit" class="btn btn-outline">Become Studio Premium</button>
            </form>
          @endif
        </div>
      </div>

      <!-- Mini note under pricing -->
      <div class="section-titlee" style="margin-top:18px;">
        <p style="opacity:.85;">
          No hidden fees. Upgrade, downgrade, or cancel anytime. Payments are secure and transparent.
        </p>
      </div>

      {{-- Cancel يظهر فقط إذا في اشتراك فعّال --}}
      @if($isLoggedIn && $activeSub && $activeSub->isActive())
        <div style="margin-top:20px;">
          <form action="{{ route('subscription.cancel') }}" method="POST"
                onsubmit="return confirm('Are you sure you want to cancel your subscription?');">
            @csrf
            <button type="submit" class="btn btn-outline">Cancel Current Subscription</button>
          </form>
        </div>
      @endif

    </div>
  </section>

  <!-- Tabs Script -->
 <script>
  const tabBtns = document.querySelectorAll(".tab-btn");
  const pricingBlocks = document.querySelectorAll(".pricing-container[data-pricing-content]");

  tabBtns.forEach(btn => {
    btn.addEventListener("click", () => {
      tabBtns.forEach(b => b.classList.remove("active"));
      btn.classList.add("active");

      const target = btn.getAttribute("data-pricing");

      pricingBlocks.forEach(block => {
        block.classList.toggle("is-active", block.getAttribute("data-pricing-content") === target);
      });
    });
  });
</script>


</body>
</html>
