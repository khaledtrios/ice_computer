<template>
  <section>
    <h6 class="text-center mb-4">
      <span class="badge bg-primary me-2">3</span>
      Confirmez les modèles
    </h6>
    <div class="text-center mb-4">
      <p>Sélectionnez ou modifiez les modèles via la fenêtre modale.</p>
      <div class="d-flex justify-content-center gap-2">
        <button
          class="btn btn-primary"
          @click="$emit('open-price-modal', selectedModels[0] || modelList[0])"
        >
          <i class="bi bi-pencil-square me-2"></i>Modifier les modèles
        </button>
        <button
          class="btn btn-outline-info"
          @click="$emit('open-configured-models-modal')"
        >
          <i class="bi bi-list-check me-2"></i>Voir les modèles configurés
        </button>
      </div>
    </div>
    <div class="row g-4">
      <div v-for="mdl in selectedModels" :key="mdl.id" class="col-sm-6 col-md-4 col-lg-3">
        <div class="card select-card h-100">
          <div class="card-img-top overflow-hidden" style="height: 120px">
            <img
              :src="`/storage/${mdl.image}`"
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
    <div class="d-flex justify-content-between mt-4">
      <button class="btn btn-outline-secondary px-4" @click="$emit('update:step', 2)">
        <i class="bi bi-arrow-left me-2"></i>Retour
      </button>
      <button
        class="btn btn-primary px-4"
        :disabled="selectedModels.length === 0 || !allPricesSet"
        @click="$emit('submit-configuration')"
      >
        <i class="bi bi-check-lg me-2"></i>Terminer
      </button>
    </div>
  </section>
</template>

<script>
export default {
  props: {
    selectedModels: Array,
    priceMap: Object,
    modelList: Array,
  },
  emits: [
    "update:step",
    "open-price-modal",
    "open-configured-models-modal",
    "submit-configuration",
  ],
  computed: {
    allPricesSet() {
      return this.selectedModels.every((model) => this.priceMap[model.id] >= 0);
    },
  },
};
</script>
