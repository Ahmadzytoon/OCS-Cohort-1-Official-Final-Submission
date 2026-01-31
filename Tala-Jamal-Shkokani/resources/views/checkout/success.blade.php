@extends('layouts.app')

@section('content')
    <div class="container py-5 animate-fade-in">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-5 overflow-hidden text-center p-5">
                    <!-- Confetti Canvas -->
                    <canvas id="canvas" class="position-absolute top-0 start-0 w-100 h-100"
                        style="pointer-events: none; z-index: 1;"></canvas>

                    <div class="position-relative" style="z-index: 2;">
                        <div class="mb-4">
                            <div class="success-icon-wrap d-inline-flex align-items-center justify-content-center bg-success-subtle text-success rounded-circle"
                                style="width: 100px; height: 100px;">
                                <i class="fa-solid fa-check fa-3x"></i>
                            </div>
                        </div>

                        <h1 class="display-5 font-heading fw-bold mb-3" style="font-family: 'Playfair Display', serif;">
                            Confirmed! 🎉</h1>
                        <p class="text-muted mb-5 ls-1 text-uppercase small">Your Chic & Co. luxury experience has begun.
                        </p>

                        <div class="order-info-box bg-light rounded-4 p-4 mb-5 text-start">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <span class="text-muted extra-small text-uppercase ls-1">Order Number</span>
                                    <h5 class="mb-0 fw-bold">#{{ $order->order_number }}</h5>
                                </div>
                                <div class="text-end">
                                    <span class="text-muted extra-small text-uppercase ls-1">Order Date</span>
                                    <p class="mb-0 small fw-bold">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                            <div class="border-top pt-3">
                                <span class="text-muted extra-small text-uppercase ls-1 d-block mb-3">Delivery
                                    Timeline</span>
                                <div class="delivery-timeline">
                                    <div class="timeline-step active">
                                        <div class="step-icon">📦</div>
                                        <div class="step-label">
                                            <strong>Order Processed</strong>
                                            <p class="mb-0 text-muted extra-small">We're preparing your items</p>
                                        </div>
                                        <div class="step-time">Within 1 hour</div>
                                    </div>
                                    <div class="timeline-step">
                                        <div class="step-icon">🚚</div>
                                        <div class="step-label">
                                            <strong>Out for Delivery</strong>
                                            <p class="mb-0 text-muted extra-small">Courier will contact you</p>
                                        </div>
                                        <div class="step-time">Tomorrow</div>
                                    </div>
                                    <div class="timeline-step">
                                        <div class="step-icon">🏠</div>
                                        <div class="step-label">
                                            <strong>Lux Delivery</strong>
                                            <p class="mb-0 text-muted extra-small">Your luxury arrives</p>
                                        </div>
                                        <div class="step-time">1-2 Days</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-3 d-sm-flex justify-content-center mb-5">
                            <button onclick="window.print()" class="btn btn-outline-dark rounded-pill px-4">
                                <i class="fa-solid fa-print me-2"></i> Print Receipt
                            </button>
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-dark rounded-pill px-4">
                                <i class="fa-solid fa-list me-2"></i> View All Orders
                            </a>
                            <a href="{{ route('shop.index') }}"
                                class="btn btn-dark rounded-pill px-5 py-3 text-uppercase ls-1 fw-bold">
                                Continue Shopping
                            </a>
                        </div>

                        <!-- Social Sharing -->
                        <div class="social-share-box bg-white border rounded-4 p-4">
                            <p class="mb-3 fw-bold small text-uppercase ls-1">Love your purchase? <span
                                    class="text-muted">Share the vibe!</span></p>
                            <div class="d-flex justify-content-center gap-3">
                                <button class="btn btn-instagram-soft d-flex align-items-center gap-2">
                                    <i class="fa-brands fa-instagram fs-5"></i>
                                    <span class="small fw-bold">Share Instagram</span>
                                </button>
                                <button class="btn btn-whatsapp-soft d-flex align-items-center gap-2">
                                    <i class="fa-brands fa-whatsapp fs-5"></i>
                                    <span class="small fw-bold">Send to Friends</span>
                                </button>
                            </div>
                        </div>

                        <!-- Upsell Suggestions -->
                        <livewire:post-purchase-suggestions :order="$order" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .success-icon-wrap {
            animation: scaleIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .extra-small {
            font-size: 0.7rem;
        }

        .delivery-timeline {
            position: relative;
        }

        .timeline-step {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            padding-bottom: 25px;
            position: relative;
        }

        .timeline-step:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 17px;
            top: 35px;
            bottom: 0px;
            width: 2px;
            background: #eee;
        }

        .timeline-step.active .step-icon {
            background: #000;
            color: white;
        }

        .step-icon {
            width: 35px;
            height: 35px;
            background: #f8f9fa;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            z-index: 2;
        }

        .step-time {
            margin-left: auto;
            font-size: 0.65rem;
            color: #888;
            background: #f1f1f1;
            padding: 2px 8px;
            border-radius: 10px;
        }

        .btn-instagram-soft {
            background: #fdf2f8;
            color: #db2777;
            border-radius: 50px;
        }

        .btn-whatsapp-soft {
            background: #f0fdf4;
            color: #16a34a;
            border-radius: 50px;
        }
    </style>

    <!-- Confetti Script -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var duration = 5 * 1000;
            var animationEnd = Date.now() + duration;
            var defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };

            function randomInRange(min, max) {
                return Math.random() * (max - min) + min;
            }

            var interval = setInterval(function () {
                var timeLeft = animationEnd - Date.now();

                if (timeLeft <= 0) {
                    return clearInterval(interval);
                }

                var particleCount = 50 * (timeLeft / duration);
                confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 } }));
                confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 } }));
            }, 250);

            // Browser Notification
            if (Notification.permission === "granted") {
                new Notification("🎀 Order Confirmed!", {
                    body: "Your Chic & Co. order #{{ $order->order_number }} is being processed",
                });
            } else if (Notification.permission !== "denied") {
                Notification.requestPermission();
            }
        });
    </script>
@endsection