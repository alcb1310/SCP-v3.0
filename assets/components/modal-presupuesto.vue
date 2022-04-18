<template>
  <div class="overlay" :style="isVisible ? 'display: block' : 'display: none'">
    >
    <div class="my-modal">
      <h5>Presupuesto</h5>
      <div class="row">
        <div class="col-md-2 form-label col-form-label">
          <label for="obra">Obra</label>
        </div>
        <div class="col-md-10">
          <select
            name="obra"
            id="obra"
            class="form-select"
            v-model="selectedObra"
          >
            <option value="">--- Seleccione una obra ---</option>
            <option v-for="obra in obras" :key="obra.id" value="obra.id">
              {{ obra.nombre }}
            </option>
          </select>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2 form-label col-form-label">
          <label for="partida">Partida</label>
        </div>
        <div class="col-md-10">
          <select
            name="partida"
            id="partida"
            v-model="selectedPartida"
            class="form-select"
          >
            <option value="">--- Seleccione una partida ---</option>
            <option
              v-for="partida in partidas"
              :key="partida.id"
              value="partida.id"
            >
              {{ partida.nombre }}
            </option>
          </select>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2 form-label col-form-label">
          <label for="cantidad">Cantidad</label>
        </div>
        <div class="col-md-10">
          <input
            type="number"
            name="cantidad"
            id="cantidad"
            v-model.number="cantidad"
            class="form-control"
          />
        </div>
      </div>
      <div class="row">
        <div class="col-md-2 form-label col-form-label">
          <label for="unitario">Unitario</label>
        </div>
        <div class="col-md-10">
          <input
            type="number"
            name="unitario"
            id="unitario"
            v-model.number="unitario"
            class="form-control"
          />
        </div>
      </div>
      <div class="row">
        <div class="col-md-2 form-label col-form-label">
          <label for="total">Total</label>
        </div>
        <div class="col-md-10">
          <input
            type="number"
            name="total"
            id="total"
            disabled
            class="form-control"
            v-model="total"
          />
        </div>
      </div>
      <button class="btn btn-primary">Grabar</button>
      <button class="btn btn-secondary" @click="closeModal">Cerrar</button>
    </div>
  </div>
</template>

<script>
import { getAllActive } from "../services/obra";
import { getAllNoAcumula } from "../services/partida";

export default {
  name: "ModalPresupuesto",
  data() {
    return {
      test: "working",
      obras: [],
      partidas: [],
      selectedObra: "",
      selectedPartida: "",
      cantidad: 0,
      unitario: 0,
      total: 0,
    };
  },
  props: {
    visible: {
      type: Boolean,
      default: false,
    },
  },
  async created() {
    let result;

    result = await getAllActive();
    this.obras = result.data;

    result = await getAllNoAcumula();
    this.partidas = result.data;
  },
  methods: {
    closeModal() {
      return this.$emit("cierraModal", false);
    },
  },
  computed: {
    isVisible() {
      return this.visible;
    },
  },
};
</script>

<style lang="scss" scoped>
.overlay {
  position: absolute;
  top: 0;
  bottom: 0;
  right: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: #000;
}

.my-modal {
  background: orange;
  max-width: 600px;
  margin: 0 auto;
  padding: 1.5rem;
}
//
</style>
