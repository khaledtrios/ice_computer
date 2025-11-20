<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Model-Itech</title>
  <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/logo-dark.png') }}">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    :root {
      --primary-color: {{ $boutique->primary_color }};
      --secondary-color: {{ $boutique->secondary_color }};
    }

    body {
      background-color: var(--secondary-color);
      color: var(--primary-color);
    }

    /* Cercles en background */
    .bg-circle {
      position: absolute;
      border-radius: 50%;
      opacity: 0.15;
      z-index: 0;
    }
  </style>
</head>

<body class="relative flex items-center justify-center p-6 overflow-hidden"  id="apercu">

  <!-- Cercles décoratifs -->
  <div class="bg-circle w-72 h-72 bg-[var(--primary-color)] -top-20 -left-20"></div>
  <div class="bg-circle w-96 h-96 bg-[var(--primary-color)] -bottom-24 -right-32"></div>
  <div class="bg-circle w-40 h-40 bg-[var(--primary-color)] top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"></div>

  <!-- Contenu principal -->
  <div class="relative z-10 bg-white rounded-xl shadow-xl p-10 max-w-xl w-full text-center">
   
  </div>

  <script>
    window.boutiqueId = {{ $boutique->id }};
    window.primary_color = "{{ $boutique->primary_color }}";
    window.secondary_color = "{{ $boutique->secondary_color }}";
  </script>
</body>

</html>
