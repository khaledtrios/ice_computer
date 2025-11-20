@extends('layouts.app_front')
@section('meta')
    <title>Model‑ITECH – Contact & support pour réparateurs mobiles</title>
    <meta name="description"
        content="Contactez MODEL‑ITECH pour toute question sur votre gestion de devis, rendez‑vous et clients. Téléphone, email ou formulaire : notre équipe est à votre service.">
    <meta name="keywords" content="Plateforme MODEL-ITECH,devis,RDV,réparation mobiles & info">
    <link rel="canonical" href="{{ url()->current() }}">
@endsection
@section('main')

    <div class="container headerText">
        <h1>{{ __('contact.contacter_nous') }}</h1>
        <p>{{ __('contact.contacter_nous_2') }}</p>
    </div>
    <div class="container">
        <div class="card-groups col-2">
            <div class="card card-forfait contact-card" style="--basic-color : #46D8D5">
                <div class="card-content">
                    <div>
                        <div class="section-title">
                            <h2><span>{{ __('contact.prener_contact') }}</span></h2>
                        </div>
                        <p>{{ __('contact.prener2') }}</p>
                    </div>
                    <div class="contacts">
                        <a href="tel:0021623000000" class="contact-item">
                            <div class="icon-contact">
                                <i class="ti ti-phone"></i>
                            </div>
                            <div class="details">
                                <span>{{ __('contact.telephone') }}</span>
                                <div class="contact-detail">09 86 40 22 79</div>
                            </div>
                        </a>
                        <a href="mailto:contact@modelitech.com" class="contact-item">
                            <div class="icon-contact">
                                <i class="ti ti-mail"></i>
                            </div>
                            <div class="details">
                                <span>{{ __('contact.email') }}</span>
                                <div class="contact-detail">contact@modelitech.com</div>
                            </div>
                        </a>
                    </div>
                    <div class="social-container">
                        <a href="#" class="social-item">
                            <i class="ti ti-brand-twitter"></i>
                        </a>
                        <a href="#" class="social-item">
                            <i class="ti ti-brand-facebook"></i>
                        </a>
                        <a href="#" class="social-item">
                            <i class="ti ti-brand-instagram"></i>
                        </a>
                        <a href="#" class="social-item">
                            <i class="ti ti-brand-whatsapp"></i>
                        </a>
                    </div>
                </div>
                <div class="card-footer"></div>
            </div>
            <div class="card card-forfait" style="--basic-color : #309E9B">
                <div class="card-content">
                    <input type="text" class="text-input" placeholder="{{ __('contact.nom') }}">
                    <input type="text" class="text-input" placeholder="{{ __('contact.adresse_email') }}">
                    <input type="text" class="text-input" placeholder="{{ __('contact.sujet') }}">
                    <textarea name="msg" id="msg" class="text-input" placeholder="{{ __('contact.message') }}"></textarea>
                    <button class="button button-primary">{{ __('contact.envoyer') }}</button>
                </div>
                <div class="card-footer"></div>
            </div>
        </div>
    </div>
    <div class="bar"></div>
    <section class="container" style="margin-top: -24px;">
        <div class="banner-content">
            <h4>{{ __('messages.cree_grauit') }}</h4>
            <p>{{ __('messages.description_gratuit') }}</p>
            <a href="/register"><button class="button button-light">{{ __('messages.cree_compte') }}</button></a>
        </div>
    </section>
    <section class="container">
        <div class="section-title">
            <h2><span>{{ __('messages.question_frequent') }}</span></h2>
        </div>
        <div class="faq-content">
            <ul>
                <li class="faq-item show">
                    <div class="question">
                        <span>{{ __('messages.question_1') }}</span>
                        <i class="ti ti-chevron-down"></i>
                    </div>
                    <div class="response ">
                        <p>{{ __('messages.reponse_1') }}</p>
                    </div>
                </li>
                <li class="faq-item">
                    <div class="question">
                        <span>{{ __('messages.question_2') }}</span>
                        <i class="ti ti-chevron-down"></i>
                    </div>
                    <div class="response">
                        <p>{{ __('messages.reponse_2') }}</p>
                    </div>
                </li>
                <li class="faq-item">
                    <div class="question">
                        <span>{{ __('messages.question_3') }}</span>
                        <i class="ti ti-chevron-down"></i>
                    </div>
                    <div class="response">
                        <p>{{ __('messages.reponse_3') }}</p>
                    </div>
                </li>
                <li class="faq-item">
                    <div class="question">
                        <span>{{ __('messages.question_4') }}</span>
                        <i class="ti ti-chevron-down"></i>
                    </div>
                    <div class="response">
                        <p>{{ __('messages.reponse_4') }}</p>
                    </div>
                </li>
                <li class="faq-item">
                    <div class="question">
                        <span>{{ __('messages.question_5') }}</span>
                        <i class="ti ti-chevron-down"></i>
                    </div>
                    <div class="response">
                        <p>{{ __('messages.reponse_5') }}</p>
                    </div>
                </li>
                <li class="faq-item">
                    <div class="question">
                        <span>{{ __('messages.question_6') }}</span>
                        <i class="ti ti-chevron-down"></i>
                    </div>
                    <div class="response">
                        <p>{{ __('messages.reponse_6') }}</p>
                    </div>
                </li>
            </ul>
        </div>
    </section>

@endsection