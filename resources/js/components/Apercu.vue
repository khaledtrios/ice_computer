<template>
    <div
        class="w-full max-w-full bg-white rounded-xl shadow-xl p-2 sm:p-6 md:p-8 space-y-2 sm:space-y-4 relative"
    >
        <!-- Header avec navigation -->
        <div
            v-if="step !== 6"
            class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 sm:gap-4 relative"
        >
            <!-- Bouton Retour -->
            <button
                v-if="step > 1"
                @click="handlePreviousStep"
                class="inline-flex items-center gap-2 bg-white border border-gray-200 rounded-full px-2 sm:px-4 py-1 sm:py-1 shadow-sm text-gray-600 hover:bg-[color-mix(in_srgb,var(--primary)_10%,white)] hover:text-[var(--primary)] transition-all duration-150 font-semibold focus:outline-none focus:ring-2 focus:ring-[var(--primary)] self-start sm:self-center"
            >
                <svg
                    class="w-3 h-3 sm:w-4 sm:h-4"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 19l-7-7 7-7"
                    />
                </svg>
                <span class="hidden sm:inline text-xs sm:text-sm">Retour</span>
            </button>
            <!-- Titre centré -->
            <h2
                class="text-base sm:text-xl md:text-2xl lg:text-3xl font-extrabold tracking-tight text-gray-900 text-center flex-1 px-8 sm:px-0"
            >
                <span
                    class="inline-block bg-gradient-to-r from-[var(--primary)] via-[var(--secondary)] to-[var(--primary)] bg-clip-text text-transparent"
                >
                    {{ stepTitle }}
                </span>
            </h2>
            <!-- Badge étape et bouton aide -->
            <div
                class="flex items-center gap-2 w-full sm:w-auto justify-between sm:justify-normal"
            >
                <!-- Badge étape -->
                <span
                    class="bg-[color-mix(in_srgb,var(--primary)_10%,white)] text-[var(--primary)] text-xs font-semibold rounded-full px-2 sm:px-3 py-1 shadow-sm border border-[color-mix(in_srgb,var(--primary)_20%,transparent)]"
                >
                    Étape {{ step }} / 5
                </span>
                <!-- Bouton aide -->
                <button
                    v-if="step === 3"
                    @click="showModal = true"
                    class="flex items-center gap-2 text-[var(--primary)] font-semibold text-xs sm:text-sm rounded-lg px-2 sm:px-3 py-1 sm:py-2 bg-white hover:bg-[color-mix(in_srgb,var(--primary)_5%,white)] border border-[color-mix(in_srgb,var(--primary)_20%,transparent)] shadow hover:shadow-lg transition-all duration-200 ease-in-out active:scale-95 focus:outline-none focus:ring-2 focus:ring-[var(--primary)]"
                >
                    <svg
                        class="h-3 w-3 sm:h-4 sm:w-4"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z"
                        />
                    </svg>
                    <span class="hidden sm:inline">Trouvez mon modèle</span>
                </button>
            </div>
        </div>
        <!-- Étape 1 : Sélection du matériel -->
        <div v-if="step === 1">
            <p
                class="text-gray-700 text-sm sm:text-lg mb-2 sm:mb-4 font-medium text-center"
            >
                Choisissez votre <strong>type d'appareil</strong>
            </p>
            <div
                v-if="devices.length === 0"
                class="bg-[color-mix(in_srgb,#f59e0b_10%,white)] border-l-4 border-[#f59e0b] p-2 sm:p-4"
            >
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg
                            class="h-4 w-4 sm:h-5 sm:w-5 text-[#f59e0b]"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </div>
                    <div class="ml-2 sm:ml-3">
                        <p class="text-xs sm:text-sm text-[#f59e0b]">
                            Aucune configuration disponible pour cette boutique.
                            <span v-if="isAdmin" class="font-medium"
                                >Veuillez configurer les appareils dans
                                l'interface d'administration.</span
                            >
                        </p>
                    </div>
                </div>
            </div>
            <!-- Liste des devices -->
            <div v-else class="max-h-[60vh] overflow-y-auto scrollbar-thin">
                <div
                    class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-2 sm:gap-4"
                >
                    <div
                        v-for="device in devices"
                        :key="device.id"
                        @click="selectDevice(device)"
                        class="aspect-square bg-white rounded-xl border border-gray-200 shadow-sm flex flex-col items-center justify-center p-2 sm:p-3 transition-all hover:shadow-lg hover:-translate-y-1 cursor-pointer relative"
                    >
                        <div
                            v-if="loadingDevice === device.name"
                            class="absolute inset-0 bg-white/80 flex items-center justify-center rounded-xl z-10"
                        >
                            <svg
                                class="animate-spin h-4 w-4 sm:h-6 sm:w-6 text-[var(--primary)]"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <circle
                                    class="opacity-25"
                                    cx="12"
                                    cy="12"
                                    r="10"
                                    stroke="currentColor"
                                    stroke-width="4"
                                ></circle>
                                <path
                                    class="opacity-75"
                                    fill="currentColor"
                                    d="M4 12a8 8 0 018-8v8z"
                                ></path>
                            </svg>
                        </div>
                        <div
                            class="w-full h-12 sm:h-20 md:h-24 flex items-center justify-center mb-1 sm:mb-2"
                        >
                            <img
                                :src="getImg(device.icon)"
                                :alt="`Icône pour ${device.name}`"
                                loading="lazy"
                                class="max-w-full max-h-full object-contain"
                            />
                        </div>
                        <p
                            class="text-xs sm:text-sm font-medium text-gray-700 text-center leading-tight"
                        >
                            {{ device.name }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Étape 2 : Sélection de la marque -->
        <div v-if="step === 2">
            <p
                class="text-gray-700 text-sm sm:text-lg mb-2 sm:mb-4 font-medium text-center"
            >
                Sélectionnez la <strong>marque</strong> de votre Appareil
            </p>
            <!-- Barre de recherche pour marques -->
            <div class="flex justify-center mb-3 sm:mb-6">
                <div class="relative w-full max-w-md">
                    <input
                        type="text"
                        v-model="searchBrandQuery"
                        @input="debouncedBrandSearch"
                        placeholder="Rechercher une marque..."
                        class="w-full pl-8 sm:pl-10 pr-3 sm:pr-4 py-1 sm:py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary)] focus:border-[var(--primary)] text-xs sm:text-base"
                    />
                    <svg
                        v-if="!searchBrandLoading"
                        class="w-3 h-3 sm:w-5 sm:h-5 text-gray-400 absolute left-2 sm:left-3 top-2 sm:top-3"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103 10.5a7.5 7.5 0013.15 6.15z"
                        />
                    </svg>
                    <svg
                        v-if="searchBrandLoading"
                        class="animate-spin h-3 w-3 sm:h-5 sm:w-5 text-[var(--primary)] absolute left-2 sm:left-3 top-2 sm:top-3"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <circle
                            class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"
                        ></circle>
                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8v8z"
                        ></path>
                    </svg>
                </div>
            </div>
            <!-- Message si aucune marque trouvée -->
            <div
                v-if="filteredBrands.length === 0 && searchBrandQuery"
                class="bg-[color-mix(in_srgb,#f59e0b_10%,white)] border-l-4 border-[#f59e0b] p-2 sm:p-4 mt-3 sm:mt-4 text-center"
            >
                <p class="text-xs sm:text-sm text-[#f59e0b]">
                    Aucune marque trouvée pour "{{ searchBrandQuery }}". Essayez
                    un autre terme de recherche.
                </p>
            </div>
            <!-- Liste des marques avec scroll -->
            <div
                v-if="filteredBrands.length > 0 || !searchBrandQuery"
                class="max-h-[60vh] overflow-y-auto scrollbar-thin"
            >
                <div
                    class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-2 sm:gap-3"
                >
                    <div
                        v-for="brand in filteredBrands"
                        :key="brand.id"
                        @click="selectBrand(brand)"
                        class="aspect-square bg-white rounded-xl border border-gray-200 shadow-sm flex items-center justify-center p-2 sm:p-3 transition-all hover:shadow-lg hover:-translate-y-1 hover:bg-gray-50 cursor-pointer relative"
                    >
                        <div
                            v-if="loadingBrand === brand.name"
                            class="absolute inset-0 bg-white/80 flex items-center justify-center rounded-xl z-10"
                        >
                            <svg
                                class="animate-spin h-4 w-4 sm:h-6 sm:w-6 text-[var(--primary)]"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <circle
                                    class="opacity-25"
                                    cx="12"
                                    cy="12"
                                    r="10"
                                    stroke="currentColor"
                                    stroke-width="4"
                                ></circle>
                                <path
                                    class="opacity-75"
                                    fill="currentColor"
                                    d="M4 12a8 8 0 018-8v8z"
                                ></path>
                            </svg>
                        </div>
                        <img
                            :src="getImg(brand.logo)"
                            :alt="brand.name"
                            loading="lazy"
                            class="h-10 sm:h-16 md:h-20 w-auto object-contain"
                        />
                    </div>
                </div>
            </div>
        </div>
        <!-- Étape 3 : Choix du modèle -->
        <div v-if="step === 3">
            <p
                class="text-gray-700 text-sm sm:text-lg mb-2 sm:mb-4 font-medium text-center"
            >
                Sélectionnez le <strong>modèle</strong> de votre Appareil
            </p>
            <!-- Barre de recherche -->
            <div class="flex justify-center mb-3 sm:mb-6">
                <div class="relative w-full max-w-md">
                    <input
                        type="text"
                        v-model="searchQuery"
                        @input="debouncedSearch"
                        placeholder="Rechercher un modèle..."
                        class="w-full pl-8 sm:pl-10 pr-3 sm:pr-4 py-1 sm:py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary)] focus:border-[var(--primary)] text-xs sm:text-base"
                    />
                    <svg
                        v-if="!searchLoading"
                        class="w-3 h-3 sm:w-5 sm:h-5 text-gray-400 absolute left-2 sm:left-3 top-2 sm:top-3"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103 10.5a7.5 7.5 0013.15 6.15z"
                        />
                    </svg>
                    <svg
                        v-if="searchLoading"
                        class="animate-spin h-3 w-3 sm:h-5 sm:w-5 text-[var(--primary)] absolute left-2 sm:left-3 top-2 sm:top-3"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <circle
                            class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"
                        ></circle>
                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8v8z"
                        ></path>
                    </svg>
                </div>
            </div>
            <!-- Message si aucun modèle trouvé -->
            <div
                v-if="filteredModels.length === 0 && searchQuery"
                class="bg-[color-mix(in_srgb,#f59e0b_10%,white)] border-l-4 border-[#f59e0b] p-2 sm:p-4 mt-3 sm:mt-4"
            >
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg
                            class="h-4 w-4 sm:h-5 sm:w-5 text-[#f59e0b]"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </div>
                    <div class="ml-2 sm:ml-3">
                        <p class="text-xs sm:text-sm text-[#f59e0b]">
                            Aucun modèle trouvé pour "{{ searchQuery }}".
                            Essayez un autre terme de recherche.
                        </p>
                    </div>
                </div>
            </div>
            <!-- Liste des modèles avec scroll -->
            <div
                v-if="filteredModels.length > 0 || !searchQuery"
                class="max-h-[60vh] overflow-y-auto scrollbar-thin"
            >
                <div
                    class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-2 sm:gap-3"
                >
                    <div
                        v-for="model in filteredModels"
                        :key="model.id"
                        @click="selectModel(model)"
                        class="aspect-square bg-white rounded-xl border border-gray-200 shadow-sm p-2 sm:p-3 hover:shadow-lg transition-all cursor-pointer flex flex-col items-center justify-center relative"
                    >
                        <div
                            v-if="loadingModel === model.name"
                            class="absolute inset-0 bg-white/80 flex items-center justify-center rounded-xl z-10"
                        >
                            <svg
                                class="animate-spin h-4 w-4 sm:h-6 sm:w-6 text-[var(--primary)]"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <circle
                                    class="opacity-25"
                                    cx="12"
                                    cy="12"
                                    r="10"
                                    stroke="currentColor"
                                    stroke-width="4"
                                ></circle>
                                <path
                                    class="opacity-75"
                                    fill="currentColor"
                                    d="M4 12a8 8 0 018-8v8z"
                                ></path>
                            </svg>
                        </div>
                        <img
                            :src="getImg(model.image)"
                            :alt="`Icône pour ${model.name}`"
                            loading="lazy"
                            class="h-16 sm:h-24 md:h-32 w-auto object-contain mb-2 sm:mb-4"
                        />
                        <div class="text-center">
                            <p
                                class="text-xs sm:text-sm font-medium leading-tight"
                            >
                                {{ model.name }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Étape 4 : Réparations -->
        <div
            v-if="step === 4"
            class="space-y-6 overflow-y-auto max-h-[calc(80vh-80px)] px-4 sm:px-6 scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-100"
        >
            <!-- Overlay de chargement -->
            <div
                v-if="loadingRepairs"
                class="absolute inset-0 bg-white/80 flex items-center justify-center rounded-xl z-10"
            >
                <svg
                    class="animate-spin h-6 w-6 sm:h-8 sm:w-8 text-[var(--primary)]"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                >
                    <circle
                        class="opacity-25"
                        cx="12"
                        cy="12"
                        r="10"
                        stroke="currentColor"
                        stroke-width="4"
                    ></circle>
                    <path
                        class="opacity-75"
                        fill="currentColor"
                        d="M4 12a8 8 0 018-8v8z"
                    ></path>
                </svg>
            </div>
            <div :class="{ 'opacity-50 pointer-events-none': loadingRepairs }">
                <div class="flex flex-col lg:flex-row gap-3 sm:gap-6">
                    <!-- Colonne gauche : liste des réparations -->
                    <div class="flex-1 space-y-3 sm:space-y-4 order-1">
                        <h3
                            class="text-xs sm:text-sm font-semibold text-gray-800 mb-2 sm:mb-3"
                        >
                            Sélectionner une panne
                        </h3>
                        <div
                            class="grid grid-cols-1 md:grid-cols-2 gap-2 sm:gap-3 p-2 scrollbar-thin"
                        >
                            <template
                                v-for="repair in repairs"
                                :key="repair.id"
                            >
                                <div
                                    @click="toggleRepair(repair)"
                                    v-if="hasPrice(repair)"
                                    :class="[
                                        'cursor-pointer border border-gray-200 rounded-xl p-2 sm:p-4 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all relative',
                                        selectedRepairs.find(
                                            (r) => r.id === repair.id
                                        )
                                            ? 'ring-2 ring-[var(--secondary)] bg-[color-mix(in_srgb,var(--secondary)_5%,white)]'
                                            : 'bg-white',
                                    ]"
                                >
                                    <div
                                        class="flex flex-col sm:flex-row justify-between items-start gap-2"
                                    >
                                        <div class="flex-1">
                                            <h4
                                                class="text-xs sm:text-sm font-semibold uppercase"
                                            >
                                                {{ repair.nom }}
                                                <span
                                                    v-if="
                                                        selectedRepairs.find(
                                                            (r) =>
                                                                r.id ===
                                                                repair.id
                                                        )
                                                    "
                                                >
                                                    ({{
                                                        selectedRepairs.find(
                                                            (r) =>
                                                                r.id ===
                                                                repair.id
                                                        ).type.nom ||
                                                        "Type non sélectionné"
                                                    }})
                                                </span>
                                            </h4>
                                            <p
                                                class="text-[0.65rem] sm:text-xs text-gray-600 mt-1 line-clamp-2"
                                            >
                                                {{
                                                    repair.description ||
                                                    "Aucune description disponible"
                                                }}
                                            </p>
                                            <!-- Menu déroulant des types -->
                                        </div>
                                        <div class="text-right flex-shrink-0">
                                            <p
                                                class="text-[0.65rem] sm:text-xs text-gray-400"
                                            >
                                                {{
                                                    repair.duration ||
                                                    "Durée non spécifiée"
                                                }}
                                            </p>
                                            <div
                                                class="mt-1 px-1 sm:px-2 py-1 text-[0.65rem] sm:text-xs rounded bg-gray-100 border border-gray-300 inline-block"
                                            >
                                                <template
                                                    v-if="
                                                        selectedRepairs.find(
                                                            (r) =>
                                                                r.id ===
                                                                repair.id
                                                        )
                                                    "
                                                >
                                                    <span
                                                        v-if="
                                                            selectedRepairs.find(
                                                                (r) =>
                                                                    r.id ===
                                                                    repair.id
                                                            ).hasPromo
                                                        "
                                                        class="line-through text-gray-400 mr-1"
                                                    >
                                                        {{
                                                            selectedRepairs
                                                                .find(
                                                                    (r) =>
                                                                        r.id ===
                                                                        repair.id
                                                                )
                                                                .originalPrice.toFixed(
                                                                    2
                                                                )
                                                        }}€
                                                    </span>
                                                    <span class="font-semibold">
                                                        {{
                                                            ((r) =>
                                                                r.price > 0
                                                                    ? r.price.toFixed(
                                                                          2
                                                                      ) + " €"
                                                                    : "Prix sur demande")(
                                                                selectedRepairs.find(
                                                                    (r) =>
                                                                        r.id ===
                                                                        repair.id
                                                                )
                                                            )
                                                        }}
                                                    </span>
                                                </template>
                                                <template
                                                    v-else-if="
                                                        getTypePrice(repair)
                                                            .originalPrice
                                                    "
                                                >
                                                    <span
                                                        v-if="
                                                            getTypePrice(repair)
                                                                .hasPromo
                                                        "
                                                        class="line-through text-gray-400 mr-1"
                                                    >
                                                        {{
                                                            getTypePrice(
                                                                repair
                                                            ).originalPrice.toFixed(
                                                                2
                                                            )
                                                        }}€
                                                    </span>
                                                    <span class="font-semibold">
                                                        {{
                                                            getTypePrice(
                                                                repair
                                                            ).price.toFixed(2)
                                                        }}
                                                        €
                                                    </span>
                                                </template>
                                                <template v-else>
                                                    Prix sur demande
                                                </template>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        v-if="selectedRepairId === repair.id"
                                        class="z-50 mt-2 w-full bg-white border border-gray-300 rounded-lg shadow-lg md:w-100"
                                    >
                                        <ul class="py-1">
                                            <template
                                                v-for="type in repair.types"
                                                :key="type.id"
                                            >
                                                <li
                                                    v-if="
                                                        type.prix_initial > 0 ||
                                                        this.modeconfig ===
                                                            'Devis'
                                                    "
                                                    @click.stop="
                                                        selectRepairType(
                                                            repair,
                                                            type
                                                        )
                                                    "
                                                    class="px-2 sm:px-4 py-1 sm:py-2 text-[0.65rem] sm:text-sm text-gray-700 hover:bg-[color-mix(in_srgb,var(--secondary)_5%,white)] cursor-pointer flex justify-between items-center"
                                                >
                                                    <div>
                                                        <span>{{
                                                            type.nom
                                                        }}</span>
                                                        <span
                                                            v-if="
                                                                type.is_qualirepar
                                                            "
                                                            class="grid text-center text-red-600 text-[9px]"
                                                            >Qualirepar -
                                                            {{
                                                                type.montant
                                                            }}</span
                                                        >
                                                    </div>

                                                    <span
                                                        class="text-right text-[0.65rem] sm:text-xs"
                                                    >
                                                        <template
                                                            v-if="
                                                                getTypePrice(
                                                                    repair,
                                                                    type
                                                                ).hasPromo
                                                            "
                                                        >
                                                            <span
                                                                class="line-through text-gray-400 mr-1"
                                                                >{{
                                                                    getTypePrice(
                                                                        repair,
                                                                        type
                                                                    ).originalPrice.toFixed(
                                                                        2
                                                                    )
                                                                }}€</span
                                                            >
                                                            <span
                                                                class="text-green-600 font-bold"
                                                                >{{
                                                                    getTypePrice(
                                                                        repair,
                                                                        type
                                                                    ).price.toFixed(
                                                                        2
                                                                    )
                                                                }}
                                                                €</span
                                                            >
                                                        </template>
                                                        <template v-else>
                                                            <span>{{
                                                                getTypePrice(
                                                                    repair,
                                                                    type
                                                                ).price
                                                                    ? getTypePrice(
                                                                          repair,
                                                                          type
                                                                      ).price.toFixed(
                                                                          2
                                                                      ) + " €"
                                                                    : "Prix sur demande"
                                                            }}</span>
                                                        </template>
                                                    </span>
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                    <div
                        class="w-full md:w-100 lg:w-80 2xl:w-96 bg-gray-50 border border-gray-200 rounded-xl p-2 sm:p-4 space-y-2 sm:space-y-4 order-2 overflow-y-auto"
                    >
                        <div
                            v-if="selectedModel"
                            class="bg-white border border-gray-100 rounded-lg p-2 sm:p-3 shadow-sm"
                        >
                            <h4
                                class="text-xs sm:text-sm font-semibold text-gray-800 mb-1"
                            >
                                Modèle sélectionné
                            </h4>
                            <p
                                class="text-sm sm:text-base text-gray-700 truncate font-medium"
                            >
                                {{
                                    selectedModel.name || selectedModel.libelle
                                }}
                            </p>
                            <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
                                {{ selectedModel.description || "" }}
                            </p>
                            <img
                                v-if="selectedModel.image"
                                :src="getImg(selectedModel.image)"
                                loading="lazy"
                                alt="Image modèle"
                                class="mt-1 w-full rounded-md object-contain max-h-16 sm:max-h-24"
                            />
                        </div>
                        <div>
                            <h3
                                class="text-xs sm:text-sm font-semibold text-gray-800 mb-1 sm:mb-3"
                            >
                                Liste des pannes ({{ selectedRepairs.length }})
                            </h3>
                            <div
                                class="space-y-1 sm:space-y-2 max-h-28 sm:max-h-40 overflow-y-auto scrollbar-thin"
                            >
                                <div
                                    v-for="item in selectedRepairs"
                                    :key="item.id"
                                    class="flex items-center justify-between bg-white rounded-lg px-2 sm:px-3 py-1 sm:py-2 border border-gray-100 shadow-sm hover:bg-[color-mix(in_srgb,var(--secondary)_5%,white)] transition"
                                >
                                    <span
                                        class="flex-1 font-medium text-gray-700 text-xs sm:text-sm truncate"
                                    >
                                        {{ item.name }} ({{ item.type.nom }})
                                    </span>
                                    <div
                                        class="text-right flex items-center gap-1 sm:gap-2"
                                    >
                                        <span
                                            v-if="
                                                item.originalPrice &&
                                                item.originalPrice > 0
                                            "
                                            class="line-through text-gray-400 text-[0.65rem] sm:text-xs"
                                        >
                                            {{ item.originalPrice.toFixed(2) }}
                                            €
                                        </span>
                                        <span
                                            class="font-semibold text-[var(--secondary)] text-[0.65rem] sm:text-xs"
                                        >
                                            {{
                                                item.price > 0
                                                    ? item.price.toFixed(2) +
                                                      " €"
                                                    : "Prix sur demande"
                                            }}
                                        </span>
                                        <button
                                            @click.stop="removeRepair(item.id)"
                                            class="text-red-600 hover:text-red-800 ml-1"
                                            aria-label="Supprimer la réparation"
                                        >
                                            <svg
                                                class="w-4 h-4 sm:w-5 sm:h-5"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12"
                                                />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div
                                    v-if="selectedRepairs.length === 0"
                                    class="text-center py-2 sm:py-4 text-gray-500 text-xs sm:text-sm"
                                >
                                    Aucune panne sélectionnée
                                </div>
                            </div>
                        </div>
                        <div class="pt-2 sm:pt-4 border-t border-gray-200">
                            <div
                                v-if="modeconfig !== 'Devis'"
                                class="space-y-0.5 sm:space-y-1 mb-2 sm:mb-4"
                            >
                                <div
                                    class="text-xs sm:text-sm flex justify-between font-medium"
                                >
                                    <span>Sous-total</span>
                                    <span>{{ subTotal.toFixed(2) }} €</span>
                                </div>
                                <div
                                    v-if="applyComboRemise"
                                    class="text-xs sm:text-sm flex justify-between font-medium text-red-600"
                                >
                                    <span>Remise combo (-10%)</span>
                                    <span
                                        >-{{ comboDiscount.toFixed(2) }} €</span
                                    >
                                </div>

                                <div
                                    v-if="subTotal > 0 && remiseOnline > 0"
                                    class="flex justify-between text-green-600"
                                >
                                    <span>Remise en ligne -10% :</span>
                                    <span
                                        >-{{
                                            applyDiscount(
                                                subTotal,
                                                remiseOnline / 100
                                            )
                                        }}
                                        €</span
                                    >
                                </div>

                                <div
                                    v-if="remiseQualirepar > 0"
                                    class="flex justify-between text-red-600"
                                >
                                    <span>Remise Qualirepar :</span>
                                    <span
                                        >-{{
                                            remiseQualirepar.toFixed(2)
                                        }}
                                        €</span
                                    >
                                </div>
                                <div
                                    class="text-xs sm:text-sm flex justify-between font-semibold border-t pt-1"
                                >
                                    <span>Total</span>
                                    <span>{{ total.toFixed(2) }} €</span>
                                </div>
                            </div>
                            <button
                                class="w-full bg-gray-800 text-white rounded-xl py-2 sm:py-3 text-xs sm:text-sm font-medium hover:bg-gray-900 transition disabled:opacity-50 disabled:cursor-not-allowed"
                                :disabled="selectedRepairs.length === 0"
                                @click="showPrducts"
                            >
                                Étape Suivante
                            </button>

                            <p
                                class="text-[0.65rem] sm:text-xs text-gray-400 text-center mt-1 sm:mt-2"
                            >
                                Vous ne payez qu'une fois la réparation
                                effectuée
                            </p>
                        </div>
                    </div>
                </div>

                <!-- SECTION RACHAT -->
                <div
                    v-if="modeconfig !== 'Devis' && hasNonZeroPrices"
                    class="mt-4 sm:mt-8"
                >
                    <div
                        class="bg-[color-mix(in_srgb,var(--primary)_5%,white)] border border-[color-mix(in_srgb,var(--primary)_20%,transparent)] rounded-xl p-3 sm:p-6 space-y-3 sm:space-y-4"
                    >
                        <h3
                            class="text-sm sm:text-lg font-bold text-[var(--primary)] flex items-center gap-2"
                        >
                            <svg
                                class="w-4 h-4 sm:w-5 sm:h-5 text-[var(--primary)]"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"
                                />
                            </svg>
                        </h3>
                        <!-- Choix de l'état -->
                        <div
                            class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-6"
                        >
                            <span
                                class="font-medium text-gray-700 text-xs sm:text-sm"
                                >État :</span
                            >
                            <div class="flex flex-wrap gap-2">
                                <span
                                    :class="[
                                        'px-2 sm:px-3 py-1 sm:py-2 rounded-full cursor-pointer text-xs sm:text-sm font-semibold border transition',
                                        etatRachat === 'bon'
                                            ? 'bg-[var(--primary)] text-white border-[var(--primary)] shadow'
                                            : 'bg-white text-[var(--primary)] border-[color-mix(in_srgb,var(--primary)_20%,transparent)] hover:bg-[color-mix(in_srgb,var(--primary)_5%,white)]',
                                    ]"
                                    @click="etatRachat = 'bon'"
                                >
                                    Bon état
                                </span>
                                <span
                                    :class="[
                                        'px-2 sm:px-3 py-1 sm:py-2 rounded-full cursor-pointer text-xs sm:text-sm font-semibold border transition',
                                        etatRachat === 'mauvais'
                                            ? 'bg-red-600 text-white border-red-600 shadow'
                                            : 'bg-white text-red-700 border-red-200 hover:bg-red-100',
                                    ]"
                                    @click="etatRachat = 'mauvais'"
                                >
                                    Mauvais état
                                </span>
                                <span
                                    :class="[
                                        'px-2 sm:px-3 py-1 sm:py-2 rounded-full cursor-pointer text-xs sm:text-sm font-semibold border transition',
                                        etatRachat === 'piece'
                                            ? 'bg-red-600 text-white border-red-600 shadow'
                                            : 'bg-white text-red-700 border-red-200 hover:bg-red-100',
                                    ]"
                                    @click="etatRachat = 'piece'"
                                >
                                    Pièce
                                </span>
                            </div>
                        </div>
                        <div>
                            <span
                                class="block font-medium text-gray-700 text-xs sm:text-sm mb-2"
                            >
                                Prix de rachat selon la capacité ({{
                                    etatRachat === "bon"
                                        ? "Bon état"
                                        : etatRachat === "mauvais"
                                        ? "Mauvais état"
                                        : "Pièce"
                                }}) :
                            </span>
                            <div class="overflow-x-auto">
                                <table
                                    class="w-full min-w-[200px] sm:min-w-[250px] border bg-white rounded-lg text-xs sm:text-sm shadow"
                                >
                                    <thead>
                                        <tr
                                            class="bg-[color-mix(in_srgb,var(--primary)_10%,white)] text-[var(--primary)]"
                                        >
                                            <th
                                                class="px-2 sm:px-4 py-1 sm:py-2 text-left font-semibold"
                                            >
                                                Capacité
                                            </th>
                                            <th
                                                class="px-2 sm:px-4 py-1 sm:py-2 text-left font-semibold"
                                            >
                                                Prix (€)
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="capa in capacites"
                                            :key="capa"
                                        >
                                            <td
                                                class="px-2 sm:px-4 py-1 sm:py-2 font-medium"
                                            >
                                                {{ capa }} Go
                                            </td>
                                            <td
                                                class="px-2 sm:px-4 py-1 sm:py-2 text-[var(--primary)] font-bold"
                                            >
                                                {{
                                                    prixRachat[etatRachat][
                                                        capa
                                                    ] || 0
                                                }}
                                                €
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div
            v-if="step === 5"
            class="space-y-6 overflow-y-auto max-h-[calc(80vh-80px)] px-4 sm:px-6 scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-100"
        >
            <div v-if="selectedRepairs.length" class="mb-6">
                <h3
                    class="text-lg sm:text-xl font-bold text-gray-800 mb-4 text-center"
                >
                    Liste des pannes que vous souhaitez faire deviser
                </h3>
                <div class="space-y-3 max-w-3xl mx-auto">
                    <div
                        v-for="item in selectedRepairs"
                        :key="item.id"
                        class="flex items-center justify-between bg-white rounded-lg px-4 py-3 border border-gray-100 shadow-sm hover:bg-gray-50 transition"
                    >
                       
                        <span
                            class="flex-1 font-medium text-gray-700 text-sm sm:text-base"
                        >
                            {{ item.name }} ({{ item.type.nom }})
                        </span>
                        <div
                            class="text-right flex items-center gap-2 sm:gap-3"
                        >
                            <span
                                v-if="
                                    item.originalPrice && item.originalPrice > 0
                                "
                                class="line-through text-gray-400 text-xs sm:text-sm"
                            >
                                {{ item.originalPrice.toFixed(2) }} €
                            </span>
                            <span
                                class="font-semibold text-[var(--secondary)] text-sm sm:text-base"
                            >
                                {{
                                    item.price > 0
                                        ? item.price.toFixed(2) + " €"
                                        : "Prix sur demande"
                                }}
                            </span>
                        </div>
                    </div>
                    <div v-if="selectedProduct" style="border-bottom: 1px dashed #b1abab;"> </div>
                    <div
                       v-if="selectedProduct"
                        class="flex items-center justify-between bg-white rounded-lg px-4 py-3 border border-gray-100 shadow-sm hover:bg-gray-50 transition"
                    >
                         <img
                            :src="selectedProduct.image"
                            alt="Image du panne"
                            class="img-fluid rounded"
                            style="max-height: 25px;  object-fit: contain"
                        />
                        <span
                            class="flex-1 font-medium text-gray-700 text-sm sm:text-base"
                        >
                            {{ selectedProduct.name }}  
                        </span>
                        <div
                            class="text-right flex items-center gap-2 sm:gap-3"
                        >
                             
                            <span
                                class="font-semibold text-[var(--secondary)] text-sm sm:text-base"
                            >
                                {{
                                     selectedProduct.price + " €"
                                       
                                }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="mt-4 max-w-3xl mx-auto">
                    <div
                        v-if="modeconfig !== 'Devis'"
                        class="text-sm sm:text-base text-right space-y-2 bg-gray-50 rounded-lg p-4"
                    >
                        <div class="flex justify-between">
                            <span>Sous-total :</span>
                            <span class="text-gray-600"
                                >{{ subTotal.toFixed(2) }} €</span
                            >
                        </div>
                        <div
                            v-if="applyComboRemise"
                            class="flex justify-between text-red-600"
                        >
                            <span>Remise combo :</span>
                            <span>-{{ comboDiscount.toFixed(2) }} €</span>
                        </div>

                        <div
                            v-if="
                                subTotal > 0 &&
                                selectedAppointmentOption.price > 0
                            "
                            class="flex justify-between text-gray-600"
                        >
                            <span
                                >{{ selectedAppointmentOption?.label }} :</span
                            >
                            <span>{{ selectedAppointmentOption.price }} €</span>
                        </div>

                        <div
                            v-if="subTotal > 0 && remiseOnline > 0"
                            class="flex justify-between text-green-600"
                        >
                            <span>Remise en ligne -10% :</span>
                            <span
                                >-{{
                                    applyDiscount(subTotal, remiseOnline / 100)
                                }}
                                €</span
                            >
                        </div>

                        <div
                            v-if="remiseQualirepar > 0"
                            class="flex justify-between text-red-600"
                        >
                            <span>Remise Qualirepar :</span>
                            <span>-{{ remiseQualirepar.toFixed(2) }} €</span>
                        </div>
                        <div
                            class="font-semibold flex justify-between border-t pt-2"
                        >
                            <span>Total :</span>
                            <span class="text-[var(--secondary)]"
                                >{{ total.toFixed(2) }} €</span
                            >
                        </div>
                    </div>
                    <div
                        v-else
                        class="text-sm sm:text-base font-semibold text-right bg-gray-50 rounded-lg p-4"
                    >
                        Total :
                        {{
                            subTotal > 0
                                ? subTotal.toFixed(2) + " €"
                                : "Prix sur demande"
                        }}
                    </div>
                </div>
            </div>
            <div
                v-if="errorMessage"
                class="mb-6 text-sm sm:text-base text-red-600 bg-red-50 p-4 rounded-lg text-center"
            >
                {{ errorMessage }}
            </div>
            <div class="flex flex-col lg:flex-row gap-6">
                <div
                    v-if="modeconfig !== 'Devis'"
                    class="w-full lg:w-1/2 space-y-6"
                >
                    <div
                        class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm"
                    >
                        <h3
                            class="text-lg sm:text-xl font-semibold text-gray-900 mb-4"
                        >
                            Type de rendez-vous
                        </h3>
                        <div
                            v-if="appointmentOptions.length > 0"
                            class="space-y-3"
                        >
                            <div
                                v-for="option in appointmentOptions"
                                :key="option.id"
                                class="flex items-start gap-3 p-3 rounded-lg transition-colors hover:bg-gray-50 border border-gray-100"
                                role="radio"
                                :aria-checked="
                                    selectedAppointmentOption === option.id
                                "
                                tabindex="0"
                                @click="selectAppointmentOption(option)"
                                @keydown.enter="selectAppointmentOption(option)"
                            >
                                <input
                                    type="radio"
                                    :id="`option-${option.id}`"
                                    :value="option"
                                    v-model="selectedAppointmentOption"
                                    class="h-5 w-5 text-[var(--primary)] focus:ring-[var(--primary)] mt-1"
                                />
                                <label
                                    :for="`option-${option.id}`"
                                    class="flex-1 cursor-pointer"
                                >
                                    <span
                                        class="text-sm sm:text-base font-medium text-gray-700 block"
                                    >
                                        {{ option.label }} ({{ option.price }}€)
                                    </span>
                                    <span
                                        v-if="option.description"
                                        class="text-xs sm:text-sm text-gray-500 block mt-1"
                                    >
                                        {{ option.description }}
                                    </span>
                                </label>
                            </div>
                        </div>
                        <p
                            v-else
                            class="text-sm sm:text-base text-gray-500 text-center py-4"
                        >
                            Aucun type de rendez-vous disponible.
                        </p>
                    </div>
                    <!-- Adresses disponibles -->
                    <div
                        class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm"
                    >
                        <h3
                            class="text-lg sm:text-xl font-semibold text-gray-900 mb-4"
                        >
                            Adresses disponibles
                        </h3>
                        <div
                            v-if="shopAddresses.length > 0"
                            class="space-y-3 adressssssssssssss"
                        >
                            <div
                                v-for="(address, index) in shopAddresses"
                                :key="index"
                                class="flex items-start gap-3 p-3 rounded-lg transition-colors hover:bg-gray-50 border border-gray-100"
                                role="radio"
                                :aria-checked="
                                    selectedAddress === address.address
                                "
                                tabindex="0"
                                @click="selectAddress(address.address)"
                                @keydown.enter="selectAddress(address.address)"
                            >
                                <input
                                    type="radio"
                                    :id="`address-${index}`"
                                    :value="address.address"
                                    v-model="selectedAddress"
                                    class="h-5 w-5 text-[var(--primary)] focus:ring-[var(--primary)] mt-1"
                                />
                                <label
                                    :for="`address-${index}`"
                                    class="flex-1 cursor-pointer"
                                >
                                    <span
                                        class="text-sm sm:text-base text-gray-700"
                                        >{{ address.address }}</span
                                    >
                                </label>
                            </div>
                        </div>
                        <p
                            v-else
                            class="text-sm sm:text-base text-gray-500 text-center py-4"
                        >
                            Aucune adresse disponible.
                        </p>
                    </div>
                    <!-- Disponibilité -->
                    <div
                        class="bg-[color-mix(in srgb, var(--primary) 5%, white)] border border-[color-mix(in srgb, var(--primary) 20%, transparent)] rounded-xl p-6"
                    >
                        <h3
                            class="text-lg sm:text-xl font-semibold text-[var(--primary)] mb-4 flex items-center gap-2"
                        >
                            <svg
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                            >
                                <rect
                                    x="3"
                                    y="4"
                                    width="18"
                                    height="18"
                                    rx="2"
                                ></rect>
                                <path d="M16 2v4M8 2v4M3 10h18"></path>
                            </svg>
                            Disponibilité Boutique
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label
                                    for="rdvDate"
                                    class="block text-sm sm:text-base font-medium text-gray-700 mb-2"
                                >
                                    Date de Rendez-vous :
                                </label>
                                <input
                                    id="rdvDate"
                                    type="date"
                                    v-model="rdvDate"
                                    class="w-full border rounded-lg px-4 py-2 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-[var(--primary)]"
                                    required
                                    :min="
                                        new Date().toISOString().split('T')[0]
                                    "
                                />
                            </div>
                            <div>
                                <span
                                    class="block text-sm sm:text-base font-medium text-gray-700 mb-2"
                                >
                                    Heures disponibles :
                                </span>
                                <div class="flex flex-wrap gap-3">
                                    <button
                                        v-for="slot in dispoSlots"
                                        :key="slot"
                                        @click="selectedSlot = slot"
                                        :class="[
                                            'px-4 py-2 rounded-lg border text-sm sm:text-base font-semibold transition flex-1 min-w-[90px]',
                                            selectedSlot === slot
                                                ? 'bg-[var(--primary)] text-white border-[var(--primary)] shadow-sm'
                                                : 'bg-white text-[var(--primary)] border-[color-mix(in srgb, var(--primary) 20%, transparent)] hover:bg-[color-mix(in srgb, var(--primary) 5%, white)]',
                                        ]"
                                    >
                                        {{ slot }}
                                    </button>
                                </div>
                                <p
                                    v-if="selectedSlot"
                                    class="mt-3 text-green-700 text-sm sm:text-base font-medium"
                                >
                                    ✓ Heure sélectionnée : {{ selectedSlot }}
                                </p>
                                <p
                                    v-else-if="dispoSlots.length > 0"
                                    class="mt-3 text-orange-600 text-sm sm:text-base"
                                >
                                    Veuillez sélectionner une heure
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Right Column: Formulaire client -->
                <div class="w-full">
                    <div
                        class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm"
                    >
                        <h3
                            class="text-lg sm:text-xl font-semibold text-gray-900 mb-4"
                        >
                            Coordonnées Client
                        </h3>
                        <form
                            @submit.prevent="sendDataToBackend"
                            class="space-y-4"
                        >
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-sm sm:text-base font-medium text-gray-700 mb-2"
                                    >
                                        Nom *
                                    </label>
                                    <input
                                        type="text"
                                        v-model="client.nom"
                                        class="w-full border rounded-lg px-4 py-2 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-[var(--primary)]"
                                        placeholder="Votre nom"
                                        required
                                    />
                                </div>
                                <div>
                                    <label
                                        class="block text-sm sm:text-base font-medium text-gray-700 mb-2"
                                    >
                                        Prénom *
                                    </label>
                                    <input
                                        type="text"
                                        v-model="client.prenom"
                                        class="w-full border rounded-lg px-4 py-2 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-[var(--primary)]"
                                        placeholder="Votre prénom"
                                        required
                                    />
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-sm sm:text-base font-medium text-gray-700 mb-2"
                                    >
                                        Téléphone *
                                    </label>
                                    <input
                                        type="tel"
                                        v-model="client.tel"
                                        class="w-full border rounded-lg px-4 py-2 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-[var(--primary)]"
                                        placeholder="Votre téléphone"
                                        required
                                    />
                                </div>
                                <div>
                                    <label
                                        class="block text-sm sm:text-base font-medium text-gray-700 mb-2"
                                    >
                                        Email
                                    </label>
                                    <input
                                        type="email"
                                        v-model="client.email"
                                        class="w-full border rounded-lg px-4 py-2 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-[var(--primary)]"
                                        placeholder="Votre email"
                                    />
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block text-sm sm:text-base font-medium text-gray-700 mb-2"
                                >
                                    Adresse
                                </label>
                                <input
                                    type="text"
                                    v-model="client.adresse"
                                    class="w-full border rounded-lg px-4 py-2 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-[var(--primary)]"
                                    placeholder="Votre adresse"
                                />
                            </div>
                            <div>
                                <label
                                    class="block text-sm sm:text-base font-medium text-gray-700 mb-2"
                                >
                                    Remarques
                                </label>
                                <textarea
                                    v-model="client.notes"
                                    class="w-full border rounded-lg px-4 py-2 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-[var(--primary)]"
                                    rows="4"
                                    placeholder="Remarques supplémentaires..."
                                ></textarea>
                            </div>
                            <button
                                type="submit"
                                :disabled="!isFormValid || isSubmitting"
                                class="w-full bg-[var(--primary)] text-white rounded-lg py-3 text-sm sm:text-base font-semibold hover:[color-mix(in srgb, var(--primary) 80%, black)] transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center"
                            >
                                <svg
                                    v-if="isSubmitting"
                                    class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <circle
                                        class="opacity-25"
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        stroke-width="4"
                                    ></circle>
                                    <path
                                        class="opacity-75"
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                    ></path>
                                </svg>
                                <span>{{
                                    isSubmitting
                                        ? "Confirmation en cours..."
                                        : "Confirmer mes informations"
                                }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Étape 6 : Confirmation -->
        <div
            v-if="step === 6"
            class="flex flex-col items-center justify-center text-center p-3 sm:p-8"
        >
            <div
                class="bg-green-100 text-green-600 w-12 sm:w-16 h-12 sm:h-16 rounded-full flex items-center justify-center mb-3 sm:mb-4"
            >
                <svg
                    class="w-6 h-6 sm:w-8 sm:h-8"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                >
                    <path
                        d="M5 13l4 4L19 7"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </div>
            <h2
                class="text-base sm:text-2xl font-semibold text-gray-900 mb-2 sm:mb-3"
            >
                Merci ! Votre demande de {{ modeconfig }} a été envoyée.
            </h2>
            <p
                v-if="modeconfig === 'Devis'"
                class="text-xs sm:text-sm text-gray-600 mb-4 sm:mb-6 max-w-md"
            >
                Vous recevrez un e-mail avec le devis en PDF dans les plus brefs
                délais.
            </p>
            <!-- Récapitulatif -->
            <div
                class="bg-gray-50 border border-gray-200 rounded-xl p-3 sm:p-6 w-full max-w-2xl text-left mb-4 sm:mb-6"
            >
                <h3
                    class="text-sm sm:text-lg font-semibold text-gray-800 mb-3 sm:mb-4"
                >
                    Récapitulatif
                </h3>
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 text-xs sm:text-sm text-gray-700"
                >
                    <div>
                        <p>
                            <strong>Nom :</strong> {{ client.prenom }}
                            {{ client.nom }}
                        </p>
                        <p><strong>Téléphone :</strong> {{ client.tel }}</p>
                        <p v-if="client.email">
                            <strong>Email :</strong> {{ client.email }}
                        </p>
                    </div>
                    <div>
                        <p v-if="rdvDate && modeconfig !== 'Devis'">
                            <strong>Date :</strong> {{ rdvDate }}
                        </p>
                        <p v-if="selectedSlot">
                            <strong>Heure :</strong> {{ selectedSlot }}
                        </p>
                        <p v-if="selectedAddress && modeconfig !== 'Devis'">
                            <strong>Adresse :</strong> {{ selectedAddress }}
                        </p>
                    </div>
                    <div
                        v-if="
                            selectedAppointmentOption && modeconfig !== 'Devis'
                        "
                        class="sm:col-span-2"
                    >
                        <p>
                            <strong>Type de rendez-vous :</strong>
                            {{
                                appointmentOptions.find(
                                    (opt) =>
                                        opt.id === selectedAppointmentOption
                                )?.label
                            }}
                        </p>
                    </div>
                </div>
            </div>
            <!-- Boutons d'action -->
            <div
                class="flex flex-col sm:flex-row gap-2 sm:gap-3 w-full max-w-md"
            >
                <button
                    @click="goToAccueil"
                    class="flex-1 bg-[var(--primary)] text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg text-xs sm:text-sm font-semibold hover:[color-mix(in_srgb,var(--primary)_80%,black)] transition"
                >
                    Retour à l'accueil
                </button>
                <button
                    @click="goToAccueil"
                    class="flex-1 bg-gray-200 text-gray-700 px-4 sm:px-6 py-2 sm:py-3 rounded-lg text-xs sm:text-sm hover:bg-gray-300 transition"
                >
                    Faire une autre demande
                </button>
            </div>
        </div>
        <!-- Modal aide -->
        <div
            v-if="showModal"
            class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4"
        >
            <div
                class="bg-white rounded-xl shadow-lg max-w-md w-full mx-auto p-3 sm:p-6 relative"
            >
                <button
                    @click="showModal = false"
                    class="absolute top-2 sm:top-3 right-2 sm:right-3 text-gray-400 hover:text-black text-lg sm:text-xl"
                >
                    ×
                </button>
                <h3
                    class="text-sm sm:text-lg font-semibold mb-3 sm:mb-4 text-gray-800"
                >
                    Comment trouver votre modèle ?
                </h3>
                <!-- Section Android -->
                <div class="mb-3 sm:mb-4">
                    <h4
                        class="text-[var(--primary)] font-bold mb-2 flex items-center gap-2"
                    >
                        🤖 Android
                    </h4>
                    <ul class="text-gray-700 space-y-2 text-xs sm:text-sm">
                        <li class="flex items-start gap-2">
                            <span class="text-[var(--primary)] mt-1">•</span>
                            <span
                                >Ouvrez l'application
                                <strong>Paramètres</strong></span
                            >
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-[var(--primary)] mt-1">•</span>
                            <span
                                >Allez dans
                                <strong>À propos du téléphone</strong></span
                            >
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-[var(--primary)] mt-1">•</span>
                            <span
                                >Recherchez le
                                <strong>Nom de l'appareil</strong></span
                            >
                        </li>
                    </ul>
                </div>
                <!-- Section Apple -->
                <div class="mb-3 sm:mb-4">
                    <h4
                        class="text-gray-800 font-bold mb-2 flex items-center gap-2"
                    >
                         Apple
                    </h4>
                    <ul class="text-gray-700 space-y-2 text-xs sm:text-sm">
                        <li class="flex items-start gap-2">
                            <span class="text-gray-500 mt-1">•</span>
                            <span>Ouvrez <strong>Réglages</strong></span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-gray-500 mt-1">•</span>
                            <span
                                >Allez dans <strong>Général</strong> →
                                <strong>Informations</strong></span
                            >
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-gray-500 mt-1">•</span>
                            <span
                                >Repérez le <strong>Nom du modèle</strong></span
                            >
                        </li>
                    </ul>
                </div>
                <div class="mt-4 sm:mt-6 text-center">
                    <button
                        @click="showModal = false"
                        class="px-4 sm:px-6 py-1 sm:py-2 bg-[var(--primary)] text-white rounded-lg hover:[color-mix(in_srgb,var(--primary)_80%,black)] text-xs sm:text-sm font-medium"
                    >
                        J'ai compris 👍
                    </button>
                </div>
            </div>
        </div>
    </div>
    <footer v-if="step !== 4 && step !== 5">
        <div class="footer-container">
            <a
                href="https://modelitech.fr/"
                target="_blank"
                class="footer-link"
            >
                <div class="footer-logo">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="footer-icon"
                    >
                        <path d="m13 13.5 2-2.5-2-2.5"></path>
                        <path d="m21 21-4.3-4.3"></path>
                        <path d="M9 8.5 7 11l2 2.5"></path>
                        <circle cx="11" cy="11" r="8"></circle>
                    </svg>
                </div>
                <span class="footer-text">
                    <span>Réalisé par</span> <strong>Modelitech</strong>
                </span>
            </a>
        </div>
    </footer>

    <div>
        <div
            data-dialog-backdrop="modal-md"
            data-dialog-backdrop-close="true"
            :show="open"
            v-if="open"
            class="fixed inset-0 z-[999] grid h-screen w-screen place-items-center bg-black bg-opacity-60 backdrop-blur-sm transition-opacity duration-300"
        >
            <div
                data-dialog="modal-md"
                class="relative m-4 p-4 w-2/5 rounded-lg bg-white shadow-sm"
            >
                <div
                    class="flex shrink-0 items-center pb-4 text-xl font-medium text-slate-800"
                >
                    Its a simple modal.
                </div>
                <div
                    class="relative border-t border-slate-200 py-4 leading-normal text-slate-600 font-light"
                >
                    <fieldset class="space-y-6">
                         
                        <div class="grid sm:grid-cols-2 gap-6">
                            <template
                                v-for="product in products"
                                :key="product.id"
                            >
                                <label  
                                    :for="`product_${product.id}`"
                                    class="relative flex flex-col bg-white p-5 rounded-lg shadow-md cursor-pointer
                                     w-full  "
                                    @click="selectProduct(product)"
                                >
                                    <img :src="product.image" width="50px">
                                    <span
                                        class="font-semibold text-gray-500 leading-tight uppercase mb-3"
                                        >{{product.name}}</span
                                    >
                                    <span class="font-bold text-gray-900">
                                        <span class="text-4xl">{{ product.price }}</span>
                                        <span class="text-2xl uppercase"
                                            >€</span
                                        >
                                    </span>
                                    
                                    <input
                                        type="radio"
                                        name="plan"
                                        :id="`product_${product.id}`"
                                        :value="product.id"
                                        class="absolute h-0 w-0 appearance-none product-addit"
                                    />
                                    <span
                                        aria-hidden="true"
                                        class="hidden absolute inset-0 border-2 border-green-500 bg-green-200 bg-opacity-10 rounded-lg"
                                    >
                                        <span
                                            class="absolute top-4 right-4 h-6 w-6 inline-flex items-center justify-center rounded-full bg-green-200"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                                class="h-5 w-5 text-green-600"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        </span>
                                    </span>
                                </label>
                            </template>
                        </div>
                    </fieldset>

                     
                </div>
                <div
                    class="flex shrink-0 flex-wrap items-center pt-4 justify-end"
                >
                    <button
                        data-dialog-close="true"
                        class="rounded-md border border-transparent py-2 px-4 text-center text-sm transition-all text-slate-600 hover:bg-slate-100 focus:bg-slate-100 active:bg-slate-100 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                        type="button" @click="open = false; selectedProduct = null; nextStep()"
                    >
                        Non Merci
                    </button>
                    <button
                        data-dialog-close="true"
                         @click="open = false; nextStep()"
                        class="rounded-md bg-green-600 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-green-700 focus:shadow-none active:bg-green-700 hover:bg-green-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2"
                        type="button"
                    >
                        Ajouter
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";

export default {
    name: "Apercu",
    data() {
        return {
            boutiqueId: window.boutiqueId,
            modeconfig: null,
            step: 1,
            open: false,
            remiseTotal: 0,
            stepTitle: "📱 Quel matériel avez-vous à faire réparer ?",
            search: "",
            showModal: false,
            loadingDevice: null,
            loadingBrand: null,
            loadingModel: null,
            loadingRepairs: false,
            searchLoading: false,
            searchBrandLoading: false,
            debounceTimer: null,
            debounceBrandTimer: null,
            isSubmitting: false,
            selectedDevice: null,
            selectedDeviceId: null,
            selectedBrand: null,
            selectedBrandId: null,
            selectedModel: null,
            selectedSlot: null,
            searchQuery: "",
            searchBrandQuery: "",
            rdvDate: new Date().toISOString().split("T")[0],
            selectedRepairs: [],
            appointmentOptions: [],
            selectedAppointmentOption: null,
            selectedRepairId: null,
            selectedTypes: {},
            etatRachat: "bon",
            pieces: [],
            capacites: [],
            prixRachat: {
                bon: {},
                mauvais: {},
                piece: {},
            },
            dispoSlots: [],
            isBoutiqueOpen: true,
            client: {
                nom: "",
                prenom: "",
                tel: "",
                email: "",
                adresse: "",
                notes: "",
            },
            shopAddresses: [],
            remiseOnline: 0,
            selectedAddress: null,
            errorMessage: null,
            selectedProduct: null,
            repairs: [],
            devices: [],
            brands: [],
            products: [],
            models: [],
            errors: {
                devices: null,
                brands: null,
                models: null,
                pannes: null,
            },
            isAdmin: false,
        };
    },
    computed: {
        filteredBrands() {
            return this.searchBrandQuery
                ? this.brands.filter((b) =>
                      b.name
                          .toLowerCase()
                          .includes(this.searchBrandQuery.toLowerCase())
                  )
                : this.brands;
        },
        filteredModels() {
            return this.searchQuery
                ? this.models.filter((m) =>
                      m.name
                          .toLowerCase()
                          .includes(this.searchQuery.toLowerCase())
                  )
                : this.models;
        },
        subTotal() {
            var subtotal = this.selectedRepairs.reduce(
                (acc, curr) => acc + (curr.price || 0),
                0
            );
            
            return parseFloat(subtotal);
        },
        remiseQualirepar() {
            if (this.modeconfig == "Devis") return 0;
            return this.selectedRepairs.reduce(
                (acc, curr) =>
                    curr.is_qualirepar
                        ? parseFloat(curr.qualirepar_montant)
                        : 0,
                0
            );
        },
        applyQualirepar() {
            return (
                this.selectedRepairs.length > 1 &&
                this.selectedRepairs.every((item) => item.is_qualirepar === 1)
            );
        },
        applyComboRemise() {
            return (
                this.selectedRepairs.length > 1 &&
                this.selectedRepairs.every(
                    (item) => item?.remise === 0 && !item.hasPromo
                )
            );
        },
        comboDiscount() {
            return this.applyComboRemise
                ? Math.round(this.subTotal * 0.1 * 100) / 100
                : 0;
        },
        total() {
            if (this.modeconfig == "Devis") return 0;
            return (
                (Math.round((this.subTotal - this.comboDiscount) * 100) / 100) - this.remiseQualirepar - this.remiseTotal +
                    (this.selectedAppointmentOption?.price ?? 0) +parseFloat(this.selectedProduct?.price ?? 0)
            );
        },
        isFormValid() {
            console.log(
                this.client.nom,
                this.client.prenom,
                this.client.tel,
                this.rdvDate,
                this.selectedSlot,
                this.selectedAddress,
                this.selectedAppointmentOption?.id,
                this.isBoutiqueOpen,
                this.dispoSlots.length
            );
            if (this.modeconfig !== "Devis") {
                return (
                    this.client.nom &&
                    this.client.prenom &&
                    this.client.tel &&
                    this.rdvDate &&
                    this.selectedSlot &&
                    this.selectedAddress &&
                    this.selectedAppointmentOption?.id &&
                    this.isBoutiqueOpen &&
                    this.dispoSlots.length > 0
                );
            }
            return this.client.nom && this.client.prenom && this.client.tel;
        },
        hasNonZeroPrices() {
            return (
                Object.values(this.prixRachat.bon).some((price) => price > 0) ||
                Object.values(this.prixRachat.mauvais).some(
                    (price) => price > 0
                ) ||
                Object.values(this.prixRachat.piece).some((price) => price > 0)
            );
        },
    },
    watch: {
        rdvDate(newDate) {
            console.log(newDate);
            if (newDate && this.modeconfig !== "Devis") {
                this.getCreneauxBoutique(this.boutiqueId, newDate);
            } else {
                this.dispoSlots = [];
                this.selectedSlot = null;
                this.isBoutiqueOpen = true;
            }
        },
    },
    mounted() {
        this.setDynamicColors();
        Promise.all([
            this.fetchDevice(this.boutiqueId),
            this.setStepTitle(),
            this.fetchBoutiqueAdresse(this.boutiqueId),
        ]).catch((error) => {
            console.error("Erreur lors de l'initialisation:", error);
            this.errorMessage =
                "Erreur lors du chargement des données. Veuillez réessayer.";
        });
        this.getCreneauxBoutique(this.boutiqueId, this.rdvDate);
    },
    methods: {
        applyDiscount(price, percentage) {
            this.remiseTotal = (price * percentage).toFixed(2);
            return (price * percentage).toFixed(2);
        },
        hasPrice(panne) {
            if (this.modeconfig == "Devis") return true;
            if (panne?.types.length == 0) return false;

            return panne?.types
                .map((item) => item?.prix_initial > 0)
                .includes(true);
        },
        setDynamicColors() {
            const primary = window.primary_color || "#3b82f6";
            const secondary = window.secondary_color || "#8b5cf6";
            const root = document.documentElement;
            root.style.setProperty("--primary", primary);
            root.style.setProperty("--secondary", secondary);
        },
        getTypePrice(repair, type = null) {
            this.hasPrice(repair);

            if (type === null && repair.types.length > 0) {
                var newtypes = repair.types.filter(
                    (item) => item?.prix_initial > 0
                );
                console.log(newtypes);
                type = newtypes.length > 0 ? newtypes[0] : null;
            }

            if (type === null) {
                let price = 0;
                let originalPrice = 0;
                let hasPromo = false;
                return { price, originalPrice, hasPromo };
            }
            const initial = type.prix_initial ?? 0;
            const promo = type.prix_promo ?? 0;

            let price = initial;
            let originalPrice = initial;
            let hasPromo = false;
            if (promo !== null && promo > 0 && promo < initial) {
                price = promo;
                originalPrice = initial;
                hasPromo = true;
            }
            return { price, originalPrice, hasPromo };
        },

        async getCreneauxBoutique(boutiqueId, date) {
            try {
                this.errorMessage = null;
                this.selectedSlot = null;
                const response = await axios.get(
                    `/apercu/boutique/timeoff/${encodeURIComponent(
                        boutiqueId
                    )}`,
                    { params: { date } }
                );
                this.dispoSlots = response.data.available_times || [];
                this.isBoutiqueOpen = response.data.is_open !== false;
                if (!this.isBoutiqueOpen) {
                    this.errorMessage =
                        response.data.message ||
                        "La boutique est fermée ce jour.";
                } else if (this.dispoSlots.length === 0) {
                    this.errorMessage =
                        "Aucun créneau disponible pour cette date.";
                }
            } catch (error) {
                console.error(
                    "Erreur lors de la récupération des créneaux:",
                    error
                );
                this.errorMessage =
                    error.response?.data?.message ||
                    "Impossible de charger les créneaux disponibles. Veuillez réessayer.";
                this.dispoSlots = [];
                this.isBoutiqueOpen = true;
            }
        },
        async fetchBoutiqueAdresse(boutiqueId) {
            try {
                this.errorMessage = null;
                const response = await axios.get(
                    `/apercu/adresses/${encodeURIComponent(boutiqueId)}`
                );

                this.remiseOnline = response.data.remise_online;

                this.shopAddresses = Array.isArray(response.data.addresses)
                    ? response.data.addresses
                    : [];

                if (this.shopAddresses.length > 0 && !this.selectedAddress) {
                    this.selectedAddress = this.shopAddresses[0].address;
                }
                this.appointmentOptions = [
                    {
                        id: "typeRdv0",
                        label: "Réparation en magasin",
                        address:
                            response.data.reparation_magazin_description ?? "",
                        price: response.data.reparation_magazin_price ?? 0,
                        checked: !!response.data.reparation_magazin,
                        description:
                            response.data.reparation_magazin_description ?? "",
                    },
                    {
                        id: "typeRdv1",
                        label: "Réparation à domicile ou au travail",
                        address:
                            response.data.reparation_domicile_description ?? "",
                        price: response.data.reparation_domicile_price ?? 0,
                        checked: !!response.data.reparation_domicile,
                        description:
                            response.data.reparation_domicile_description ?? "",
                    },
                    {
                        id: "typeRdv2",
                        label: "Réparation par correspondance",
                        address:
                            response.data
                                .reparation_correspondance_description ?? "",
                        price:
                            response.data.reparation_correspondance_price ?? 0,
                        checked: !!response.data.reparation_correspondance,
                        description:
                            response.data
                                .reparation_correspondance_description ?? "",
                    },
                ].filter((option) => option.checked);
                if (
                    this.appointmentOptions.length > 0 &&
                    !this.selectedAppointmentOption
                ) {
                    this.selectedAppointmentOption = this.appointmentOptions[0];
                }
            } catch (error) {
                console.error(
                    "Erreur lors de la récupération des adresses:",
                    error
                );
                this.errorMessage =
                    "Impossible de charger les adresses ou options. Veuillez réessayer.";
                this.shopAddresses = [];
                this.appointmentOptions = [];
            }
        },
        async fetchDevice(boutiqueId) {
            try {
                this.errorMessage = null;
                const response = await axios.get(
                    `/apercu/materials/${encodeURIComponent(boutiqueId)}`
                );
                this.devices = response.data.matriels.map((device) => ({
                    id: device.id,
                    name: device.nom_materiel || "Smartphone",
                    icon: device.image,
                }));
                this.modeconfig = response.data.mode;
            } catch (error) {
                this.errors.devices =
                    "Erreur lors du chargement des appareils.";
                console.error("fetchDevice error:", error);
                this.errorMessage = "Erreur lors du chargement des appareils.";
            }
        },
        async fetchBrands(boutiqueId, materiel_id) {
            try {
                this.errorMessage = null;
                this.searchBrandLoading = true;
                const response = await axios.get(
                    `/apercu/brands/${encodeURIComponent(
                        boutiqueId
                    )}/${encodeURIComponent(materiel_id)}`
                );
                this.brands = response.data.map((brand) => ({
                    id: brand.id,
                    name: brand.nom_marques,
                    logo: brand.image,
                }));
            } catch (error) {
                this.errors.brands = "Erreur lors du chargement des marques.";
                console.error("fetchBrands error:", error);
                this.errorMessage = "Erreur lors du chargement des marques.";
            } finally {
                this.searchBrandLoading = false;
            }
        },
        async fetchProducts(boutiqueId, materiel_id) {
            try {
                this.errorMessage = null;
                this.searchBrandLoading = true;
                const response = await axios.get(
                    `/apercu/products/${encodeURIComponent(
                        boutiqueId
                    )}/${encodeURIComponent(materiel_id)}`
                );
                this.products = response.data.map((brand) => ({
                    id: brand.id,
                    name: brand.name,
                    description: brand.description,
                    price: brand.price,
                    image: "/storage/" + brand.image,
                }));
            } catch (error) {
                this.errors.brands = "Erreur lors du chargement des marques.";
                console.error("fetchBrands error:", error);
                this.errorMessage = "Erreur lors du chargement des marques.";
            } finally {
                this.searchBrandLoading = false;
            }
        },
        async fetchModels(boutiqueId, marque_id) {
            try {
                this.errorMessage = null;
                const response = await axios.get(
                    `/apercu/models/${encodeURIComponent(
                        boutiqueId
                    )}/${encodeURIComponent(marque_id)}`
                );
                this.models = response.data.map((model) => ({
                    id: model.id,
                    name: model.nom_modele,
                    code: "N/A",
                    image: model.image,
                }));
            } catch (error) {
                this.errors.models = "Erreur lors du chargement des modèles.";
                console.error("fetchModels error:", error);
                this.errorMessage = "Erreur lors du chargement des modèles.";
            }
        },
        async fetchPannes(boutiqueId, modele_id) {
            try {
                this.errorMessage = null;
                this.loadingRepairs = true;

                const response = await axios.get(
                    `/apercu/pannes/${encodeURIComponent(
                        boutiqueId
                    )}/${encodeURIComponent(modele_id)}`
                );
                //pannes
                let pannesData = Array.isArray(response.data.pannes)
                    ? response.data.pannes
                    : [];

                pannesData = pannesData.sort(
                    (a, b) => (a.priorite || 0) - (b.priorite || 0)
                );

                const groupedRepairs = {};

                // === MISE À JOUR DES DONNÉES ===
                this.repairs = pannesData;
                console.log(this.repairs);
                // --- RACHAT ---
                this.prixRachat = response.data.prixRachat || {
                    bon: {},
                    mauvais: {},
                    piece: {},
                };
                this.capacites = Array.isArray(response.data.capacites)
                    ? response.data.capacites
                    : [];

                this.capacites.forEach((capa) => {
                    this.prixRachat.bon[capa] ??= 0;
                    this.prixRachat.mauvais[capa] ??= 0;
                    this.prixRachat.piece[capa] ??= 0;
                });

                // Définir l'état par défaut
                if (Object.keys(this.prixRachat.bon).length > 0) {
                    this.etatRachat = "bon";
                } else if (Object.keys(this.prixRachat.mauvais).length > 0) {
                    this.etatRachat = "mauvais";
                } else {
                    this.etatRachat = "piece";
                }

                // --- PIÈCES (si besoin) ---
                this.pieces = Array.isArray(response.data.pieces)
                    ? response.data.pieces
                    : pannesData;
            } catch (error) {
                console.error("fetchPannes error:", error);
                this.errorMessage = "Erreur lors du chargement des pannes.";
                this.errors.pannes = "Erreur lors du chargement des pannes.";
            } finally {
                this.loadingRepairs = false;
            }
        },
        async selectDevice(device) {
            const isSameDevice = this.selectedDeviceId === device.id;
            if (isSameDevice) {
                this.step = 2;
                this.setStepTitle();
                return;
            }
            // Clear subsequent selections
            this.selectedBrandId = null;
            this.selectedModel = null;
            this.selectedRepairs = [];
            this.models = [];
            this.repairs = [];
            this.searchBrandQuery = "";
            this.loadingDevice = device.name;
            try {
                await this.fetchBrands(this.boutiqueId, device.id);
                this.selectedDevice = device.name;
                this.selectedDeviceId = device.id;
                this.step = 2;
                this.setStepTitle();
                await this.fetchProducts(this.boutiqueId, device.id);
            } catch (error) {
                console.error("Erreur lors de la sélection du device:", error);
            } finally {
                this.loadingDevice = null;
            }
        },
        async selectBrand(brand) {
            const isSameBrand = this.selectedBrandId === brand.id;
            if (isSameBrand) {
                this.step = 3;
                this.setStepTitle();
                return;
            }
            // Clear subsequent selections
            this.selectedModel = null;
            this.selectedRepairs = [];
            this.models = [];
            this.repairs = [];
            this.searchQuery = "";
            this.loadingBrand = brand.name;
            try {
                await this.fetchModels(this.boutiqueId, brand.id);
                this.selectedBrand = brand.name;
                this.selectedBrandId = brand.id;
                this.step = 3;
                this.setStepTitle();
            } catch (error) {
                console.error(
                    "Erreur lors de la sélection de la marque:",
                    error
                );
            } finally {
                this.loadingBrand = null;
            }
        },
        async selectModel(model) {
            const isSameModel =
                this.selectedModel && this.selectedModel.id === model.id;
            if (isSameModel) {
                this.loadingRepairs = false;
                this.step = 4;
                this.setStepTitle();
                return;
            }
            // Clear repairs for new model
            this.selectedRepairs = [];
            this.loadingModel = model.name;
            this.loadingRepairs = true;
            try {
                await this.fetchPannes(this.boutiqueId, model.id);
                this.selectedModel = model;
                this.step = 4;
                this.setStepTitle();
            } catch (error) {
                console.error("Erreur lors de la sélection du modèle:", error);
            } finally {
                this.loadingModel = null;
            }
        },
        toggleRepair(repair) {
            const index = this.selectedRepairs.findIndex(
                (r) => r.id === repair.id
            );
            if (index !== -1) {
                this.removeRepair(repair.id);
            } else {
                this.selectedRepairId =
                    this.selectedRepairId === repair.id ? null : repair.id;
            }
            this.setStepTitle();
        },
        selectRepairType(repair, type) {
            console.log("=== DÉBUT selectRepairType ===");
            console.log("Repair reçu :", repair);
            console.log("Type sélectionné :", type);
            const initial = type.prix_initial || 0;
            const promo = type.prix_promo || null;

            let price = initial;
            let originalPrice = false;
            let hasPromo = false;
            let unavailable = false; // Flag si prix = 0
            if (promo !== null && promo > 0 && promo < initial) {
                price = promo;
                originalPrice = initial;
                hasPromo = true;
                console.log("→ Promo appliquée !");
            } else {
                console.log("→ Ni promo ni remise appliquée.");
            }
            // Recherche par id ET type
            const index = this.selectedRepairs.findIndex(
                (r) => r.id === repair.id && r.type.id === type.id
            );
            console.log("Index trouvé dans selectedRepairs :", index);
            const repairEntry = {
                id: repair.id,
                name: repair.nom,
                remiseOnline: this.remiseOnline,
                type: type,
                price,
                originalPrice,
                hasPromo,
                //remise,
                is_qualirepar: type.is_qualirepar,
                qualirepar_montant: type.montant,
                description: repair.description,
                image: repair.image,
                unavailable,
            };
            if (index === -1) {
                console.log(
                    "→ Ajout d'une nouvelle réparation :",
                    repair.nom,
                    "Type :",
                    type
                );
                this.selectedRepairs.push(repairEntry);
            } else {
                console.log(
                    "→ Mise à jour de la réparation existante :",
                    repair.nom,
                    "Type :",
                    type
                );
                this.selectedRepairs[index] = repairEntry;
            }
            console.log(
                "État actuel de selectedRepairs :",
                JSON.parse(JSON.stringify(this.selectedRepairs))
            );
            console.log("=== FIN selectRepairType ===\n");
            this.selectedRepairId = null;
        },
        removeRepair(repairId) {
            this.selectedRepairs = this.selectedRepairs.filter(
                (repair) => repair.id !== repairId
            );
            delete this.selectedTypes[repairId];
        },
        getImg(image) {
            return `/storage/${image}`;
        },
        selectAddress(address) {
            this.selectedAddress = address;
        },
        selectAppointmentOption(optionId) {
            console.log(optionId);
            this.selectedAppointmentOption = optionId;
            //this.subTotal;
        },
        debouncedSearch() {
            if (this.debounceTimer) {
                clearTimeout(this.debounceTimer);
            }
            this.searchLoading = true;
            this.debounceTimer = setTimeout(() => {
                this.searchLoading = false;
            }, 300);
        },
        debouncedBrandSearch() {
            if (this.debounceBrandTimer) {
                clearTimeout(this.debounceBrandTimer);
            }
            this.searchBrandLoading = true;
            this.debounceBrandTimer = setTimeout(() => {
                this.searchBrandLoading = false;
            }, 300);
        },
        async sendDataToBackend() {
            if (!this.isFormValid) {
                this.errorMessage =
                    "Veuillez remplir tous les champs obligatoires.";
                return;
            }
            this.isSubmitting = true;
            this.errorMessage = null;
            const selectedOption = this.appointmentOptions.find(
                (opt) => opt.id === this.selectedAppointmentOption?.id
            );
            const data = {
                boutiqueId: this.boutiqueId,
                mode: this.modeconfig,
                device: this.selectedDevice,
                brand: this.selectedBrand,
                model: this.selectedModel?.name || null,
                model_id: this.selectedModel?.id || null,
                selectedProduct: this.selectedProduct || null,
                repairs: this.selectedRepairs.map((repair) => ({
                    id: repair.id,
                    name: repair.name,
                    image: repair.image,
                    remiseOnline: repair.remiseOnline,
                    type: repair.type,
                    price: repair.price,
                })),
                client: {
                    nom: this.client.nom,
                    prenom: this.client.prenom,
                    tel: this.client.tel,
                    email: this.client.email,
                    adresse: this.client.adresse,
                    notes: this.client.notes,
                },
                appointment:
                    this.modeconfig !== "Devis"
                        ? {
                              date: this.rdvDate,
                              time: this.selectedSlot,
                              slot: this.selectedSlot,
                              address: this.selectedAddress,
                              option: {
                                  id: selectedOption?.id || null,
                                  label: selectedOption?.label || null,
                                  price: selectedOption?.price || 0,
                              },
                          }
                        : null,
                totalPrice: this.total === null ? 0 : this.total,
                etatRachat:
                    this.modeconfig === "Rachat" ? this.etatRachat : null,
                capacites: this.modeconfig === "Rachat" ? this.capacites : [],
                prixRachat:
                    this.modeconfig === "Rachat" ? this.prixRachat : null,
            };
            try {
                const response = await axios.post(
                    `/apercu/submit/${encodeURIComponent(this.boutiqueId)}`,
                    data
                );
                if (response.data.success) {
                    this.step = 6;
                    this.setStepTitle();
                } else {
                    throw new Error(
                        response.data.message ||
                            "Erreur lors de l'envoi des données."
                    );
                }
            } catch (error) {
                console.error("Erreur lors de l'envoi des données:", error);
                this.errorMessage =
                    "Erreur lors de l'envoi de votre demande. Veuillez réessayer.";
            } finally {
                this.isSubmitting = false;
            }
        },
        goToAccueil() {
            this.step = 1;
            this.setStepTitle();
            this.client = {
                nom: "",
                prenom: "",
                tel: "",
                email: "",
                adresse: "",
                notes: "",
            };
            this.selectedDevice = null;
            this.selectedDeviceId = null;
            this.selectedBrand = null;
            this.selectedBrandId = null;
            this.selectedModel = null;
            this.selectedRepairs = [];
            this.rdvDate = new Date().toISOString().split("T")[0];
            this.selectedSlot = null;
            this.selectedRepairId = null;
            this.selectedTypes = {};
            this.selectedAddress = null;
            this.selectedAppointmentOption = null;
            this.dispoSlots = [];
            this.isBoutiqueOpen = true;
            this.searchQuery = "";
            this.searchBrandQuery = "";
            this.searchLoading = false;
            this.searchBrandLoading = false;
            this.loadingRepairs = false;
            this.isSubmitting = false;
        },
        nextStep() {
            this.step++;
            this.setStepTitle();
        },
        selectProduct(product) {
            console.log("selectProduct");
            console.log(product);
            this.selectedProduct = product;
        },
        showPrducts() {
            console.log("showPrducts");
            if(this.products.length == 0){
                this.nextStep();
                return true;
            }

            this.open = true;
        },
        handlePreviousStep() {
            if (this.step > 1) {
                this.step--;
                this.setStepTitle();
                if (this.step === 3) {
                    this.searchQuery = "";
                    this.searchLoading = false;
                }
                if (this.step === 2) {
                    this.searchBrandQuery = "";
                    this.searchBrandLoading = false;
                }
                if (this.step === 4) {
                    this.loadingRepairs = false;
                }
            }
        },
        setStepTitle() {
            const titles = {
                1: "Quel matériel souhaitez-vous faire réparer ?",
                2: "Quelle est la marque de votre appareil ?",
                3: "Quel modèle souhaitez-vous faire réparer ?",
                4: "Sélectionnez les pannes à réparer.",
                5: "Veuillez saisir vos coordonnées.",
                6: "Confirmation de votre demande",
            };
            this.stepTitle = titles[this.step] || "Étape inconnue";
        },
    },
};
</script>
<style scoped>
.product-addit:checked + span {
  display: block;
}
footer {
    position: fixed;
    bottom: 0;
    width: 100%;
    padding: 12px 20px;
    background: transparent;
    z-index: 2;
}

.footer-container {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 12px;
}

.footer-link {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    color: white;
    font-size: 16px;
    background-color: var(--primary);
    padding: 6px 14px;
    border-radius: 30px;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 10px 40px -10px,
        rgba(0, 0, 0, 0.3) 0px 20px 30px -15px;
    transition: background 0.3s ease, transform 0.3s ease;
}

.footer-link:hover {
    background-color: color-mix(in srgb, var(--primary) 80%, white);
    transform: translateY(-2px);
}

.footer-icon {
    width: 28px;
    height: 28px;
    stroke: white;
}

.footer-text span {
    font-weight: 400;
    font-size: 13px;
    opacity: 0.8;
}

.footer-text strong {
    font-weight: 600;
    font-size: 14px;
    color: #fff;
}

/* Responsive */
@media (max-width: 640px) {
    .footer-link {
        font-size: 14px;
        padding: 5px 10px;
    }
    .footer-icon {
        width: 22px;
        height: 22px;
    }
}
/* styles.css */
.scrollbar-thin {
    scrollbar-width: thin;
    scrollbar-color: #9ca3af #f3f4f6;
}

.scrollbar-thin::-webkit-scrollbar {
    width: 8px;
}

.scrollbar-thin::-webkit-scrollbar-track {
    background: #f3f4f6;
    border-radius: 4px;
}

.scrollbar-thin::-webkit-scrollbar-thumb {
    background: #9ca3af;
    border-radius: 4px;
}

.scrollbar-thin::-webkit-scrollbar-thumb:hover {
    background: #6b7280;
}

/* Assurer que le conteneur principal ne soit pas masqué par le footer */
body {
    padding-bottom: 80px; /* Ajustez selon la hauteur de votre footer */
}
</style>
