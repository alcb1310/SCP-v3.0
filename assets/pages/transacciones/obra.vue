<template>
  <div>
    <div class="row">
      <div class="col-md-8 offset-md-2 border shadow">
        <div class="row mt-3 mb-3">
          <div class="col-md-2">
            <p>Obras:</p>
            <loading :loading="loading" />
          </div>
          <div class="col-md-2 offset-md-8">
            <button
              class="btn btn-primary float end"
              data-bs-toggle="modal"
              data-bs-target="#obrasModal"
            >
              Crear
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <td>Nombre</td>
                  <td>Casas</td>
                  <td>Activo</td>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="obra in obras"
                  :key="obra.id"
                  data-bs-toggle="modal"
                  data-bs-target="#obrasModal"
                  @click="seleccionaObra(obra.id)"
                >
                  <td>{{ obra.nombre }}</td>
                  <td>{{ obra.casas }}</td>
                  <td>
                    <span
                      class="fa"
                      :class="obra.activo ? 'fa-check' : 'fa-times'"
                    ></span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div
      class="modal fade"
      id="obrasModal"
      data-bs-keyboard="false"
      tabindex="-1"
      aria-labelledby="staticBackdropLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <form action="/api/partidas-add" method="post">
          <div class="modal-content">
            <div class="modal-header">
              <div class="row">
                <div class="col">
                  <h5
                    class="modal-title"
                    id="staticBackdropLabel"
                    v-if="method === 1"
                  >
                    Crear obra
                  </h5>
                  <h5 class="modal-title" id="staticBackdropLabel" v-else>
                    Modificar obra
                  </h5>
                </div>
              </div>

              <div class="row">
                <div class="col">
                  <div class="alert alert-success" role="alert" v-if="success">
                    {{ success }}
                  </div>
                </div>
              </div>

              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
                @click="cierraModal"
              ></button>
            </div>
            <div class="modal-body">
              <div class="row mb-3">
                <div class="col-md-2 form-label col-form-label">
                  <label for="obra">Nombre</label>
                </div>
                <div class="col-md-10">
                  <input
                    type="text"
                    name="obra"
                    id="obra"
                    class="form-control"
                    v-model="selectedObra.nombre"
                    :class="nombreError ? 'is-invalid' : ''"
                    placeholder="Ingrese el nombre de la obra"
                  />
                  <div class="invalid-feedback" v-if="nombreError">
                    {{ nombreError }}
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-md-2 form-label col-form-label">
                  <label for="casas">Casas</label>
                </div>
                <div class="col-md-10">
                  <input
                    type="number"
                    name="casas"
                    id="casas"
                    class="form-control"
                    v-model="selectedObra.casas"
                    :class="casasError ? 'is-invalid' : ''"
                    placeholder="Ingrese el numero de casas"
                  />
                  <div class="invalid-feedback" v-if="casasError">
                    {{ casasError }}
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="offset-md-2">
                  <div class="form-check">
                    <input
                      class="form-check-input"
                      type="checkbox"
                      v-model="selectedObra.activo"
                      id="activo"
                      name="activo"
                    />
                    <label class="form-check-label" for="activo">
                      Activo
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button
                type="submit"
                class="btn btn-primary"
                @click.prevent="grabaObra"
              >
                Grabar
              </button>
              <button
                type="button"
                class="btn btn-secondary"
                @click="cierraModal"
                data-bs-dismiss="modal"
              >
                Cerrar
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import Loading from "../../components/loading.vue";

import {
  getAllObras,
  getOneObra,
  addObra,
  editObra,
} from "../../services/obra";

export default {
  name: "Obra",
  components: {
    Loading,
  },
  data() {
    return {
      loading: true,
      obras: [],
      error: [],
      success: "",
      selectedObra: {
        id: "",
        nombre: "",
        casas: 0,
        activo: false,
      },
      method: 1,
    };
  },
  created() {
    this.cargaDatos();
  },
  computed: {
    nombreError() {
      return this.error.nombre;
    },
    casasError() {
      return this.error.casas;
    },
  },
  methods: {
    isInvalid() {
      let inValidData = false;

      if (
        this.selectedObra.nombre === "" ||
        this.selectedObra.nombre === null
      ) {
        inValidData = true;
        this.error["nombre"] = "Ingrese un nombre de obra";
      }

      if (
        this.selectedObra.casas === 0 ||
        this.selectedObra.casas === "" ||
        this.selectedObra === null
      ) {
        inValidData = true;
        this.error["casas"] = "Numero de casas no puede ser 0";
      }

      return inValidData;
    },
    cierraModal() {
      this.error = [];
      this.success = "";
      this.selectedObra = {
        id: "",
        nombre: "",
        casas: 0,
        activo: false,
      };
      this.method = 1;
    },
    async cargaDatos() {
      this.loading = true;
      this.obras = [];
      const result = await getAllObras();
      this.obras = result.data;
      this.loading = false;
    },
    async seleccionaObra(obra) {
      const result = await getOneObra(obra);
      this.selectedObra = result.data;
      this.method = 2;
    },
    async grabaObra() {
      this.error = [];
      this.success = "";
      if (this.isInvalid()) {
        return;
      }
      this.loading = true;
      try {
        if (this.method === 1) {
          const result = await addObra(this.selectedObra);
          console.log(result);
          this.success = "Obra creada exitosamente";
        } else {
          const result = await editObra(this.selectedObra);
          console.log(result);
          this.success = "Obra actualizada exitosamente";
        }
      } catch (err) {
        console.error(err.response.data);
        this.error = err.response.data;
      }
      this.cargaDatos();
      this.loading = false;
    },
  },
};
</script>
