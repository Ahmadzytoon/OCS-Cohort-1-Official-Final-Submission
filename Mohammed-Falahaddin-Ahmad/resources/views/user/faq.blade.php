@extends('layouts.user')

@section('content')

<!-- Breadcumb Section Start -->
<div class="breadcrumb-wrapper bg-cover section-padding"
    style="background-image: url({{ asset('assets/user/images/hero/breadcrumb-bg.jpg') }});">
    <div class="container">
        <div class="page-heading">
            <h1>Faqs</h1>
            <div class="page-header">
                <ul class="breadcrumb-items wow fadeInUp" data-wow-delay=".3s">
                    <li><a href="{{ route('user.home') }}">Home</a></li>
                    <li><i class="fa-solid fa-chevron-right"></i></li>
                    <li>Faq</li>
                </ul>
            </div>
        </div>
    </div>
</div>

    <!--<< Faq Section Start >>-->
    <section class="faq-section fix section-padding pb-0">
        <div class="container">
            <div class="faq-wrapper">
                <div class="row g-4">
                    <div class="col-lg-3">
                        <div class="faq-left">
                            <ul class="nav" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a href="#trust" data-bs-toggle="tab" class="nav-link active" aria-selected="true"
                                        role="tab">
                                        Account & Security
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="#general" data-bs-toggle="tab" class="nav-link" aria-selected="false"
                                        role="tab" tabindex="-1">
                                        General Info
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="#programs" data-bs-toggle="tab" class="nav-link" aria-selected="false"
                                        role="tab" tabindex="-1">
                                        Shipping & Delivery
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="#kindergarten" data-bs-toggle="tab" class="nav-link" aria-selected="false"
                                        role="tab" tabindex="-1">
                                        Returns & Refunds
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="tab-content">
                            <div id="trust" class="tab-pane fade show active" role="tabpanel">
                                <div class="faq-content">
                                    <div class="faq-accordion">
                                        <div class="accordion" id="accordion">
                                            <div class="accordion-item mb-3">
                                                <h5 class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#faq1"
                                                        aria-expanded="true" aria-controls="faq1">
                                                        How do I create an account?
                                                    </button>
                                                </h5>
                                                <div id="faq1" class="accordion-collapse collapse"
                                                    data-bs-parent="#accordion">
                                                    <div class="accordion-body">
                                                        Creating an account is easy! Simply click on the "Login" button at the top right corner of the page and select "Register". Fill in your name, email address, and password to create your account. You can then use these credentials to log in and track your orders.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item mb-3">
                                                <h5 class="accordion-header">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#faq2"
                                                        aria-expanded="false" aria-controls="faq2">
                                                        Is my personal information safe?
                                                    </button>
                                                </h5>
                                                <div id="faq2" class="accordion-collapse show"
                                                    data-bs-parent="#accordion">
                                                    <div class="accordion-body">
                                                        Yes, we take your privacy and security very seriously. We use industry-standard encryption to protect your personal information and payment details. We do not share your data with third parties without your consent.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item mb-3">
                                                <h5 class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#faq3"
                                                        aria-expanded="false" aria-controls="faq3">
                                                        I forgot my password, how can I reset it?
                                                    </button>
                                                </h5>
                                                <div id="faq3" class="accordion-collapse collapse"
                                                    data-bs-parent="#accordion">
                                                    <div class="accordion-body">
                                                        If you've forgotten your password, go to the Login page and click on the "Forgot Password" link. Enter your registered email address, and we will send you instructions on how to reset your password.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="general" class="tab-pane fade" role="tabpanel">
                                <div class="faq-content">
                                    <div class="faq-accordion">
                                        <div class="accordion" id="accordion2">
                                            <div class="accordion-item mb-3">
                                                <h5 class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#faq11"
                                                        aria-expanded="true" aria-controls="faq11">
                                                        Where are you located?
                                                    </button>
                                                </h5>
                                                <div id="faq11" class="accordion-collapse collapse"
                                                    data-bs-parent="#accordion2">
                                                    <div class="accordion-body">
                                                        We are an online-first book shop, serving customers globally. Our main office is located in the city center, but we operate primarily through our website to bring you the best selection of books right to your doorstep.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item mb-3">
                                                <h5 class="accordion-header">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#faq22"
                                                        aria-expanded="false" aria-controls="faq22">
                                                        Do you have a physical store?
                                                    </button>
                                                </h5>
                                                <div id="faq22" class="accordion-collapse show"
                                                    data-bs-parent="#accordion2">
                                                    <div class="accordion-body">
                                                        Currently, we operate exclusively online to reduce overhead costs and pass the savings on to you. This allows us to offer a wider variety of books at competitive prices.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item mb-3">
                                                <h5 class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#faq33"
                                                        aria-expanded="false" aria-controls="faq33">
                                                        How can I contact customer support?
                                                    </button>
                                                </h5>
                                                <div id="faq33" class="accordion-collapse collapse"
                                                    data-bs-parent="#accordion2">
                                                    <div class="accordion-body">
                                                        You can reach our customer support team via the "Contact" page on our website. We are available via email and phone during business hours to assist you with any inquiries or issues you may have.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="programs" class="tab-pane fade" role="tabpanel">
                                <div class="faq-content">
                                    <div class="faq-accordion">
                                        <div class="accordion" id="accordion3">
                                            <div class="accordion-item mb-3">
                                                <h5 class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#faq111"
                                                        aria-expanded="true" aria-controls="faq111">
                                                        What are the shipping costs?
                                                    </button>
                                                </h5>
                                                <div id="faq111" class="accordion-collapse collapse"
                                                    data-bs-parent="#accordion3">
                                                    <div class="accordion-body">
                                                        Shipping costs vary based on your location and the weight of your order. You can view the estimated shipping cost at the checkout page before completing your purchase. We also offer free shipping on orders over a certain amount!
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item mb-3">
                                                <h5 class="accordion-header">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#faq222"
                                                        aria-expanded="false" aria-controls="faq222">
                                                        How long does delivery take?
                                                    </button>
                                                </h5>
                                                <div id="faq222" class="accordion-collapse show"
                                                    data-bs-parent="#accordion3">
                                                    <div class="accordion-body">
                                                        Standard delivery usually takes 3-5 business days within the country. International shipping may take longer, typically 7-14 business days depending on the destination. You will receive a tracking number once your order is shipped.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item mb-3">
                                                <h5 class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#faq333"
                                                        aria-expanded="false" aria-controls="faq333">
                                                        Do you offer international shipping?
                                                    </button>
                                                </h5>
                                                <div id="faq333" class="accordion-collapse collapse"
                                                    data-bs-parent="#accordion3">
                                                    <div class="accordion-body">
                                                        Yes, we ship to many countries worldwide. During checkout, simply select your country to see if we deliver to your location and to view the applicable shipping rates.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="kindergarten" class="tab-pane fade" role="tabpanel">
                                <div class="faq-content">
                                    <div class="faq-accordion">
                                        <div class="accordion" id="accordion4">
                                            <div class="accordion-item mb-3">
                                                <h5 class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#faq1111"
                                                        aria-expanded="true" aria-controls="faq1111">
                                                        What is your return policy?
                                                    </button>
                                                </h5>
                                                <div id="faq1111" class="accordion-collapse collapse"
                                                    data-bs-parent="#accordion4">
                                                    <div class="accordion-body">
                                                        We want you to be completely satisfied with your purchase. If you are not happy with a book, you can return it within 30 days of receipt for a full refund or exchange, provided it is in its original condition.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item mb-3">
                                                <h5 class="accordion-header">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#faq2222"
                                                        aria-expanded="false" aria-controls="faq2222">
                                                        How do I return an item?
                                                    </button>
                                                </h5>
                                                <div id="faq2222" class="accordion-collapse show"
                                                    data-bs-parent="#accordion4">
                                                    <div class="accordion-body">
                                                        To initiate a return, please contact our support team with your order details. We will provide you with a return shipping label and instructions on how to send the package back to us.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item mb-3">
                                                <h5 class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#faq3333"
                                                        aria-expanded="false" aria-controls="faq3333">
                                                        What if I receive a damaged book?
                                                    </button>
                                                </h5>
                                                <div id="faq3333" class="accordion-collapse collapse"
                                                    data-bs-parent="#accordion4">
                                                    <div class="accordion-body">
                                                        If you receive a damaged or incorrect item, please contact us immediately with a photo of the damage. We will arrange for a replacement to be sent to you at no extra cost, or offer a full refund.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection