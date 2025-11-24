<template>
  <div class="container configuration-container py-1">
    <ModeSelection
      v-if="!hasExistingConfiguration && !lockedMode"
      :selectedMode="selectedMode"
      @update:selectedMode="selectedMode = $event"
      @show-confirmation-modal="showConfirmationModal"
    />
    <div
      v-if="hasExistingConfiguration && !configurationSubmitted"
      class="alert alert-info text-center mb-4"
    >
      <i class="bi bi-info-circle me-2"></i>
      Le mode <strong>{{ existingMode || "inconnu" }}</strong> est déjà configuré. Pour
      modifier cette option, veuillez contacter le support Model Tech.
    </div>
    <StepCard
      v-if="lockedMode"
      :step="step"
      :is-loading="isLoading"
      :lockedMode="lockedMode"
      :parts="parts"
      :remiseOnline="remiseOnline"
      :shopAddresses="shopAddresses"
      :appointmentOptions="appointmentOptions"
      :selectedMaterial="selectedMaterial"
      :selectedBrands="selectedBrands"
      :selectedBrand="selectedBrand"
      :selectedModels="selectedModels"
      :priceMap="priceMap"
      :materials="materials"
      :brandList="brandList"
      :modelList="modelList"
      :filteredModelList="filteredModelList"
      :modelSearch="modelSearch"
      :loading="loading"
      :isSavingStep1="isSavingStep1"
      :appointmentType="appointmentType"
      :appointmentTypes="appointmentTypes"
      @update:step="step = $event"
      @update:parts="parts = $event"
      @update:remiseOnline="remiseOnline = $event"
      @update:shopAddresses="shopAddresses = $event"
      @update:appointmentOptions="appointmentOptions = $event"
      @update:selectedMaterial="selectMaterial($event)"
      @update:selectedBrands="selectedBrands = $event"
      @update:selectedBrand="updateBrand($event)"
      @update:selectedModels="selectedModels = $event"
      @update:priceMap="priceMap = $event"
      @update:modelSearch="modelSearch = $event"
      @update:appointmentType="appointmentType = $event"
      @open-price-modal="openPriceModal"
      @open-configured-models-modal="openConfiguredModelsModal"
      @submit-configuration="submitConfiguration"
      @go-to-step2="goToStep2"
    />
    <ModeConfirmationModal
      :selectedMode="selectedMode"
      :hasExistingConfiguration="hasExistingConfiguration"
      :existingMode="existingMode"
      @confirm-mode="confirmMode"
      @reset-mode="resetMode"
    />
    <ConfigResultModal
      :configurationSubmitted="configurationSubmitted"
      :lockedMode="lockedMode"
      :parts="parts"
      :remiseOnline="remiseOnline"
      :selectedMaterial="selectedMaterial"
      :selectedBrands="selectedBrands"
      :selectedBrand="selectedBrand"
      :selectedModels="selectedModels"
      :priceMap="priceMap"
      :appointmentType="appointmentType"
      :appointmentTypes="appointmentTypes"
    />
    <PriceModal
      :modalModel="modalModel"
      :pannes="pannes"
      :prixParCapacite="prixParCapacite"
      :capacities="capacities"
      :showPriceTable="showPriceTable"
      :lockedMode="lockedMode"
      :errors="errors"
      @update:pannes="pannes = $event"
      @update:prixParCapacite="prixParCapacite = $event"
      @update:showPriceTable="showPriceTable = $event"
      @update-pannes="updatePannes"
    />
    <ConfiguredModelsModal
      :selectedModels="selectedModels"
      :priceMap="priceMap"
      :pannes="pannes"
      @open-price-modal="openPriceModal"
      @confirm-reset-configuration="confirmResetConfiguration"
    />
  </div>
</template>

<script>
import axios from "axios";
import ModeSelection from "./configuration/ModeSelection.vue";
import StepCard from "./configuration/StepCard.vue";
import ModeConfirmationModal from "./configuration/modals/ModeConfirmationModal.vue";
import ConfigResultModal from "./configuration/modals/ConfigResultModal.vue";
import PriceModal from "./configuration/modals/PriceModal.vue";
import ConfiguredModelsModal from "./configuration/modals/ConfiguredModelsModal.vue";

