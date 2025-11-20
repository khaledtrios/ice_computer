<template>
    <section>
         
        <h6 class="text-center mb-4">
            <span class="badge bg-primary me-2">0</span>
            Remise en ligne
        </h6>

        <div class="mb-4">
             
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-10 mb-3 mb-md-0">
                            <label
                                for="part-type-remise"
                                class="form-label"
                                >Remise en ligne</label
                            >
                            <input
                                :value="remiseOnline"
                                id="part-type-remise"
                                type="number"
                                class="form-control"
                                placeholder="Remise en ligne" 
                                @input="emitRemise"
                            /> 
                        </div>
                        <div class="col-md-2 text-center">
                             
                        </div>
                    </div>
                </div>
            
 
        </div>

        <!-- === PARTIE 1 : Types de pièces === -->
        <h6 class="text-center mb-4">
            <span class="badge bg-primary me-2">1</span>
            Ajoutez les types de pièces que vous utiliserez pour les
            réparations.
        </h6>

        <div class="mb-4">
            <div
                v-for="(part, index) in parts"
                :key="'part-' + index"
                class="card mb-3 border-light shadow-sm"
            >
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-10 mb-3 mb-md-0">
                            <label
                                :for="'part-type-' + part.id"
                                class="form-label"
                                >Type de pièce utilisée</label
                            >
                            <input
                                v-model="part.name"
                                :id="'part-type-' + part.id"
                                type="text"
                                class="form-control"
                                placeholder="Original, Compatible, Reconditionnée, Adaptables"
                                :class="{ 'is-invalid': !part.name?.trim() }"
                                @input="emitParts"
                            />
                            <div
                                v-if="!part.name?.trim()"
                                class="invalid-feedback"
                            >
                                Le type de pièce est obligatoire.
                            </div>

                            <div class="d-flex justify-content-between  mt-2">
                                <div class="form-check me-3 mt-2">
                                    <input
                                        v-model="part.is_qualirepar"
                                        :id="`is_qualirepar-${part.id}`"
                                        type="checkbox"
                                        class="form-check-input rounded-4"
                                        style="margin-top: 0.3rem"
                                        :checked="(part.is_qualirepar)?true:false"
                                    />
                                    <label
                                        :for="`is_qualirepar-${part.id}`"
                                        class="form-check-label"
                                    >
                                        Eligible Qualirépar
                                    </label>
                                </div>
                                <div v-if="part.is_qualirepar">
                                    <label
                                        :for="'part-montant-' + part.id"
                                        class="form-label"
                                        >Montant de remboursement</label
                                    >
                                    <input
                                        v-model="part.montant" 
                                        :id="'part-montant-' + part.id"
                                        type="text"
                                        class="form-control"
                                        placeholder="" 
                                        @input="emitParts"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 text-center">
                            <button
                                class="btn btn-danger btn-sm mt-3 mt-md-0"
                                @click="deletePart(index)"
                                :disabled="parts.length === 1"
                            >
                                Supprimer
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <button class="btn btn-outline-primary w-100 mb-4" @click="addPart">
                <i class="bi bi-plus-lg me-2"></i>Ajouter une pièce
            </button>
        </div>

        <!-- === PARTIE 2 : Adresses boutiques (Rendez-vous) === -->
        <div class="mb-4" v-if="lockedMode === 'Rendez-vous'">
            <h6 class="mb-3 text-center">
                <span class="badge bg-primary me-2">2</span>
                Renseignez toutes vos adresses si vous avez plusieurs points de
                vente.
            </h6>

            <div
                v-for="(shop, index) in shopAddresses"
                :key="'shop-' + index"
                class="card mb-3 border-light shadow-sm"
            >
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-10 mb-3 mb-md-0">
                            <label
                                :for="'shop-address-' + index"
                                class="form-label"
                                >Adresse de la boutique</label
                            >
                            <input
                                v-model="shop.address"
                                :id="'shop-address-' + index"
                                type="text"
                                class="form-control"
                                placeholder="Entrez l'adresse de la boutique"
                                :class="{
                                    'is-invalid':
                                        !shop.address?.trim() && inStoreChecked,
                                }"
                                @input="emitShopAddresses"
                            />
                            <div
                                v-if="!shop.address?.trim() && inStoreChecked"
                                class="invalid-feedback"
                            >
                                L'adresse de la boutique est obligatoire si la
                                réparation en magasin est sélectionnée.
                            </div>

                            <div>
                                <div class="form-check me-3 mt-2">
                                    <input
                                        v-model="shop.is_qualirepar"
                                        :id="`adress-${index}`"
                                        :checked="shop.is_qualirepar"
                                        type="checkbox"
                                        class="form-check-input rounded-4"
                                        style="margin-top: 0.3rem"
                                    />
                                    <label
                                        :for="`adress-${index}`"
                                        class="form-check-label"
                                    >
                                        Eligible Qualirépar
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 text-center">
                            <button
                                class="btn btn-danger btn-sm mt-3 mt-md-0"
                                @click="deleteShopAddress(index)"
                                :disabled="shopAddresses.length === 1"
                            >
                                Supprimer
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <button
                class="btn btn-outline-primary w-100 mb-4"
                @click="addShopAddress"
            >
                <i class="bi bi-plus-lg me-2"></i>Ajouter une adresse de
                boutique
            </button>
        </div>

        <!-- === PARTIE 3 : Options de rendez-vous === -->
        <div class="mb-4" v-if="lockedMode === 'Rendez-vous'">
            <h6 class="mb-3 text-center">
                <span class="badge bg-primary me-2">3</span>
                Options de rendez-vous
            </h6>

            <div class="row">
                <div class="col-md-12">
                    <div
                        v-for="(option, index) in appointmentOptions"
                        :key="option.id"
                        class="card mb-2 border-light shadow-sm"
                    >
                        <div class="card-body d-flex align-items-center">
                            <div class="form-check me-3">
                                <input
                                    v-model="option.checked"
                                    :id="`option-${option.id}`"
                                    type="checkbox"
                                    class="form-check-input rounded-4"
                                    style="margin-top: 0.3rem"
                                    @change="
                                        handleAppointmentToggle(
                                            option.id,
                                            $event.target.checked
                                        )
                                    "
                                />
                                <label
                                    :for="`option-${option.id}`"
                                    class="form-check-label"
                                >
                                    {{ option.label }}
                                </label>
                            </div>

                            <div class="flex-grow-1">
                                <input
                                    v-model="option.address"
                                    type="text"
                                    class="form-control mb-2"
                                    placeholder="Adresse pour ce type de rendez-vous"
                                    :disabled="!option.checked"
                                    :class="{
                                        'is-invalid':
                                            option.checked &&
                                            !option.address?.trim(),
                                    }"
                                    @input="emitAppointmentOptions"
                                />
                                <div
                                    v-if="
                                        option.checked &&
                                        !option.address?.trim()
                                    "
                                    class="invalid-feedback"
                                >
                                    L'adresse est obligatoire pour ce type de
                                    rendez-vous.
                                </div>

                                <input
                                    v-if="index > 0"
                                    v-model.number="option.price"
                                    type="number"
                                    class="form-control"
                                    placeholder="€"
                                    min="0"
                                    :disabled="!option.checked"
                                    :class="{
                                        'is-invalid':
                                            option.checked &&
                                            (option.price === null ||
                                                option.price < 0),
                                    }"
                                    @input="emitAppointmentOptions"
                                />
                                <div
                                    v-if="
                                        option.checked &&
                                        (option.price === null ||
                                            option.price < 0)
                                    "
                                    class="invalid-feedback"
                                >
                                    Le prix doit être supérieur ou égal à 0.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bouton Suivant (décommenter quand prêt) -->
        <!--
    <div class="text-center mt-4">
      <button
        class="btn btn-primary px-4"
        :disabled="!validStep1 || isSavingStep1"
        @click="$emit('go-to-step2')"
      >
        <span
          v-if="isSavingStep1"
          class="spinner-border spinner-border-sm me-2"
          role="status"
        ></span>
        <i v-else class="bi bi-check-lg me-2"></i>
        {{ isSavingStep1 ? "Enregistrement..." : "Suivant" }}
      </button>
    </div>
    --></section>
