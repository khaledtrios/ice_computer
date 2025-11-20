<template>
  <div
    v-if="isModalReady"
    class="modal fade"
    id="modeConfirmationModal"
    tabindex="-1"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header border-0 pb-0">
          <div class="confirmation-header">
            <i class="bi bi-check-circle-fill"></i>
            <h3>Confirmez le service activé pour votre site</h3>
          </div>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Fermer"
          ></button>
        </div>
        <div class="modal-body confirmation-body">
          <p v-if="selectedMode">
            Vous avez choisi de proposer le service :
            <strong>{{ selectedMode }}</strong> à vos clients.
          </p>
          <p v-else class="text-danger">
            Aucun mode sélectionné. Veuillez choisir un mode.
          </p>
          <p class="warning-text" v-if="hasExistingConfiguration && existingMode">
            <i class="bi bi-exclamation-triangle-fill"></i>
            Une configuration existe déjà pour le mode <strong>{{ existingMode }}</strong
            >. Ce choix remplacera la configuration existante.
          </p>
          <p class="warning-text" v-else-if="hasExistingConfiguration && !existingMode">
            <i class="bi bi-exclamation-triangle-fill"></i>
            Une configuration existe, mais le mode est indéfini. Veuillez vérifier.
          </p>
          <p class="warning-text" v-else>
            <i class="bi bi-exclamation-triangle-fill"></i>
            Ce choix sera définitif pour cette session de configuration.
          </p>
        </div>
        <div class="modal-footer confirmation-actions">
          <button
            type="button"
            class="btn cancel-button"
            data-bs-dismiss="modal"
            @click="$emit('reset-mode')"
          >
            <i class="bi bi-x-lg"></i> Annuler
          </button>
          <button
            type="button"
            class="btn confirm-button"
            data-bs-dismiss="modal"
            @click="$emit('confirm-mode')"
            :disabled="!selectedMode"
          >
            <i class="bi bi-check-lg"></i> Confirmer
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    selectedMode: {
      type: String,
      default: null, // Explicitly handle undefined cases
    },
    hasExistingConfiguration: {
      type: Boolean,
      default: false,
    },
    existingMode: {
      type: String,
      default: null, // Explicitly handle undefined cases
    },
  },
  emits: ["confirm-mode", "reset-mode"],
  computed: {
    isModalReady() {
      // Only render modal if selectedMode is a string or null
      const isReady = this.selectedMode === null || typeof this.selectedMode === "string";
      if (!isReady) {
        console.warn("ModeConfirmationModal: Invalid selectedMode", this.selectedMode);
      }
      return isReady;
    },
  },
  mounted() {
    // Log props for debugging
    console.log("ModeConfirmationModal mounted with props:", {
      selectedMode: this.selectedMode,
      hasExistingConfiguration: this.hasExistingConfiguration,
      existingMode: this.existingMode,
    });
  },
};
</script>

<style scoped>
.confirmation-header {
  display: flex;
  align-items: center;
  margin-bottom: 1.5rem;
  color: var(--primary-color);
}

.confirmation-header i {
  font-size: 1.8rem;
  margin-right: 1rem;
}

.confirmation-header h3 {
  font-size: 1.4rem;
  margin: 0;
}

.confirmation-body {
  margin-bottom: 2rem;
}

.confirmation-body p {
  margin-bottom: 1rem;
  line-height: 1.5;
}

.warning-text {
  color: #e74c3c;
  display: flex;
  align-items: center;
}

.warning-text i {
  margin-right: 0.5rem;
}

.confirmation-actions {
  display: flex;
  justify-content: center;
  gap: 1rem;
}

.cancel-button {
  background-color: #f8f9fa;
  color: #6c757d;
  border: 1px solid #dee2e6;
  padding: 0.8rem 2rem;
  border-radius: 50px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
}

.cancel-button:hover {
  background-color: #e9ecef;
}

.confirm-button {
  background-color: #46d8d5;
  color: white;
  border: none;
  padding: 0.8rem 2rem;
  border-radius: 50px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
}

.confirm-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.confirm-button:disabled {
  background-color: #6c757d;
  cursor: not-allowed;
}

:root {
  --primary-color: #3498db;
}
</style>
