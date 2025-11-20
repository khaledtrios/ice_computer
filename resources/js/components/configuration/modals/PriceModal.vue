<template>
  <div
    v-if="modalModel"
    class="modal fade"
    id="priceModal"
    tabindex="-1"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header border-0 pb-0">
          <h5 class="modal-title">
            Configurer les réparations pour
            <strong>{{ modalModel.nom_modele }}</strong> ?
          </h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Fermer"
          ></button>
        </div>
        <div class="modal-body">
          <div v-if="errors.submit" class="alert alert-danger" role="alert">
            {{ errors.submit }}
          </div>
          <div class="row">
            <div class="col-md-4 col-12 d-flex flex-column align-items-center gap-4 px-2">
              <img
                :src="'/storage/' + modalModel.image"
                alt="Image du modèle"
                class="img-fluid rounded"
                style="max-height: 250px; width: 100%; object-fit: contain"
              />
              <div class="form-check form-switch mb-3 text-center w-100">
                <input
                  class="form-check-input"
                  type="checkbox"
                  :checked="showPriceTable"
                  id="showRachatSwitch"
                  @change="$emit('update:showPriceTable', $event.target.checked)"
                />
                <label class="form-check-label w-100 text-center" for="showRachatSwitch">
                  Afficher l’offre de rachat
                </label>
              </div>
              <div v-if="showPriceTable" class="w-100 mb-3">
                <h6 class="fw-bold mb-2 text-center">
                  Prix de Rachat par Type et Capacité :
                </h6>
                <div class="accordion" id="rachatAccordion">
                  <div
                    v-for="typeData in rachatTypes"
                    :key="typeData.id"
                    class="accordion-item border-0 bg-white mb-2"
                  >
                    <h2 class="accordion-header" :id="'headingRachat' + typeData.id">
                      <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        :data-bs-target="'#collapseRachat' + typeData.id"
                        aria-expanded="false"
                        :aria-controls="'collapseRachat' + typeData.id"
                      >
                        {{ typeData.label }}
                      </button>
                    </h2>
                    <div
                      :id="'collapseRachat' + typeData.id"
                      class="accordion-collapse collapse"
                      :aria-labelledby="'headingRachat' + typeData.id"
                      data-bs-parent="#rachatAccordion"
                    >
                      <div class="accordion-body p-2">
                        <div class="table-responsive" style="font-size: 0.875rem">
                          <table class="table table-bordered table-sm align-middle mb-0">
                            <thead class="table-light">
                              <tr>
                                <th>Capacité</th>
                                <th>Prix</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="cap in capacities" :key="cap">
                                <td class="text-center">{{ cap }}</td>
                                <td>
                                  <input
                                    type="number"
                                    class="form-control form-control-sm"
                                    min="0"
                                    :value="prixParCapacite[typeData.id]?.[cap] || 0"
                                    @input="
                                      updatePrix(typeData.id, cap, $event.target.value)
                                    "
                                  />
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
            </div>
            <div class="col-md-8 col-12">
              <h6 class="fw-bold mb-3">Liste des pannes </h6>
              <span class="mb-2"
                >Configurez le prix, la promotion et l’affichage de chaque
                réparation</span
              >
              <div class="accordion d-flex flex-column gap-3" id="accordionPannes">
                <div
                  v-for="panne in pannes"
                  :key="panne.id"
                  class="accordion-item border rounded w-100"
                >
                  <h2 class="accordion-header" :id="'heading' + panne.id">
                    <button
                      class="accordion-button collapsed d-flex align-items-center justify-content-between p-3"
                      type="button"
                      data-bs-toggle="collapse"
                      :data-bs-target="'#collapse' + panne.id"
                      aria-expanded="false"
                      :aria-controls="'collapse' + panne.id"
                    >
                    <span>
                      <i class="bi bi-tools fs-5 me-3 text-primary"></i>
                      <span class="flex-grow-1 ms-3">{{ panne.nom }}</span>
                    </span>
                      
                      <span v-if="panne.is_qualirepar" class="text-danger"> Eligible Qualirepar</span>
                    </button>
                      
                  </h2>
                  <div
                    :id="'collapse' + panne.id"
                    class="accordion-collapse collapse"
                    :aria-labelledby="'heading' + panne.id"
                    data-bs-parent="#accordionPannes"
                  >
                    <div class="accordion-body p-3">
                      <div class="table-responsive" style="font-size: 0.875rem">
                        <table class="table table-sm table-bordered">
                          <thead>
                            <tr>
                              <th>Type</th>
                              <th>Prix initial (€)</th>
                              <th>Prix promo (€)</th> 
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="(type, i) in panne.types" :key="i">
                              <td style="padding: 0.75rem 0.5rem;">
                                <input
                                  type="text"
                                  class="form-control form-control-sm"
                                  v-model="type.nom"
                                  placeholder="Nom du type"
                                  disabled
                                />
                                <div v-if="type.is_qualirepar" class="text-danger text-center mt-1" style="font-size:8px;">
                                  QualiRépar - {{ type.montant }} €
                                </div>
                              </td>
                              <td>
                                <input
                                  type="number"
                                  class="form-control form-control-sm"
                                  v-model="type.prix_initial"
                                  @input="$emit('update:pannes', [...pannes])"
                                />
                              </td>
                              <td>
                                <input
                                  type="number"
                                  class="form-control form-control-sm"
                                  v-model="type.prix_promo"
                                  @input="$emit('update:pannes', [...pannes])"
                                />
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
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            <i class="bi bi-x me-1"></i> Annuler
          </button>
          <button
            type="button"
            class="btn btn-info"
            @click="$emit('update-pannes', pannes)"
          >
            Valider
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    modalModel: Object,
    pannes: Array,
    prixParCapacite: {
      type: Object,
      default: () => ({
        1: { 16: 0, 32: 0, 64: 0, 128: 0, 256: 0 },
        2: { 16: 0, 32: 0, 64: 0, 128: 0, 256: 0 },
        3: { 16: 0, 32: 0, 64: 0, 128: 0, 256: 0 },
      }),
    },
    capacities: {
      type: Array,
      default: () => [16, 32, 64, 128, 256],
    },
    showPriceTable: Boolean,
    lockedMode: String,
    errors: Object,
  },
  emits: [
    "update:pannes",
    "update:prixParCapacite",
    "update:showPriceTable",
    "update-pannes",
  ],
  data() {
    return {
      rachatTypes: [
        { id: 1, label: "Bon état" },
        { id: 2, label: "Mauvais état" },
        { id: 3, label: "Pièce" },
      ],
    };
  },
  methods: {
    updatePrix(typeId, capacity, value) {
      const numValue = parseFloat(value) || 0;
      const newPrix = { ...this.prixParCapacite };
      if (!newPrix[typeId]) newPrix[typeId] = {};
      newPrix[typeId][capacity] = numValue;
      this.$emit("update:prixParCapacite", newPrix);
    },
  },
  watch: {
    prixParCapacite: {
      handler(newVal) {
        // Ensure structure is always complete
        const complete = { ...this.prixParCapacite };
        this.rachatTypes.forEach((type) => {
          if (!complete[type.id]) complete[type.id] = {};
          this.capacities.forEach((cap) => {
            if (complete[type.id][cap] === undefined) complete[type.id][cap] = 0;
          });
        });
        if (JSON.stringify(complete) !== JSON.stringify(newVal)) {
          this.$emit("update:prixParCapacite", complete);
        }
      },
      deep: true,
      immediate: true,
    },
  },
};
</script>
