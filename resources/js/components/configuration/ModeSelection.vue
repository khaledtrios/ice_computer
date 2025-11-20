<template>
  <div class="mode-selection">
    <div class="mode-selection-header">
      <h2 class="mode-selection-title">
        Activez les fonctionnalités que vous souhaitez proposer à vos clients
      </h2>
      <p class="mode-selection-subtitle">
        Sélectionnez le type d'assistance dont vous avez besoin
      </p>
    </div>
    <div class="mode-options">
      <div
        class="mode-option"
        :class="{ active: selectedMode === 'Devis' }"
        @click="$emit('update:selectedMode', 'Devis')"
      >
        <input
          type="radio"
          class="mode-radio"
          id="mode-devis"
          :value="'Devis'"
          :checked="selectedMode === 'Devis'"
          @input="$emit('update:selectedMode', $event.target.value)"
        />
        <label for="mode-devis" class="mode-card">
          <div class="mode-icon bg-blue">
            <i class="fa fa-file-invoice"></i>
          </div>
          <h3 class="mode-name">Proposer une demande de devis</h3>
          <p class="mode-description">
            Permettez à vos clients d’obtenir une estimation précise du coût de réparation
            pour leur appareil.
          </p>
          <ul class="mode-benefits">
            <li><i class="fas fa-check-circle"></i> Estimation gratuite</li>
            <li><i class="fas fa-check-circle"></i> Sans engagement</li>
            <li><i class="fas fa-check-circle"></i> Réponse sous 24h</li>
          </ul>
        </label>
      </div>
      <div
        class="mode-option"
        :class="{ active: selectedMode === 'Rendez-vous' }"
        @click="$emit('update:selectedMode', 'Rendez-vous')"
      >
        <input
          type="radio"
          class="mode-radio"
          id="mode-rdv"
          :value="'Rendez-vous'"
          :checked="selectedMode === 'Rendez-vous'"
          @input="$emit('update:selectedMode', $event.target.value)"
        />
        <label for="mode-rdv" class="mode-card">
          <div class="mode-icon bg-green">
            <i class="fa fa-calendar-alt"></i>
          </div>
          <h3 class="mode-name">Activer la prise de rendez-vous</h3>
          <p class="mode-description">
            Vos clients peuvent planifier une intervention avec vous ou vos techniciens.
          </p>
          <ul class="mode-benefits">
            <li><i class="fas fa-check-circle"></i> Disponibilité en temps réel</li>
            <li><i class="fas fa-check-circle"></i> Choix du lieu d'intervention</li>
            <li><i class="fas fa-check-circle"></i> Confirmation immédiate</li>
          </ul>
        </label>
      </div>
    </div>
    <div class="mode-confirmation" v-if="selectedMode">
      <button class="confirm-button" @click="$emit('show-confirmation-modal')">
        Continuer avec
        {{ selectedMode === "Devis" ? "le devis" : "le rendez-vous" }}
        <i class="bi bi-arrow-right"></i>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    selectedMode: {
      type: String,
      default: "Devis",
    },
  },
  emits: ["update:selectedMode", "show-confirmation-modal"],
};
</script>

<style scoped>
.mode-selection {
  background: white;
  border-radius: 16px;
  padding: 2rem;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.mode-selection-header {
  text-align: center;
  margin-bottom: 2rem;
}

.mode-selection-title {
  font-size: 1.8rem;
  font-weight: 700;
  color: #2c3e50;
  margin-bottom: 0.5rem;
}

.mode-selection-subtitle {
  font-size: 1.1rem;
  color: #7f8c8d;
}

.mode-options {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  gap: 2rem;
  margin-top: 2rem;
}

.mode-option {
  position: relative;
}

.mode-radio {
  position: absolute;
  opacity: 0;
}

.mode-card {
  display: flex;
  flex-direction: column;
  height: 100%;
  padding: 2rem;
  border: 2px solid #e0e0e0;
  border-radius: 12px;
  transition: all 0.3s ease;
  cursor: pointer;
}

.mode-option.active .mode-card {
  border-color: var(--primary-color);
  background-color: #f8fafc;
  transform: translateY(-5px);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.mode-icon {
  width: 64px;
  height: 64px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  margin-bottom: 1.5rem;
  font-size: 1.8rem;
  color: white;
}

.bg-blue {
  background-color: #3498db;
}

.bg-green {
  background-color: #2ecc71;
}

.mode-name {
  font-size: 1.3rem;
  font-weight: 600;
  margin-bottom: 0.8rem;
  color: #2c3e50;
}

.mode-description {
  color: #7f8c8d;
  margin-bottom: 1.5rem;
  line-height: 1.5;
}

.mode-benefits {
  list-style: none;
  padding: 0;
  margin-top: auto;
}

.mode-benefits li {
  margin-bottom: 0.5rem;
  color: #34495e;
}

.mode-benefits i {
  margin-right: 0.5rem;
  color: var(--primary-color);
}

.mode-confirmation {
  text-align: center;
  margin-top: 3rem;
  padding-top: 2rem;
  border-top: 1px solid #eee;
}

.confirm-button {
  background-color: #46d8d5;
  color: white;
  border: none;
  padding: 0.8rem 2rem;
  border-radius: 50px;
  font-weight: 600;
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.3s ease;
  display: inline-flex;
  align-items: center;
}

.confirm-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.confirm-button i {
  margin-left: 0.5rem;
}

:root {
  --primary-color: #3498db;
}
</style>