</template>

<script>
export default {
    props: {
        parts: { type: Array, required: true },
        shopAddresses: { type: Array, required: true },
        appointmentOptions: { type: Array, required: true },
        lockedMode: { type: String, required: true },
        remiseOnline: { type: Number, required: true },
        isSavingStep1: { type: Boolean, default: false },
    },
    emits: [
        "update:parts",
        "update:remiseOnline",
        "update:shopAddresses",
        "update:appointmentOptions",
        "go-to-step2",
    ],
    data(){
        return{
            remiseOnlineNew: this.remiseOnline
        }
    },
    computed: {
        inStoreChecked() {
            return (
                this.appointmentOptions.find((opt) => opt.id === "typeRdv0")
                    ?.checked || false
            );
        },
        validStep1() {
            // 1. Tous les types de pièces remplis
            if (!this.parts.every((part) => part.name?.trim())) return false;

            // Si pas en mode RDV → OK
            if (this.lockedMode !== "Rendez-vous") return true;

            // 2. Si RDV en magasin coché → toutes les adresses boutiques obligatoires
            if (
                this.inStoreChecked &&
                !this.shopAddresses.every((shop) => shop.address?.trim())
            ) {
                return false;
            }

            // 3. Pour chaque option RDV cochée → adresse + prix valides
            return this.appointmentOptions.every((opt) => {
                if (!opt.checked) return true;
                return opt.address?.trim() && opt.price >= 0;
            });
        },
    },
    methods: {
        handleAppointmentToggle(optionId, checked) {
            const option = this.appointmentOptions.find(
                (opt) => opt.id === optionId
            );
            if (option && !checked) {
                option.price = 0; // Set price to 0 if toggle is unchecked
            }
            // Enregistrer l'état du toggle via émission
            this.emitAppointmentOptions();
        },
        // === Émission avec clone profond pour forcer la réactivité ===
        emitRemise(event) {
            this.$emit(
                "update:remiseOnline",
                event.target.value
            );
        },
        emitParts() {
            this.$emit(
                "update:parts",
                this.parts.map((p) => ({ ...p }))
            );
        },
        emitShopAddresses() {
            this.$emit(
                "update:shopAddresses",
                this.shopAddresses.map((s) => ({ ...s }))
            );
        },
        emitAppointmentOptions() {
            this.$emit(
                "update:appointmentOptions",
                this.appointmentOptions.map((o) => ({ ...o }))
            );
        },

        // === Gestion des ajouts/suppressions ===
        addPart() {
            this.$emit("update:parts", [...this.parts, { name: "" , is_qualirepar: 0, montant:0}]);
        },
        deletePart(index) {
            if (this.parts.length > 1) {
                const newParts = this.parts.filter((_, i) => i !== index);
                this.$emit("update:parts", newParts);
            }
        },
        addShopAddress() {
            this.$emit("update:shopAddresses", [
                ...this.shopAddresses,
                { address: "" },
            ]);
        },
        deleteShopAddress(index) {
            if (this.shopAddresses.length > 1) {
                const newAddresses = this.shopAddresses.filter(
                    (_, i) => i !== index
                );
                this.$emit("update:shopAddresses", newAddresses);
            }
        },
    },
};
</script>
