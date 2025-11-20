<template></template>

<script setup>
import { ref } from "vue";

const isOpen = ref(false);
const isMobile = ref(false);

// Détecter si on est sur mobile
if (window.matchMedia("(max-width: 768px)").matches) {
  isMobile.value = true;
}

// Fonction toggle (clic mobile)
const toggleFooter = () => {
  if (isMobile.value) {
    isOpen.value = !isOpen.value;
  }
};

// Hover pour desktop
const handleMouseEnter = () => {
  if (!isMobile.value) isOpen.value = true;
};

const handleMouseLeave = () => {
  if (!isMobile.value) isOpen.value = false;
};
</script>

<style scoped>
footer {
  user-select: none;
}
</style>
