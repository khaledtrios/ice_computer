@extends('layouts.app_front')
@section('meta')
<title>Plateforme MODEL-ITECH : devis et RDV pour réparateurs mobiles</title>
    <meta name="description"
        content="Gérez devis et rendez-vous facilement avec MODEL-ITECH. Centralisez clients, tarifs et planning pour votre boutique de réparation mobile et informatique.">
    <meta name="keywords"
        content="Plateforme MODEL-ITECH,devis,RDV,réparation mobiles & info">
    <link rel="canonical" href="{{ url()->current() }}">
@endsection
@section('main')
    <div class="container">
        <header>
            <div class="header-text">
                <h1 style="font-size: 24px;    font-family: math;"><span>MODEL-ITECH</span>
                    <br>{{ __('messages.votre_solution') }}
                </h1>
                <p style="font-family: math;">{{ __('messages.decouvrir') }} </p>
                <a href="/register" class="button button-outline-primary">{{ __('messages.demande_demo') }}</a>
            </div>
            <div class="header-image">
                <div class="circles">
                    <div class="circle1"></div>
                    <div class="circle2"></div>
                </div>

                <img src="{{asset('frontend/assets/media/vectors/model-ithec-tab-phone.png')}}"
                    alt="Tablette affichant l'app MODEL-ITECH" title="Aperçu MODEL-ITECH pour l'interface sur tablette">
            </div>
            <div class="vector" style="--color-bg:#71EDEBCD; --size:54px;--x:80%;--y:0%"></div>
            <div class="vector" style="--color-bg:#71EDEB29; --size:48px;--x:65%;--y:0%"></div>
            <div class="vector" style="--color-bg:#71EDEB29; --size:48px;--x:80%;--y:30%"></div>
        </header>
    </div>
    <section class="container">
        <div class="section-title">
            <h2><span>{{ __('messages.rendez_vous') }}</span></h2>
        </div>
        <div class="section-content">
            <div class="section-text">
                <div>
                    <p style="font-family: MATH;">
                        {{ __('messages.description_rendez_vous_1') }}
                    </p>
                    <p style="font-family: MATH;">
                        {{ __('messages.description_rendez_vous_2') }}
                    </p>
                    <p style="font-family: MATH;">
                        {{ __('messages.description_rendez_vous_3') }}
                    </p>
                </div>
                <a href="/contact" class="button button-primary">{{ __('messages.contacter_nous') }}</a>
            </div>
            <div class="vector-image">
                <div class="circle"></div>
                <div class="image">
                    <img src="{{asset('frontend/assets/media/content/people.png')}}" alt="Équipe MODEL-TECH Qui Somme Nous"
                        loading="lazy" title="Qui sommes-nous : Notre équipe dédiée">
                </div>
            </div>
        </div>
        <div class="vector" style="--color-bg:#58f5f2cd; --size:54px;--x:-1%;--y:12%;"></div>
        <div class="vector" style="--color-bg:#71edeb7b; --size:48px;--x:15%;--y:0%;"></div>
        <div class="vector" style="--color-bg:#71edeb7b; --size:48px;--x:-4%;--y:30%;"></div>
    </section>
    <section class="container" id="fonctionalite">
        <div class="section-title">
            <h2><span>{{ __('messages.fonctiononalies') }}</span></h2>
        </div>
        <div class="section-content">
            <div class="card-groups">
                <div class="card">
                    <div class="card-content">
                        <div class="icon">
                            <img src="{{asset('frontend/assets/media/icons/card1.png')}}" loading="lazy"
                                title="Gestion des rendez-vous simplifiée"
                                alt="Icône de calendrier pour gestion des rendez-vous">
                        </div>
                        <h5>{{ __('messages.gestion_rendez_vous') }}</h5>
                        <p>{{ __('messages.desc_rendez') }}</p>
                    </div>
                    <div class="card-footer"></div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="icon">
                            <img src="{{asset('frontend/assets/media/icons/card2.png')}}" loading="lazy"
                                alt="Icône de clients pour gestion de la clientèle" title="Gestion clientèle personnalisée">
                        </div>
                        <h5>{{ __('messages.gestion_clientele') }}</h5>
                        <p>{{ __('messages.desc_clientele') }}</p>
                    </div>
                    <div class="card-footer"></div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="icon">
                            <img src="{{asset('frontend/assets/media/icons/card3.png')}}" loading="lazy"
                                alt="Icône de document pour demande de devis" title="Demande de devis rapide et sécurisée">
                        </div>
                        <h5>{{ __('messages.demande_devis') }}</h5>
                        <p>{{ __('messages.desc_devis') }}</p>
                    </div>
                    <div class="card-footer"></div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="icon">
                            <img src="{{asset('frontend/assets/media/icons/card4.png')}}" loading="lazy"
                                alt="Icône de cadenas pour sécurité des données" title="Sécurité avancée des informations">
                        </div>
                        <h5>{{ __('messages.securite') }}</h5>
                        <p>{{ __('messages.desc_securite') }}</p>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
        <div class="vector" style="--color-bg:#71EDEBCD; --size:54px;--x:80%;--y:80%"></div>
        <div class="vector" style="--color-bg:#71edeb88; --size:48px;--x:70%;--y:76%"></div>
    </section>
    <div class="whyUs">
        <div class="whyUs-grid">
            <div class="whyUs-image">
                <div class="circle"></div>
                <img src="{{asset('frontend/assets/media/vectors/pourquoi-choisir-notre-application.png')}}"
                    alt="Pourquoi choisir notre application : Main tenant un smartphone avec interface de recherche MODEL-ITECH"
                    title="Illustration des avantages : Sélection intuitive de modèles d'appareils" loading="lazy">
            </div>
            <div class="whyUs-content">
                <div class="section-title">
                    <h2><span>{{ __('messages.pourquoi_choisi_application') }}</span></h2>
                </div>
                <ul class="whyUs-list">
                    <li class="whyUs-item">
                        <div class="why-item">
                            <span class="why-number">1</span>
                            {{ __('messages.simplicite_utilisation') }}
                        </div>
                        <p class="">{{ __('messages.desc_simplicite') }}</p>
                    </li>
                    <li class="whyUs-item">
                        <div class="why-item">
                            <span class="why-number">2</span>
                            {{ __('messages.personnalisation_avance') }}
                        </div>
                        <p class="">{{ __('messages.desc_personnalisation') }}</p>
                    </li>
                    <li class="whyUs-item">
                        <div class="why-item">
                            <span class="why-number">3</span>
                            {{ __('messages.efficacite_operationnelle') }}
                        </div>
                        <p class="">{{ __('messages.desc_efficacite') }}</p>
                    </li>
                    <li class="whyUs-item">
                        <div class="why-item">
                            <span class="why-number">4</span>
                            {{ __('messages.support_clientele') }}
                        </div>
                        <p class="">{{ __('messages.desc_support') }}</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <section class="container pt-8 marques-section">
        <div class="section-content">
            <div class="section-title">
                <h2><span>{{ __('messages.large_choix') }}</span></h2>
            </div>
            <p>
                {{ __('messages.desc_large_1') }}
            </p>
            <p>
                {{ __('messages.tarif1') }}
            </p>
            <button class="button button-primary" onclick="window.location.href='/register'">
                {{ __('messages.demande_demo') }}
            </button>
        </div>
        <div class="brands-section">
            <div class="center-circle"></div>
            <span style="--bg: #ffffff;--x: 10%; --y: 20%; --i: 1;"><img
                    src="{{asset('frontend/assets/media/brands/apple.png')}}" alt="Logo Apple (compatible avec MODEL-ITECH)"
                    title="iPhone et iPad compatibles avec l'app" loading="lazy"></span>
            <span style="--bg: #ffffff;--x: 20%; --y: 40%; --i: 2;"><img
                    src="{{asset('frontend/assets/media/brands/asus.png')}}" alt="Logo Asus (compatible avec MODEL-ITECH)"
                    title="Smartphones Asus compatibles" loading="lazy"></span>
            <span style="--bg: #ffffff;--x: 40%; --y: 0%; --i: 3;"><img
                    src="{{asset('frontend/assets/media/brands/huawei.png')}}"
                    alt="Logo Huawei (compatible avec MODEL-ITECH)" title="Appareils Huawei compatibles"
                    loading="lazy"></span>
            <span style="--bg: #ffffff;--x: 40%; --y: 80%; --i: 1;"><img
                    src="{{asset('frontend/assets/media/brands/leEco.png')}}" alt="Logo LeEco (compatible avec MODEL-ITECH)"
                    title="Téléphones LeEco compatibles" loading="lazy"></span>
            <span style="--bg: #ffffff;--x: 50%; --y: 30%; --i: 2;"><img
                    src="{{asset('frontend/assets/media/brands/motorola.png')}}"
                    alt="Logo Motorola (compatible avec MODEL-ITECH)" title="Modèles Motorola compatibles"
                    loading="lazy"></span>
            <span style="--bg: #ffffff;--x: 60%; --y: 70%; --i: 3;"><img
                    src="{{asset('frontend/assets/media/brands/oneplus.png')}}"
                    alt="Logo OnePlus (compatible avec MODEL-ITECH)" title="Smartphones OnePlus compatibles"
                    loading="lazy"></span>
            <span style="--bg: #ffffff;--x: 70%; --y: 10%; --i: 1;"><img
                    src="{{asset('frontend/assets/media/brands/oppo.png')}}" alt="Logo Oppo (compatible avec MODEL-ITECH)"
                    title="Appareils Oppo compatibles" loading="lazy"></span>
            <span style="--bg: #ffffff;--x: 80%; --y: 50%; --i: 2;"><img
                    src="{{asset('frontend/assets/media/brands/Samsung.png')}}"
                    alt="Logo Samsung (compatible avec MODEL-ITECH)" title="Galaxy et autres Samsung compatibles"
                    loading="lazy"></span>
            <span style="--bg: #000000;--x: 10%; --y: 70%; --i: 3;"><img
                    src="{{asset('frontend/assets/media/brands/umidigi.png')}}"
                    alt="Logo Umidigi (compatible avec MODEL-ITECH)" title="Téléphones Umidigi compatibles"
                    loading="lazy"></span>
            <span style="--bg: #00B2A9;--x: 40%; --y: 60%; --i: 1;"><img
                    src="{{asset('frontend/assets/media/brands/wiki.png')}}" alt="Logo Wikio (compatible avec MODEL-ITECH)"
                    title="Appareils Wikio compatibles" loading="lazy"></span>
            <span style="--bg: #FC650A;--x: 80%; --y: 20%; --i: 2;"><img
                    src="{{asset('frontend/assets/media/brands/xiaomi.png')}}"
                    alt="Logo Xiaomi (compatible avec MODEL-ITECH)" title="Smartphones Xiaomi compatibles"
                    loading="lazy"></span>
            <div class="vector" style="--color-bg:#71EDEBCD; --size:54px;--x:10%;--y:100%"></div>
            <div class="vector" style="--color-bg:#71edeb88; --size:48px;--x:40%;--y:96%"></div>
            <div class="vector" style="--color-bg:#71EDEBCD; --size:54px;--x:30%;--y:50%"></div>
            <div class="vector" style="--color-bg:#71edeb88; --size:48px;--x:90%;--y:96%"></div>
            <div class="vector" style="--color-bg:#71EDEBCD; --size:54px;--x:10%;--y:10%"></div>
            <div class="vector" style="--color-bg:#71edeb88; --size:48px;--x:40%;--y:80%"></div>
            <div class="vector" style="--color-bg:#71EDEBCD; --size:54px;--x:30%;--y:1%"></div>
            <div class="vector" style="--color-bg:#71edeb88; --size:48px;--x:90%;--y:20%"></div>
        </div>
    </section>
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