<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/0.8.2/css/flag-icon.min.css">
    <link rel="stylesheet" href="{{asset('frontend/assets/libs/tabler-icons/tabler-icons.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/style.css')}}">
    <link rel="icon" href="{{asset('frontend/assets/media/logo.png')}}" type="image/x-icon" />
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="language" content="fr">
    @yield('meta')
</head>

<body>
    <div class="container height-screen">
        <nav class="lato">
            <div class="logo">
                <a href="/">
                    <img src="{{asset('frontend/assets/media/logo.png')}}" alt="Logo Ice-Computer"
                        title="Logo de le platforme Ice-Computer">
                </a>
            </div>
            <div class="leftSide" id="menu">
                <div class="menu">
                    <ul>
                        <li class="{{$index ? 'active' : ''}}">
                            <a href="/">{{ __('messages.acceuil') }}</a>
                        </li>
                        <li class="{{$tarif ? 'active' : ''}}">
                            <a href="/tarif">{{ __('messages.tarif') }}</a>
                        </li>
                        <li>
                            <a href="/#fonctionalite">{{ __('messages.fonctiononalies') }}</a>
                        </li>
                        <li class="{{$contact ? 'active' : ''}}">
                            <a href="contact">{{ __('messages.contact') }}</a>
                        </li>
                    </ul>
                </div>
                <div class="auth">
                    @auth
                        <a href="{{ route('login') }}" class="button button-secondary">{{ __('messages.dashboard') }}</a>
                    @else
                    <a href="{{ route('login') }}">{{ __('messages.login') }}</a>
                    <a href="/register" class="button button-secondary">{{ __('messages.register') }}</a>
                    <form action="{{ route('changeLang', ['locale' => session('locale', 'en')]) }}" method="GET"
                        id="lang-form">
                        <select class="selectpicker" data-width="fit" name="locale"
                            onchange="window.location.href = '{{ url('lang') }}/' + this.value">
                            <option data-content='<span class="flag-icon flag-icon-fr"></span>' value="fr" {{ session('locale') === 'fr' ? 'selected' : '' }}></option>
                            <option data-content='<span class="flag-icon flag-icon-gb"></span>' value="en" {{ session('locale') === 'en' ? 'selected' : '' }}></option>

                        </select>
                    </form>
                    @endif
                </div>
            </div>
            <div class="menuToggler" id="menuToggler"><i class="ti ti-menu-2"></i></div>
        </nav>
    </div>
    @yield('main')
    <div class="footer-container">
        <section class="banner container">
            <h5>{{ __('messages.pret_commencer') }}</h5>
            <div class="actions">
                <a href="/tarif">
                    <button class="button button-primary">{{ __('messages.consulter_tarif') }}</button>
                </a>
                <a href="/contact">
                    <button class="button button-light">{{ __('messages.contacter_nous') }}</button>
                </a>
            </div>
        </section>
        <footer>
            <div class="container">
                <div class="footer">
                    <div class="footer-menu">
                        <div class="footer-logo">
                            <a href="/">
                                <img src="{{asset('frontend/assets/media/logo-blanc.png')}}"
                                    alt="Logo Ice-Computer en version blanche"
                                    title="Retour à l'accueil - Application Ice-Computer" loading="eager">
                            </a>
                            <p></p>
                            {{-- <p>e Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en
                                page </p> --}}
                        </div>
                        <div class="menu">
                            {{-- <span class="title">Produit</span> --}}
                            <a href="/tarif">{{ __('messages.tarif') }}</a>
                            <a href="/#fonctionalite">{{ __('messages.fonctiononalies') }}</a>
                            <a href="/dashboard">{{ __('messages.login') }}</a>
                            <a href="/register">{{ __('messages.register') }}</a>
                        </div>
                        <div class="newsletter">
                            <span class="title">{{ __('messages.letter') }}</span>
                            <div class="input-container">
                                <input type="text" placeholder="{{ __('messages.input_newsletter') }}">
                                <button>
                                    <img src="{{asset('frontend/assets/media/icons/Send.png')}}"
                                        alt="Icône d'envoi pour newsletter" title="S'abonner à la newsletter"
                                        loading="lazy">
                                </button>
                            </div>
                            <div class="socials">
                                <a href="#" class="social">
                                    <img src="{{asset('frontend/assets/media/social/twitter.png')}}"
                                        alt="Icône Twitter (X) pour suivre Ice-Computer" title="Suivez-nous sur Twitter"
                                        loading="lazy">
                                </a>
                                <a href="#" class="social">
                                    <img src="{{asset('frontend/assets/media/social/Facebook.png')}}"
                                        alt="Icône Facebook pour suivre Ice-Computer" title="Suivez-nous sur Facebook"
                                        loading="lazy">
                                </a>
                                <a href="#" class="social">
                                    <img src="{{asset('frontend/assets/media/social/Instagram.png')}}"
                                        alt="Icône Instagram pour suivre Ice-Computer" title="Suivez-nous sur Instagram"
                                        loading="lazy">
                                </a>
                                <a href="#" class="social">
                                    <img src="{{asset('frontend/assets/media/social/Whatsapp.png')}}"
                                        alt="Icône WhatsApp pour contacter Ice-Computer"
                                        title="Contactez-nous via WhatsApp" loading="lazy">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="rights">{{ __('messages.droit') }}</div>
                </div>
            </div>
            <div class="circle"></div>
        </footer>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/js/bootstrap-select.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script>
        var chooseLang = function () {
            $('.selectpicker').selectpicker();
        };

        chooseLang();

        $('#menuToggler').on('click', function () {
            $('#menu').toggleClass('active');
        })
        const brandsSection = document.querySelector('.brands-section');

        brandsSection.addEventListener('mousemove', (e) => {
            const rect = brandsSection.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const skewX = (x / rect.width - 0.5) * 20;
            const skewY = (y / rect.height - 0.5) * 20;

            brandsSection.style.transform = `skew(${skewX}deg, ${skewY}deg)`;
        });

        brandsSection.addEventListener('mouseleave', () => {
            brandsSection.style.transform = 'skew(0deg, 0deg)';
        });
    </script>
    <script>
        $(document).ready(function () {
            $(".question").click(function () {
                var parentLi = $(this).parent();

                // Hide all other responses
                $(".faq-item").not(parentLi).removeClass("show");

                // Toggle the current response
                parentLi.toggleClass("show");
            });
        });
    </script>
</body>

</html>