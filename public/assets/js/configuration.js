const { createApp } = Vue;

createApp({
    data() {
        return {
            selectedMode: "Devis",
            confirmedMode: false,
            lockedMode: null,
            step: 1,
            parts: [{ type: "" }],
            appointmentType: null,
            selectedMaterial: null,
            selectedBrands: [],
            selectedBrand: null,
            selectedModels: [],
            priceMap: {},
            configurationSubmitted: false,
            modalModel: null,
            modalPrice: 0,
            materials: [
                { id: "Smartphone", label: "Smartphone", img: "https://images.unsplash.com/photo-1598327105666-5b89351aff97?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=300&q=80" },
                { id: "Tablette", label: "Tablette", img: "https://images.unsplash.com/photo-1544244015-8e692ed3b714?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=300&q=80" },
            ],
            brandsDict: {
                Smartphone: ["Apple", "Samsung", "Xiaomi"],
                Tablette: ["Apple", "Samsung", "Microsoft"],
            },
            modelsDict: {
                Apple: ["iPhone 14", "iPhone 13", "iPad Pro", "iPad Air"],
                Samsung: ["Galaxy S23", "Galaxy S22", "Galaxy Tab S9"],
                Xiaomi: ["Xiaomi 13", "Redmi Note 12"],
                Microsoft: ["Surface Pro 9", "Surface Go 3"],
            },
            appointmentTypes: [
                { id: "in_store", label: "Réparation en magasin", description: "Votre appareil réparé en 30 minutes sur place !", price: 1000 },
                { id: "home_work", label: "Réparation à domicile ou au travail", description: "Intervention en moins d'une heure dans toute l'Île-de-France !", price: 600 },
                { id: "by_mail", label: "Réparation par correspondance", description: "Intervention rapide par voie de correspondance", price: 900 },
            ],
        };
    },
    computed: {
        brandList() {
            return this.brandsDict[this.selectedMaterial] || [];
        },
        modelList() {
            return this.modelsDict[this.selectedBrand] || [];
        },
        allPricesSet() {
            return this.selectedModels.every((model) => this.priceMap[model] >= 0);
        },
        validParts() {
            return this.parts.every((part) => part.type?.trim());
        },
    },
    methods: {
        confirmMode() {
            this.lockedMode = this.selectedMode;
            this.confirmedMode = false;
        },
        resetMode() {
            this.selectedMode = "Devis";
            this.confirmedMode = false;
            this.resetConfiguration();
        },
        addPart() {
            this.parts.push({ type: "" });
        },
        removePart(index) {
            if (this.parts.length > 1) {
                this.parts.splice(index, 1);
            }
        },
        selectMaterial(mat) {
            this.selectedMaterial = mat;
            this.selectedBrands = [];
            this.selectedBrand = null;
            this.selectedModels = [];
            this.priceMap = {};
            this.step = 2;
        },
        toggleBrand(brand) {
            const idx = this.selectedBrands.indexOf(brand);
            if (idx > -1) {
                this.selectedBrands.splice(idx, 1);
            } else {
                this.selectedBrands.push(brand);
            }
        },
        updateBrand() {
            this.selectedModels = [];
            this.priceMap = {};
        },
        modelSelected(model) {
            return this.selectedModels.includes(model);
        },
        toggleModel(model) {
            const idx = this.selectedModels.indexOf(model);
            if (idx > -1) {
                this.selectedModels.splice(idx, 1);
                delete this.priceMap[model];
            } else {
                this.selectedModels.push(model);
                if (this.lockedMode === "Rendez-vous") {
                    this.openPriceModal(model);
                }
            }
        },
        selectAllModels() {
            this.selectedModels = [...this.modelList];
            if (this.lockedMode === "Rendez-vous") {
                this.modelList.forEach((model) => {
                    if (!this.priceMap[model]) {
                        this.openPriceModal(model);
                    }
                });
            }
        },
        clearModels() {
            this.selectedModels = [];
            this.priceMap = {};
        },
        submitConfiguration() {
            this.configurationSubmitted = true;
        },
        resetConfiguration() {
            this.step = 1;
            this.parts = [{ type: "" }];
            this.appointmentType = null;
            this.selectedMaterial = null;
            this.selectedBrands = [];
            this.selectedBrand = null;
            this.selectedModels = [];
            this.priceMap = {};
            this.configurationSubmitted = false;
            this.lockedMode = null;
            this.selectedMode = "Devis";
        },
        openPriceModal(model) {
            this.modalModel = model;
            this.modalPrice = this.priceMap[model] || 0;
            new bootstrap.Modal(document.getElementById("priceModal")).show();
        },
        savePrice() {
            if (this.modalPrice >= 0) {
                this.priceMap[this.modalModel] = this.modalPrice;
                bootstrap.Modal.getInstance(document.getElementById("priceModal")).hide();
            }
        },
        getBrandImg(brand) {
            return `https://images.unsplash.com/photo-1505156868547-9b49f4df4e04?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=220&q=80&text=${encodeURIComponent(brand)}`;
        },
        getModelImg(model) {
            return `https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&h=220&q=80&text=${encodeURIComponent(model.split(" ")[0])}`;
        },
    },
}).mount('#app');