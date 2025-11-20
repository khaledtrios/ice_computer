<template>
  <section>
    <h6 class="text-center mb-4">
      <span class="badge bg-primary me-2">2</span>
      Choisissez le matériel
    </h6>
    <div class="row g-4 mb-4">
      <div v-for="mat in materials" :key="mat.id" class="col-sm-6">
        <div
          :class="['card select-card h-100', { selected: selectedMaterial === mat.id }]"
          @click="$emit('update:selectedMaterial', mat.id)"
        >
          <div class="card-img-top overflow-hidden" style="height: 160px">
            <img
              :src="`/storage/${mat.image}`"
              :alt="mat.nom_materiel"
              class="h-100 object-fit-contain select-img w-100"
            />
          </div>
          <div class="card-body text-center">
            <strong>{{ mat.nom_materiel }}</strong>
          </div>
          <div class="card-footer bg-transparent text-center">
            <i class="bi bi-chevron-right text-primary"></i>
          </div>
        </div>
      </div>
    </div>
    <div v-if="lockedMode === 'Rendez-vous' && selectedMaterial" class="mb-4">
      <h6 class="text-center mb-3">
        Choisissez une marque, puis double-cliquez sur le modèle pour saisir les prix des
        réparations.
      </h6>
      <div class="brand-selector mb-3">
        <label for="brand-select" class="form-label">Sélectionner une marque :</label>
        <select
          id="brand-select"
          class="form-select"
          :value="selectedBrand"
          @change="$emit('update:selectedBrand', $event.target.value)"
        >
          <option value="" disabled>Sélectionnez une marque</option>
          <option v-for="mar in brandList" :key="mar.id" :value="mar.id">
            {{ mar.nom_marques }}
          </option>
        </select>
      </div>
      <div v-if="selectedBrand && !loading.models">
        <div class="mb-3">
          <input
            :value="modelSearch"
            type="text"
            class="form-control"
            placeholder="Rechercher un modèle..."
            @input="$emit('update:modelSearch', $event.target.value)"
          />
        </div>
        <div class="row g-4">
          <div
            v-for="mdl in filteredModelList"
            :key="mdl.id"
            class="col-sm-6 col-md-4 col-lg-3"
          >
            <div
              :class="['card select-card h-100', { selected: modelSelected(mdl) }]"
              @click="$emit('open-price-modal', mdl)"
            >
              <div class="card-img-top overflow-hidden" style="height: 120px">
                <img
                  :src="getModelImg(mdl)"
                  :alt="mdl.nom_modele"
                  class="select-img w-100 h-100 object-fit-contain p-2"
                />
              </div>
              <div class="card-body text-center">
                <small class="fw-bold">{{ mdl.nom_modele }}</small>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-if="loading.models" class="text-center">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Chargement...</span>
        </div>
        <p>Chargement des modèles...</p>
      </div>
    </div>
    <div class="d-flex justify-content-between mt-4">
      <button class="btn btn-outline-secondary px-4" @click="$emit('update:step', 1)">
        <i class="bi bi-arrow-left me-2"></i>Retour
      </button>
      <button
        v-if="lockedMode === 'Devis'"
        class="btn btn-primary px-4"
        :disabled="!selectedMaterial"
        @click="$emit('update:step', 3)"
      >
        <i class="bi bi-check-lg me-2"></i>Suivant
      </button>
      <button
        v-if="lockedMode === 'Rendez-vous'"
        class="btn btn-primary px-4"
        :disabled="
          !selectedMaterial ||
          !selectedBrand ||
          selectedModels.length === 0 ||
          !allPricesSet
        "
        @click="$emit('update:step', 3)"
      >
        <i class="bi bi-check-lg me-2"></i>Suivant
      </button>
    </div>
  </section>
</template>

<script>
export default {
  props: {
    lockedMode: String,
    materials: Array,
    selectedMaterial: [String, Number, null],
    brandList: Array,
    selectedBrand: [String, Number, null],
    modelList: Array,
    filteredModelList: Array,
    modelSearch: String,
    selectedModels: Array,
    priceMap: Object,
    loading: Object,
  },
  emits: [
    "update:step",
    "update:selectedMaterial",
    "update:selectedBrand",
    "update:modelSearch",
    "update:selectedModels",
    "update:priceMap",
    "open-price-modal",
  ],
  computed: {
    allPricesSet() {
      console.log("model:", this.selectedModels);
      return this.selectedModels.every((model) => this.priceMap[model.id] >= 0);
    },
  },
  methods: {
    modelSelected(model) {
      return this.selectedModels.includes(model);
    },
    getModelImg(model) {
      return `/storage/${model.image}`;
    },
  },
};
</script>
