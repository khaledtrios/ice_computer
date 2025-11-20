@extends('layouts.app_front')
@section('meta')
    <title>MODEL-ITECH – Tarifs des solutions de gestion pour réparateurs</title>
    <meta name="description"
        content="Découvrez les tarifs MODEL-ITECH : Standard, Standard + page web et Marque Blanche. Devis automatisés, planning et clients centralisés pour votre boutique.">
    <meta name="keywords" content="Plateforme MODEL-ITECH,devis,RDV,réparation mobiles & info">
    <link rel="canonical" href="{{ url()->current() }}">
@endsection
@section('main')

    <div class="container headerText">
        <h1>{{ __('tarif.votre_forfait') }}</h1>
        <p>{{ __('tarif.votre_forfait_desc') }}</p>
        {{--
    </div>
    <div class="container"> --}}
        <div class="card-groups col-3">
            <div class="card card-forfait" style="--basic-color : #46D8D5">
                <div class="card-content">
                    <div class="section-title">
                        <h2><span>STANDARD</span></h2>
                    </div>
                    <p>Vous avez déjà un site web.</p>
                    <div class="price">
                        <span>99 €</span> ht/an
                    </div>
                    <a href="/register">
                        <button class="button button-primary">C'EST PARTI !</button>
                    </a>
                    <ul class="options">
                        <li>
                            <div class="check">
                                <i class="ti ti-check"></i>
                            </div>
                            <span>Mise à jour des modèles automatique</span>
                        </li>
                        <li>
                            <div class="check">
                                <i class="ti ti-check"></i>
                            </div>
                            <span>Gestion des marque et modèle de téléphone et tablette</span>
                        </li>
                        <li>
                            <div class="check">
                                <i class="ti ti-check"></i>
                            </div>
                            <span>Organisation des prises de rendez-vous</span>
                        </li>
                        <li>
                            <div class="check">
                                <i class="ti ti-check"></i>
                            </div>
                            <span>Gestion de votre base clients</span>
                        </li>
                        {{-- <li>
                            <div class="check">
                                <i class="ti ti-check"></i>
                            </div>
                            <span>Gestion des cartes de fidélité, des cartes-cadeaux et des adhésions</span>
                        </li>
                        <li>
                            <div class="check">
                                <i class="ti ti-check"></i>
                            </div>
                            <span>Domaine personnalisé</span>
                        </li>
                        <li>
                            <div class="check">
                                <i class="ti ti-check"></i>
                            </div>
                            <span>Personnalisation du site de réservation</span>
                        </li>
                        <li>
                            <div class="check">
                                <i class="ti ti-check"></i>
                            </div>
                            <span>Analyse des données du site de réservation</span>
                        </li> --}}
                    </ul>
                </div>
                <div class="card-footer"></div>
            </div>

            <div class="card card-forfait" style="--basic-color :#309E9B">
                <div class="card-content">
                    <div class="section-title">
                        <h2 style="font-size: 24px"><span>STANDARD + PAGE WEB</span></h2>
                    </div>
                    <p>Vous n’avez pas encore de site web. </p>
                    <div class="price">
                        <span style="text-decoration: line-through;    font-size: 18px !important;">249 €</span> ht/an
                        <br><span>149 €</span> ht/an <br><span style="color:#757272;font-size:12px;">(jusqu'a 30 avril
                            2025)</span>

                    </div>
                    <a href="/register">
                        <button class="button button-primary">C'EST PARTI !</button>
                    </a>
                    <ul class="options">
                        <li>
                            <div class="check">
                                <i class="ti ti-check"></i>
                            </div>
                            <span>Mise à jour des modèles automatique</span>
                        </li>
                        <li>
                            <div class="check">
                                <i class="ti ti-check"></i>
                            </div>
                            <span>Gestion des marques et modèles de téléphone et tablette</span>
                        </li>
                        <li>
                            <div class="check">
                                <i class="ti ti-check"></i>
                            </div>
                            <span>Organisation des prises de rendez-vous</span>
                        </li>
                        <li>
                            <div class="check">
                                <i class="ti ti-check"></i>
                            </div>
                            <span>Gestion de votre base clients</span>
                        </li>
                        {{-- <li>
                            <div class="check">
                                <i class="ti ti-check"></i>
                            </div>
                            <span>Gestion des cartes de fidélité, des cartes-cadeaux et des adhésions</span>
                        </li>
                        <li>
                            <div class="check">
                                <i class="ti ti-check"></i>
                            </div>
                            <span>Domaine personnalisé</span>
                        </li>
                        <li>
                            <div class="check">
                                <i class="ti ti-check"></i>
                            </div>
                            <span>Personnalisation du site de réservation</span>
                        </li>
                        <li>
                            <div class="check">
                                <i class="ti ti-check"></i>
                            </div>
                            <span>Analyse des données du site de réservation</span>
                        </li> --}}
                    </ul>
                </div>
                <div class="card-footer"></div>
            </div>
            <div class="card card-forfait" style="--basic-color : #46D8D5">
                <div class="card-content">
                    <div class="section-title">
                        <h2><span>Marque blanche</span></h2>
                    </div>
                    <p>Démarquez-vous avec votre réseau de boutique.</p>
                    <div class="price">
                        <span></span>
                        <span>Sur devis</span>
                    </div>
                    <a href="/contact">
                        <button class="button button-primary">C'EST PARTI !</button>
                    </a>
                    <ul class="options">
                        <li>
                            <div class="check">
                                <i class="ti ti-check"></i>
                            </div>
                            <span>Tarification sur devis</span>
                        </li>
                        <li>
                            <div class="check">
                                <i class="ti ti-check"></i>
                            </div>
                            <span>Création à votre identité visuelle a 100%</span>
                        </li>
                        <li>
                            <div class="check">
                                <i class="ti ti-check"></i>
                            </div>
                            <span>Développement et intégration API</span>
                        </li>
                        {{-- <li>
                            <div class="check">
                                <i class="ti ti-check"></i>
                            </div>
                            <span>Personnalisation des notifications envoyées aux clients</span>
                        </li>
                        <li>
                            <div class="check">
                                <i class="ti ti-check"></i>
                            </div>
                            <span>Gestion des cartes de fidélité, des cartes-cadeaux et des adhésions</span>
                        </li>
                        <li>
                            <div class="check">
                                <i class="ti ti-check"></i>
                            </div>
                            <span>Domaine personnalisé</span>
                        </li>
                        <li>
                            <div class="check">
                                <i class="ti ti-check"></i>
                            </div>
                            <span>Personnalisation du site de réservation</span>
                        </li>
                        <li>
                            <div class="check">
                                <i class="ti ti-check"></i>
                            </div>
                            <span>Analyse des données du site de réservation</span>
                        </li> --}}
                    </ul>
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
            <h2><span>{{ __('tarif.fonctionalites') }}</span></h2>
        </div>
        <div class="section-content">
            <div class="card-groups col-3">
                <div class="card">
                    <div class="card-content">
                        <div class="icon">
                            <img src="{{asset('frontend/assets/media/icons/card5.png')}}" alt="">
                        </div>
                        <h5>{{ __('tarif.fonction_1') }}</h5>
                        <p>{{ __('tarif.desc_1') }}</p>
                    </div>
                    <div class="card-footer"></div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="icon">
                            <img src="{{asset('frontend/assets/media/icons/card6.png')}}" alt="">
                        </div>
                        <h5>{{ __('tarif.fonction_2') }}</h5>
                        <p>{{ __('tarif.desc_2') }}</p>
                    </div>
                    <div class="card-footer"></div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="icon">
                            <img src="{{asset('frontend/assets/media/icons/card7.png')}}" alt="">
                        </div>
                        <h5>{{ __('tarif.fonction_3') }}</h5>
                        <p>{{ __('tarif.desc_3') }}</p>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
        <div class="vector" style="--color-bg:#71EDEBCD; --size:54px;--x:80%;--y:80%"></div>
        <div class="vector" style="--color-bg:#71edeb88; --size:48px;--x:70%;--y:76%"></div>
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