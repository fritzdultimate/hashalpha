@extends('layouts.guest')
@section('title', 'Contact Support')
@section('content')

    <section class="top-section pd-top-56px">
        <div class="w-layout-blockcontainer container-default w-container">
            <div class="grid-2-columns contact-form-right-grid !halpha-items-start">
                <div id="w-node-_958ba875-0a69-348e-cf9e-60f61ef8c773-5398601e">
                    <h1 style="opacity: 1; filter: blur(0px);" class="display-1 mg-bottom-12px">
                        Get in touch with us today.
                    </h1>
                    <div style="opacity: 1; filter: blur(0px);" class="inner-container _470px _100-tablet">
                        <p class="mg-bottom-32px halpha-text-gray-300">
                            Lorem ipsum dolor sit amet consectetur adipiscing elit arcu cras posuere
                            gravida neque felis a.
                        </p>
                    </div>
                    <div style="opacity: 1; filter: blur(0px);" class="social-media-links-container">
                        <a href="https://www.facebook.com/" target="_blank" class="social-link-single w-inline-block">
                            <div></div>
                        </a>
                        <a href="https://www.twitter.com/" target="_blank" class="social-link-single w-inline-block">
                            <div></div>
                        </a>
                        <a href="https://www.instagram.com/" target="_blank" class="social-link-single w-inline-block">
                            <div></div>
                        </a>
                        <a href="https://www.linkedin.com/" target="_blank" class="social-link-single w-inline-block">
                            <div></div>
                        </a>
                    </div>



                    <div style="opacity: 1; filter: blur(0px);" class="divider _48px _32px-tablet"></div>

                    <div class="grid-1-column gap-row-32px">
                        <a href="mailto:contact@cryptoverse.com" class="text-decoration-none w-inline-block">
                            <div class="flex align-start gap-column-12px">
                                <img
                                    src="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dfceea9d8cc458bb66af0f_email-circle-icon-cryptomatic-webflow-ecommerce-template.png"
                                    loading="eager" alt="" class="link-item-dark-image max-w-48px max-w-40px-mbl">
                                <div class="grid-1-column gap-row-8px">
                                    <div class="text-200 color-neutral-100">Send email</div>
                                    <div class="text-200 medium">contact@cryptoverse.com</div>
                                </div>
                            </div>
                        </a>
                        <a href="tel:(414)603-9721" class="text-decoration-none w-inline-block">
                            <div class="flex align-start gap-column-12px">
                                <img src="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dfceeaa9539c2bbb96f31a_phone-circle-icon-cryptomatic-webflow-ecommerce-template.png"
                                    loading="eager" alt="" class="link-item-dark-image max-w-48px max-w-40px-mbl">
                                <div class="grid-1-column gap-row-8px">
                                    <div class="text-200 color-neutral-100">Give us a call</div>
                                    <div class="text-200 medium">(414) 603 - 9721</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>


                <div class="card contact-form-card" class="">
                    <div class="divider inside-card---top"></div>
                    <img
                        src="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dfd7898bb88ef1b6c53a2b_contact-card-bg-top-cryptomatic-webflow-ecommerce-template.png"
                        loading="eager"
                        sizes="(max-width: 479px) 100vw, (max-width: 991px) 95vw, (max-width: 1439px) 55vw, 727.6015625px"
                        srcset="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dfd7898bb88ef1b6c53a2b_contact-card-bg-top-cryptomatic-webflow-ecommerce-template-p-500.png 500w, https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dfd7898bb88ef1b6c53a2b_contact-card-bg-top-cryptomatic-webflow-ecommerce-template-p-800.png 800w, https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dfd7898bb88ef1b6c53a2b_contact-card-bg-top-cryptomatic-webflow-ecommerce-template-p-1080.png 1080w, https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dfd7898bb88ef1b6c53a2b_contact-card-bg-top-cryptomatic-webflow-ecommerce-template.png 2184w"
                        alt="" class="bg-gradient-top"
                    >

                    <div class="contact-form-main">
                        <form method="get" aria-label="Contact Form">
                            <div class="w-layout-grid grid-2-columns form">
                                <div>
                                    <label for="Name">Full name</label>
                                    <input class="input bg-transparent w-input" maxlength="256" name="Name" data-name="Name" placeholder="John Doe" type="text" id="Name" required="">
                                </div>
                                <div>
                                    <label for="Email">Email address</label>
                                    <input class="input bg-transparent w-input" maxlength="256" name="Email" data-name="Email" placeholder="example@youremail.com" type="email" id="Email" required="">
                                </div>
                                <div>
                                    <label for="Phone">Phone number</label>
                                    <input class="input bg-transparent w-input" maxlength="256" name="Phone" data-name="Phone" placeholder="(123) 456 - 7890" type="tel" id="Phone" required="">
                                </div>
                                <div>
                                    <label for="Company">Company</label>
                                    <input class="input bg-transparent w-input" maxlength="256" name="Company" data-name="Company" placeholder="ex. Facebook" type="text" id="Company" required="">
                                </div>
                                <div id="w-node-b7e59d62-755a-a12c-f7d1-b496c3c11950-5398601e">
                                    <label for="Message">Message</label>
                                    <textarea id="Message" name="Message" maxlength="5000" data-name="Message" placeholder="Write your message here..." class="text-area bg-transparent w-input"></textarea>
                                </div>
                                <div id="w-node-_475ad8c5-a872-971c-df52-5b856f0a7994-5398601e" class="btn-primary-wrapper">
                                    <input type="submit" data-wait="Please wait..." class="btn-primary w-button" value="Send Message">
                                    <div class="btn-primary-border"></div>
                                </div>
                            </div>
                        </form>
                        <div class="success-message transparent w-form-done !halpha-hidden" role="region" aria-label="Contact V1 Form success">
                            <div>
                                <div class="line-rounded-icon success-message-check large"></div>
                                <h2>Thank you</h2>
                                <div>Thanks for reaching out. We will get back to you soon.</div>
                            </div>
                        </div>

                        <div class="error-message w-form-fail !halpha-hidden" tabindex="-1" role="region"
                            aria-label="Contact V1 Form failure">
                            <div>Oops! Something went wrong while submitting the form.</div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>
@endsection