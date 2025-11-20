<template>
  <div class="step-card">
    <div v-if="step === 1">
      <Step1
        :parts="parts"
        :remiseOnline="remiseOnline"
        :shop-addresses="shopAddresses"
        :appointment-options="appointmentOptions"
        :locked-mode="lockedMode"
        :is-saving-step1="isSavingStep1"
        @update:parts="$emit('update:parts', $event)"
        @update:remiseOnline="$emit('update:remiseOnline', $event)"
        @update:shopAddresses="$emit('update:shopAddresses', $event)"
        @update:appointmentOptions="$emit('update:appointmentOptions', $event)"
        @update:step="$emit('update:step', $event)"
      />
    </div>
    <div v-else-if="step === 2">
      <Step2
        :locked-mode="lockedMode"
        :remiseOnline="remiseOnline"
        :materials="materials"
        :selected-material="selectedMaterial"
        :brand-list="brandList"
        :selected-brand="selectedBrand"
        :model-list="modelList"
        :filtered-model-list="filteredModelList"
        :model-search="modelSearch"
        :selected-models="selectedModels"
        :price-map="priceMap"
        :loading="loading"
        @update:step="$emit('update:step', $event)"
        @update:selectedMaterial="$emit('update:selectedMaterial', $event)"
        @update:selectedBrand="$emit('update:selectedBrand', $event)"
        @update:modelSearch="$emit('update:modelSearch', $event)"
        @update:selectedModels="$emit('update:selectedModels', $event)"
        @update:priceMap="$emit('update:priceMap', $event)"
        @open-price-modal="$emit('open-price-modal', $event)"
      />
    </div>
    <div v-else-if="step === 3 && lockedMode === 'Devis'">
      <Step3Devis
        :parts="parts"
        :remiseOnline="remiseOnline"
        :is-loading="isLoading"
        :selected-material="selectedMaterial"
        :selected-brands="selectedBrands"
        :selected-brand="selectedBrand"
        :selected-models="selectedModels"
        :price-map="priceMap"
        :brand-list="brandList"
        :is-submitting="isSubmitting"
        @update:step="$emit('update:step', $event)"
        @open-configured-models-modal="$emit('open-configured-models-modal')"
        @submit-configuration="$emit('submit-configuration')"
        @update:selected-brands="$emit('update:selectedBrands', $event)"
      />
    </div>
    <div v-else-if="step === 3 && lockedMode === 'Rendez-vous'">
      <Step3Rdv
        :appointment-options="appointmentOptions"
        :remiseOnline="remiseOnline"
        :appointment-type="appointmentType"
        :appointment-types="appointmentTypes"
        :selected-material="selectedMaterial"
        :selected-brands="selectedBrands"
        :selected-brand="selectedBrand"
        :selected-models="selectedModels"
        :price-map="priceMap"
        @update:step="$emit('update:step', $event)"
        @update:appointmentType="$emit('update:appointmentType', $event)"
        @open-configured-models-modal="$emit('open-configured-models-modal')"
        @submit-configuration="$emit('submit-configuration')"
      />
    </div>
    <!-- Example button that might trigger go-to-step2 -->
    <div v-if="step === 1" class="mt-4 text-center">
      <button class="btn btn-primary" @click="goToStep2">Suivant</button>
    </div>
  </div>
</template>

<script>
import Step1 from "./Step1.vue";
import Step2 from "./Step2.vue";
import Step3Devis from "./Step3Devis.vue";
import Step3Rdv from "./Step3Rdv.vue";

export default {
  components: {
    Step1,
    Step2,
    Step3Devis,
    Step3Rdv,
  },
  props: {
    step: {
      type: Number,
      default: 1,
    },
    lockedMode: {
      type: String,
      default: null,
    },
    parts: {
      type: Array,
      default: () => [],
    },
    shopAddresses: {
      type: Array,
      default: () => [],
    },
    appointmentOptions: {
      type: Array,
      default: () => [],
    },
    selectedMaterial: {
      type: [String, Number, null],
      default: null,
    },
    remiseOnline: {
      type: Number,
      default: 0,
    },
    selectedBrands: {
      type: Array,
      default: () => [],
    },
    selectedBrand: {
      type: [String, Number, null],
      default: null,
    },
    selectedModels: {
      type: Array,
      default: () => [],
    },
    priceMap: {
      type: Object,
      default: () => ({}),
    },
    materials: {
      type: Array,
      default: () => [],
    },
    brandList: {
      type: Array,
      default: () => [],
    },
    modelList: {
      type: Array,
      default: () => [],
    },
    filteredModelList: {
      type: Array,
      default: () => [],
    },
    modelSearch: {
      type: String,
      default: "",
    },
    loading: {
      type: Object,
      default: () => ({}),
    },
    isSavingStep1: {
      type: Boolean,
      default: false,
    },
    appointmentType: {
      type: [String, null],
      default: null,
    },
    appointmentTypes: {
      type: Array,
      default: () => [],
    },
    isLoading: { type: Boolean, default: false },
  }, 
  emits: [
    "update:step",
    "update:parts",
    "update:remiseOnline",
    "update:shopAddresses",
    "update:appointmentOptions",
    "update:selectedMaterial", 
    "update:selectedBrands",
    "update:selectedBrand",
    "update:selectedModels",
    "update:priceMap",
    "update:modelSearch",
    "update:appointmentType",
    "open-price-modal",
    "open-configured-models-modal",
    "submit-configuration",
    "go-to-step2",
  ],
  methods: {
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
    goToStep2() {
      if(!this.validStep1()){
        window.toastr.error('Vous devez remplir toutes les champs', 'Erreur', {
          closeOnHover: false, // Example option: prevent closing on hover
        });
        return false;

      }
        
        
      this.$emit("go-to-step2");
      this.$emit("update:step", 2);
    },
  },
};
</script>

<style scoped>
.step-card {
  background: white;
  border-radius: 16px;
  padding: 2rem;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}
</style>
