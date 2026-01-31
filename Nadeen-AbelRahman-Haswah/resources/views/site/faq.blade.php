@extends('site.layout.mater')

@section('content')
    <!-- FAQ Section -->
    <section id="faq-2" class="faq-2 section light-background">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Frequently Asked Questions</h2>
            <p>Here are some of the common questions regarding access, privacy, permissions, and content usage on the
                platform.</p>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-lg-10">

                    <div class="faq-container">

                        <!-- Access Questions -->
                        <div class="faq-item faq-active" data-aos="fade-up" data-aos-delay="200">
                            <i class="faq-icon bi bi-question-circle"></i>
                            <h3>Who can access the platform?</h3>
                            <div class="faq-content">
                                <p>All registered users assigned by their departments can access the platform. Access levels
                                    vary depending on the role and permissions.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>

                        <div class="faq-item" data-aos="fade-up" data-aos-delay="300">
                            <i class="faq-icon bi bi-question-circle"></i>
                            <h3>Can I request access if I am new?</h3>
                            <div class="faq-content">
                                <p>Yes, new users can submit an access request which will be reviewed by the admin before
                                    granting permissions.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>

                        <!-- Privacy Questions -->
                        <div class="faq-item" data-aos="fade-up" data-aos-delay="400">
                            <i class="faq-icon bi bi-question-circle"></i>
                            <h3>How is my data privacy ensured?</h3>
                            <div class="faq-content">
                                <p>All user data is securely stored and encrypted. Only authorized users can view specific
                                    knowledge content according to their role.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>

                        <div class="faq-item" data-aos="fade-up" data-aos-delay="500">
                            <i class="faq-icon bi bi-question-circle"></i>
                            <h3>Can I control who sees my contributions?</h3>
                            <div class="faq-content">
                                <p>Yes, content creators can set visibility for each knowledge item, choosing between
                                    department-wide or restricted access.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>

                        <!-- Permissions Questions -->
                        <div class="faq-item" data-aos="fade-up" data-aos-delay="600">
                            <i class="faq-icon bi bi-question-circle"></i>
                            <h3>What permissions exist on the platform?</h3>
                            <div class="faq-content">
                                <p>Permissions include viewing, creating, editing, and deleting knowledge items, as well as
                                    managing teams and approving access requests.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>

                        <!-- Content Questions -->
                        <div class="faq-item" data-aos="fade-up" data-aos-delay="700">
                            <i class="faq-icon bi bi-question-circle"></i>
                            <h3>What type of content can I contribute?</h3>
                            <div class="faq-content">
                                <p>Users can contribute four types of knowledge: text, images, videos, and links. Each item
                                    can be categorized and tagged for easy retrieval.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section><!-- /FAQ Section -->
@endsection
