<template>
  <section>
    <h6 class="text-center mb-4">Choisissez les marques</h6>

    <div class="d-flex justify-content-end mb-3">
      <button
        class="btn btn-outline-primary me-2"
        @click="selectAllBrands()"
        :disabled="isLoading"
      >
        Tout sélectionner
      </button>
      <button
        class="btn btn-outline-secondary"
        @click="clearBrands()"
        :disabled="isLoading"
      >
        Tout désélectionner
      </button>
    </div>

    <div class="row g-4">
      <div v-for="mar in brandList" :key="mar.id" class="col-sm-6 col-md-4">
        <div
          :class="['card select-card h-100', { selected: isSelected(mar.id) }]"
          @click.stop="!isLoading && toggleBrand(mar)"
          :style="{
            pointerEvents: isLoading ? 'none' : 'auto',
            opacity: isLoading ? 0.6 : 1,
          }"
        >
          <div class="card-img-top overflow-hidden" style="height: 120px">
            <img
              :src="`/storage/${mar.image}`"
              :alt="mar.nom_marques"
              class="select-img w-100 h-100 object-fit-contain p-3"
            />
          </div>
          <div class="card-body text-center">
            <small class="fw-bold">{{ mar.nom_marques }}</small>
          </div>
          <div class="card-footer bg-transparent text-center">
            <i v-if="isSelected(mar.id)" class="bi bi-check-circle text-primary"></i>
            <i v-else class="bi bi-chevron-right text-primary"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-between mt-4">
      <button
        class="btn btn-outline-secondary px-4"
        @click="$emit('update:step', 2)"
        :disabled="isLoading"
      >
        <i class="bi bi-arrow-left me-2"></i>Retour
      </button>

      <button
        class="btn btn-primary px-4 d-flex align-items-center justify-content-center"
        :disabled="selectedBrands.length === 0 || isLoading"
        @click="$emit('submit-configuration')"
      >
        <span v-if="isLoading" class="spinner-border spinner-border-sm me-2"></span>
        {{ isLoading ? "Enregistrement..." : "Enregistrer Configuration" }}
      </button>
    </div>
  </section>
</template>

<script>
import { ref } from "vue";

export default {
  props: {
    brandList: { type: Array, default: () => [] },
    selectedBrands: { type: Array, default: () => [] },
    isLoading: { type: Boolean, default: false },
  },
  emits: ["update:selectedBrands", "update:step", "submit-configuration"],
  setup() {
    const isToggling = ref(false);
    return { isToggling };
  },
  methods: {
    isSelected(id) {
      return this.selectedBrands.some((b) => b.id === id);
    },
    toggleBrand(brand) {
      if (this.isToggling) return;
      this.isToggling = true;
      const newSelected = [...this.selectedBrands];
      const index = newSelected.findIndex((b) => b.id === brand.id);
      if (index !== -1) {
        newSelected.splice(index, 1);
      } else {
        newSelected.push(brand);
      }
      this.$emit("update:selectedBrands", newSelected);
      setTimeout(() => (this.isToggling = false), 200);
    },
    selectAllBrands() {
      const merged = [
        ...this.selectedBrands,
        ...this.brandList.filter((b) => !this.selectedBrands.some((s) => s.id === b.id)),
      ];
      this.$emit("update:selectedBrands", merged);
    },
    clearBrands() {
      const remaining = this.selectedBrands.filter(
        (b) => !this.brandList.some((m) => m.id === b.id)
      );
      this.$emit("update:selectedBrands", remaining);
    },
  },
};
</script>
