<template>
  <div class="modal fade" id="configResultModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-success border-0">
          <h5 class="modal-title text-white mb-0">
            <i class="bi bi-check-circle-fill me-2"></i>Configuration enregistrée
          </h5>
          <button
            type="button"
            class="btn-close btn-close-white"
            data-bs-dismiss="modal"
            aria-label="Fermer"
          ></button>
        </div>
        <div class="modal-body">
          <transition name="fade">
            <div v-if="configurationSubmitted" class="card border-0 shadow-sm">
              <div class="card-body">
                <div class="alert alert-light">
                  <ul class="mb-0">
                    <li class="mb-2">
                      <strong>Pièces :</strong>
                      <div class="d-flex flex-wrap gap-2 mt-2">
                        <span
                          v-for="part in parts"
                          :key="part.type"
                          class="badge bg-info text-dark"
                          >{{ part.type }}</span
                        >
                      </div>
                    </li>
                    <li class="mb-2">
                      <strong>Matériel :</strong>
                      <span class="badge bg-primary">{{ selectedMaterial }}</span>
                    </li>
                    <li class="mb-2" v-if="lockedMode === 'Devis'">
                      <strong>Marques :</strong>
                      <div class="d-flex flex-wrap gap-2 mt-2">
                        <span
                          v-for="mar in selectedBrands"
                          :key="mar.id"
                          class="badge bg-info text-dark"
                          >{{ mar.nom_marques }}</span
                        >
                      </div>
                    </li>
                    <li class="mb-2" v-if="lockedMode === 'Rendez-vous'">
                      <strong>Marque :</strong>
                      <span class="badge bg-primary">{{ selectedBrand }}</span>
                    </li>
                    <li class="mb-2" v-if="lockedMode === 'Rendez-vous'">
                      <strong>Modèles :</strong>
                      <div class="d-flex flex-wrap gap-2 mt-2">
                        <span
                          v-for="m in selectedModels"
                          :key="m.id"
                          class="badge bg-info text-dark"
                        >
                          {{ m.nom_modele }}
                          ({{
                            priceMap[m.id].toLocaleString("fr-FR", {
                              style: "currency",
                              currency: "EUR",
                            })
                          }})
                        </span>
                      </div>
                    </li>
                    <li v-if="lockedMode === 'Rendez-vous'">
                      <strong>Type de rendez-vous :</strong>
                      <span class="badge bg-secondary">
                        {{
                          appointmentTypes.find((t) => t.id === appointmentType)?.label
                        }}
                        ({{
                          appointmentTypes
                            .find((t) => t.id === appointmentType)
                            ?.price.toLocaleString("fr-FR", {
                              style: "currency",
                              currency: "EUR",
                            })
                        }})
                      </span>
                    </li>
                    <li>
                      <strong>Mode :</strong>
                      <span class="badge bg-secondary">{{ lockedMode }}</span>
                    </li>
                  </ul>
                </div>
                <!--  <div class="text-center mt-3">
                  <button
                    @click="goToConfiguration"
                    class="btn btn-success px-4 text-center"
                  >
                    <i class="bi bi-gear me-2"></i>
                    Valider
                  </button>
                </div> -->
              </div>
            </div>
          </transition>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Valider et continuer la configuration
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    configurationSubmitted: Boolean,
    lockedMode: String,
    parts: Array,
    selectedMaterial: [String, Number, null],
    selectedBrands: Array,
    selectedBrand: [String, Number, null],
    selectedModels: Array,
    priceMap: Object,
    appointmentType: [String, Number, null],
    appointmentTypes: Array,
  },
};
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