export default {
  components: {
    ModeSelection,
    StepCard,
    ModeConfirmationModal,
    ConfigResultModal,
    PriceModal,
    ConfiguredModelsModal,
  },
  data() {
    const defaultPrixParCapacite = {
      1: { 16: 0, 32: 0, 64: 0, 128: 0, 256: 0 },
      2: { 16: 0, 32: 0, 64: 0, 128: 0, 256: 0 },
      3: { 16: 0, 32: 0, 64: 0, 128: 0, 256: 0 },
    };
    return {
      isLoading: false,
      isSavingStep1: false,
      shopAddresses: [{ address: "" }],
      appointmentOptions: [
        {
          id: "typeRdv0",
          label: "",
          address: "Réparation en magasin (€)",
          price: 0,
          checked: true,
        },
        {
          id: "typeRdv1",
          label: "",
          address: "Réparation à domicile ou au travail (€)",
          price: 0,
          checked: true,
        },
      ],
      selectedMode: "Devis",
      confirmedMode: false,
      lockedMode: null,
      step: 1,
      parts: [{ type: "" }],//remiseOnline
      remiseOnline: 0,
      appointmentType: null,
      showPriceTable: false,
      selectedMaterial: null,
      selectedBrands: [],
      selectedBrand: null,
      selectedModels: [],
      priceMap: {},
      configurationSubmitted: false,
      modalModel: null,
      materials: [],
      pannes: [],
      brandsDict: {},
      modelsDict: {},
      appointmentTypes: [],
      loading: {
        materials: false,
        brands: false,
        models: false,
        select: false,
      },
      errors: {
        materials: null,
        brands: null,
        models: null,
        appointmentTypes: null,
        step1: null,
        submit: null,
      },
      hasExistingConfiguration: false,
      existingMode: null,
      selectedAddress: null,
      prixParCapacite: defaultPrixParCapacite,
      capacities: [16, 32, 64, 128, 256],
      modelSearch: "",
    };
  },
  computed: {
    brandList() {
      if (!this.selectedMaterial) return [];
      const brands = this.brandsDict[this.selectedMaterial];
      return Array.isArray(brands) ? brands : [];
    },
    modelList() {
      return this.modelsDict[this.selectedBrand] || [];
    },
    filteredModelList() {
      let models = this.modelList;
      if (this.modelSearch) {
        models = models.filter((m) =>
          m.nom_modele.toLowerCase().includes(this.modelSearch.toLowerCase())
        );
      }
      return models;
    },
  },
  mounted() {
    Promise.all([
      this.fetchMaterials(),
      //this.fetchAppointmentTypes(),
      this.checkExistingConfiguration(),
      this.fetchParts(),
    ]).then(() => {
      console.log("mounted with selectedMode ", this.selectedMode);
    });
  },
  methods: {
    getDefaultPrixParCapacite() {
      return {
        1: { 16: 0, 32: 0, 64: 0, 128: 0, 256: 0 },
        2: { 16: 0, 32: 0, 64: 0, 128: 0, 256: 0 },
        3: { 16: 0, 32: 0, 64: 0, 128: 0, 256: 0 },
      };
    },
    async fetchParts() {
      try {
        const response = await axios.get("/configuration/existing");
        const typesParPanne = response.data.types_par_panne;
        this.parts =
          Array.isArray(typesParPanne) && typesParPanne.length > 0
            ? typesParPanne
            : [{ type: "" }];
            console.log(this.parts);
            
        this.remiseOnline = parseFloat(response.data.remise_online)
        console.log(this.remiseOnline)
        this.shopAddresses =
          Array.isArray(response.data.shop_addresses) &&
          response.data.shop_addresses.length > 0
            ? response.data.shop_addresses
            : [{ address: "" }];

        if (this.shopAddresses.length > 0 && !this.selectedAddress) {
          this.selectedAddress = this.shopAddresses[0].address;
        }

        this.appointmentOptions = [
          {
            id: "typeRdv0",
            label: "",
            address:
              response.data.reparation_magazin_description ?? "Réparation en magasin",
            price: response.data.reparation_magazin_price ?? 0,
            checked: !!response.data.reparation_magazin,
            description: response.data.reparation_magazin_description ?? "",
          },
          {
            id: "typeRdv1",
            label: "",
            address:
              response.data.reparation_domicile_description ??
              "Réparation à domicile ou au travail",
            price: response.data.reparation_domicile_price ?? 0,
            checked: !!response.data.reparation_domicile,
            description: response.data.reparation_domicile_description ?? "",
          },
        ].filter((option) => option.checked !== null);
      } catch (error) {
        console.error("Erreur lors du chargement des pièces:", error);
        this.errors.step1 = "Erreur lors du chargement des configurations.";
        this.parts = [{ type: "" }];
        this.remiseOnline = 0;
        this.shopAddresses = [{ address: "" }];
        this.appointmentOptions = [
          {
            id: "typeRdv0",
            label: "",
            address: "Réparation en magasin",
            price: 0,
            checked: false,
            description: "",
          },
          {
            id: "typeRdv1",
            label: "",
            address: "Réparation à domicile ou au travail",
            price: 0,
            checked: false,
            description: "",
          },
        ];
      }
    },
    async checkExistingConfiguration() {
      try {
        const response = await axios.get("/configuration/existing");
        this.hasExistingConfiguration = response.data.has_configuration;
        this.existingMode = response.data.mode || null;
        if (this.hasExistingConfiguration) {
          this.lockedMode = this.existingMode;
          this.selectedMode = this.existingMode || "Devis";
          this.confirmedMode = true;
        }
        console.log("checkExistingConfiguration:", {
          hasExistingConfiguration: this.hasExistingConfiguration,
          existingMode: this.existingMode,
          selectedMode: this.selectedMode,
        });
      } catch (error) {
        console.error(
          "Erreur lors de la vérification de la configuration existante:",
          error
        );
        this.errors.step1 = "Erreur lors de la vérification de la configuration.";
      }
    },
    async fetchMaterials() {
      this.loading.materials = true;
      this.errors.materials = null;
      try {
        const response = await axios.get("/configuration/materials");
        this.materials = response.data.materials || [];
      } catch (error) {
        console.error("Erreur lors du chargement des matériaux:", error);
        this.errors.materials = "Erreur lors du chargement des matériaux.";
        this.materials = [];
      } finally {
        this.loading.materials = false;
      }
    },
    async fetchBrands(material) {
      this.loading.brands = true;
      this.errors.brands = null;
      try {
        const response = await axios.get(
          `/configuration/brands/${encodeURIComponent(material)}`
        );
        this.brandsDict[material] = response.data.brands || [];
        // Normalize selectedBrands to match brandList structure
        this.selectedBrands = (response.data.selectedBrands || []).map((brand) => ({
          id: brand.id,
          nom_marques: brand.nom_marques,
          image: brand.image,
        }));
        console.log(
          "fetchBrands réussi:",
          this.brandsDict[material],
          this.selectedBrands
        );
      } catch (error) {
        console.error("Erreur lors du chargement des marques:", error);
        this.errors.brands = "Erreur lors du chargement des marques.";
        this.brandsDict[material] = [];
        this.selectedBrands = [];
      } finally {
        this.loading.brands = false;
      }
    },
    async fetchModels(brand) {
      this.loading.models = true;
      this.errors.models = null;
      try {
        const response = await axios.get(
          `/configuration/models/${encodeURIComponent(brand)}`
        );
        console.log("fetchModels response:", response.data); // Debug log
        this.modelsDict[brand] = response.data.models || [];
        this.selectedModels = response.data.selectedModels || [];
        console.log("modelsDict updated:", this.modelsDict); // Debug log
        console.log("selectedModels:", this.selectedModels); // Debug log
      } catch (error) {
        console.error("Erreur lors du chargement des modèles:", error);
        this.errors.models = "Erreur lors du chargement des modèles.";
        this.modelsDict[brand] = [];
        this.selectedModels = [];
      } finally {
        this.loading.models = false;
      }
    },
    async fetchPannes(brand, modele) {
      this.loading.models = true;
      this.errors.models = null;
      try {
        const response = await axios.get(
          `/configuration/pannes/${encodeURIComponent(brand)}/${encodeURIComponent(
            modele
          )}`
        );
        this.pannes = response.data.pannes || [];
        console.log(this.pannes);
        this.prixParCapacite =
          response.data.prixParCapacite || this.getDefaultPrixParCapacite();
        this.showPriceTable = response.data.showPriceTable ?? false;
      } catch (error) {
        console.error("Erreur lors du chargement des pannes:", error);
        this.errors.models = "Erreur lors du chargement des pannes.";
        this.pannes = [];
      } finally {
        this.loading.models = false;
      }
    },
    async fetchAppointmentTypes() {
      this.loading.appointmentTypes = true;
      this.errors.appointmentTypes = null;
      try {
        const response = await axios.get("/configuration/appointment-types");
        this.appointmentTypes = response.data.data || [];
        console.log("Fetched appointment types:XXXX", this.appointmentTypes);
      } catch (error) {
        console.error("Failed to fetch appointment types:", error);
        if (error.response?.status === 405) {
          this.errors.appointmentTypes =
            "Le serveur ne prend pas en charge la requête GET pour les types de rendez-vous.";
        } else {
          this.errors.appointmentTypes =
            "Erreur lors du chargement des types de rendez-vous.";
        }
        this.appointmentTypes = [];
      } finally {
        this.loading.appointmentTypes = false;
      }
    },
    showConfirmationModal() {
      if (!this.selectedMode || !["Devis", "Rendez-vous"].includes(this.selectedMode)) {
        console.warn(
          "showConfirmationModal: Invalid or missing selectedMode:",
          this.selectedMode
        );
        this.selectedMode = "Devis";
        return;
      }
      console.log("Showing ModeConfirmationModal with selectedMode:", this.selectedMode);
      const modal = new bootstrap.Modal(document.getElementById("modeConfirmationModal"));
      modal.show();
    },
    confirmMode() {
      if (this.hasExistingConfiguration && this.selectedMode !== this.existingMode) {
        alert(
          "Vous ne pouvez pas changer de mode, veuillez contacter le support de Ice computer."
        );
        return;
      }
      this.lockedMode = this.selectedMode;
      this.confirmedMode = false;
      this.step = 1;
    },
    resetMode() {
      this.selectedMode = this.hasExistingConfiguration
        ? this.existingMode || "Devis"
        : "Devis";
      this.confirmedMode = false;
      this.resetConfiguration();
    },
    async selectMaterial(mat) {
      console.log("selectMaterial called with:", mat);
      this.selectedMaterial = mat;
      this.selectedBrand = null;
      this.selectedModels = [];
      this.priceMap = {};
      await this.fetchBrands(mat);

      // S’assure que la brandList est bien mise à jour
      if (!this.brandsDict[mat] || this.brandsDict[mat].length === 0) {
        console.warn(`Aucune marque trouvée pour le matériel: ${mat}`);
      } else {
        console.log(`Brand list mise à jour avec succès:`, this.brandsDict[mat]);
      }

      this.step = 2;
    },
    async updateBrand(brand) {
      console.log("updateBrand called with:", brand); // Debug log
      this.selectedBrand = brand;
      this.selectedModels = [];
      this.priceMap = {};
      if (this.selectedBrand) {
        await this.fetchModels(this.selectedBrand);
        console.log("Navigating to step 3 with selectedBrand:", this.selectedBrand); // Debug log
      }
    },
    async submitConfiguration() {
      this.isLoading = true;
      if (this.hasExistingConfiguration && this.lockedMode !== this.existingMode) {
        alert("Le mode sélectionné ne correspond pas à la configuration existante.");
        this.isLoading = false;
        return;
      }
      try {
        await axios.post("/configuration/appointment-types", {
          mode: this.lockedMode,
          parts: this.parts,
          remiseOnline: this.remiseOnline,
          material: this.selectedMaterial,
          brands: this.selectedBrands,
          brand: this.selectedBrand,
          models: this.selectedModels,
          prices: this.priceMap,
          appointment_type: this.appointmentType,
          shop_addresses: this.shopAddresses,
          appointment_options: this.appointmentOptions,
        });
        this.configurationSubmitted = true;
        this.hasExistingConfiguration = true;
        this.existingMode = this.lockedMode;
        const resultModal = new bootstrap.Modal(
          document.getElementById("configResultModal")
        );
        resultModal.show();
      } catch (error) {
        console.error("Erreur lors de l’enregistrement de la configuration:", error);
        this.errors.submit = "Erreur lors de l’enregistrement de la configuration.";
      } finally {
        this.isLoading = false;
      }
    },
    async goToStep2() {
      console.log("Handling go-to-step2 event");
      console.log("Current lockedMode:", this.lockedMode);
      // Save step1 configuration (types, addresses, appointment options) before proceeding
      if (this.lockedMode === "Rendez-vous") {
        this.isSavingStep1 = true;
        try {
          await axios.post("/configuration/rendez-vous/save-step1", {
            mode: this.lockedMode,
            parts: this.parts,
            remiseOnline: this.remiseOnline,
            shop_addresses: this.shopAddresses,
            appointment_options: this.appointmentOptions,
          });
           
          console.log("Step 1 saved successfully for Rendez-vous mode.");
        } catch (error) {
          console.error("Erreur lors de la sauvegarde de l'étape 1:", error);
          this.errors.step1 =
            "Erreur lors de la sauvegarde de l'étape 1. Veuillez réessayer.";
          this.isSavingStep1 = false;
          return; // Don't proceed if save fails
        } finally {
          this.isSavingStep1 = false;
        }
      }
      this.step = 2;
    },
    resetConfiguration() {
      this.step = 1;
      this.parts = [{ name: "" , is_qualirepar: 0, montant:0}];
      this.remiseOnline = 0;
      this.appointmentType = null;
      this.selectedMaterial = null;
      this.selectedBrands = [];
      this.selectedBrand = null;
      this.selectedModels = [];
      this.priceMap = {};
      this.pannes = [];
      this.configurationSubmitted = false;
      this.lockedMode = null;
      this.selectedMode = this.hasExistingConfiguration
        ? this.existingMode || "Devis"
        : "Devis";
      this.confirmedMode = this.hasExistingConfiguration;
      this.hasExistingConfiguration = false;
      this.existingMode = null;
      this.prixParCapacite = this.getDefaultPrixParCapacite();
      this.showPriceTable = false;
      this.deleteExistingConfiguration();
    },
    async deleteExistingConfiguration() {
      try {
        await axios.delete("/configuration/reset");
        console.log("Configuration existante supprimée.");
      } catch (error) {
        console.error("Erreur lors de la suppression de la configuration:", error);
      }
    },
    async openPriceModal(model) {
      this.modalModel = model;
      this.modalPrice = this.priceMap[model.id] || 0;

      await this.$nextTick();

      const el = document.getElementById("priceModal");
      if (!el) {
        console.warn("⚠️ Modal #priceModal introuvable dans le DOM.");
        return;
      }

      let instance = bootstrap.Modal.getInstance(el);
      if (!instance) {
        instance = new bootstrap.Modal(el, { backdrop: "static" });
      }

      instance.show();

      if (this.modalModel) {
        await this.fetchPannes(this.modalModel.marque_id, this.modalModel.id);
      }
    },

    async openConfiguredModelsModal() {
      const el = document.getElementById("viewConfiguredModelsModal");
      const instance = bootstrap.Modal.getInstance(el) || new bootstrap.Modal(el);
      instance.show();

      if (this.selectedModels.length > 0) {
        const model = this.selectedModels[this.selectedModels.length - 1];
        await this.fetchPannes(model.marque_id, model.id);
      }
    },
    confirmResetConfiguration() {
      if (
        confirm(
          "Êtes-vous sûr de vouloir réinitialiser toute la configuration ? Cette action est irréversible."
        )
      ) {
        this.resetConfiguration();
        const el = document.getElementById("viewConfiguredModelsModal");
        const instance = bootstrap.Modal.getInstance(el);
        if (instance) {
          instance.hide();
        }
      }
    },
    async updatePannes(updatedPannes) {
      this.isLoading = true;
      const priceModalElement = document.getElementById("priceModal");
      const priceModal =
        bootstrap.Modal.getInstance(priceModalElement) ||
        new bootstrap.Modal(priceModalElement);

      if (this.hasExistingConfiguration && this.lockedMode !== this.existingMode) {
        alert("Le mode sélectionné ne correspond pas à la configuration existante.");
        this.isLoading = false;
        return;
      }

      try {
        const updatedPannesData = updatedPannes.map((panne) => ({
          id: panne.id,
          nom: panne.nom,
          image: panne.image,
          is_qualirepar: panne.is_qualirepar,
          types: panne.types.map((type) => ({
            id: type.id,
            nom: type.nom,
            montant: type.montant,
            is_qualirepar: type.is_qualirepar,
            prix_achat: Number(type.prix_achat) || 0,
            prix_initial: Number(type.prix_initial) || 0,
            prix_promo: Number(type.prix_promo) || 0,
            //remise: Number(type.remise) || 0,
            afficher: Boolean(type.afficher),
          })),
        }));

        const hasInvalidPrices = updatedPannesData.some((panne) =>
          panne.types.some(
            (type) => type.prix_initial < 0 || type.prix_promo < 0 || type.remise < 0
          )
        );
        if (hasInvalidPrices) {
          this.errors.submit = "Les prix et remises ne peuvent pas être négatifs.";
          this.isLoading = false;
          return;
        }

        await axios.post("/configuration", {
          modalModel: this.modalModel,
          pannes: updatedPannesData,
          prixParCapacite: this.prixParCapacite,
          showPriceTable: this.showPriceTable,
          modeRequest: this.lockedMode,
        });

        this.pannes = updatedPannesData;

        const modelIndex = this.selectedModels.findIndex(
          (m) => m.id === this.modalModel.id
        );
        if (modelIndex === -1) {
          this.selectedModels.push(this.modalModel);
        }
        this.priceMap[this.modalModel.id] = Object.values(
          this.prixParCapacite[1] || {}
        ).reduce((a, b) => a + b, 0);

        priceModal.hide();
        this.errors.submit = null;
      } catch (error) {
        console.error("Erreur lors de l’enregistrement de la configuration:", error);
        this.errors.submit = "Erreur lors de l’enregistrement de la configuration.";
      } finally {
        this.isLoading = false;
      }
    },
  },
};
</script>

<style scoped>
.configuration-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
}
</style>
