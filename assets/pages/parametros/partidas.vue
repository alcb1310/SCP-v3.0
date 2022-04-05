<template>
  <div>
    <div class="row">
      <div class="col-md-8 offset-md-2 border shadow">
        <div class="row mt-3 mb-3">
          <div class="col-md-2">
            <p>Partidas:</p>
            <loading :loading="loading" />
          </div>
          <div class="col-md-2 offset-md-8">
            <button
              class="btn btn-primary float end"
              data-bs-toggle="modal"
              data-bs-target="#partidasModal"
            >
              Crear
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <pagination
              :currentPage="currentPage"
              :hasNext="hasNext"
              :hasPrevious="hasPrevious"
              :maxPages="totalPages"
              @pager="setPage"
            />
          </div>
        </div>
        <div class="row">
          <div class="col">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>C&oacute;digo</th>
                  <th>Nombre</th>
                  <th>Acumula</th>
                  <th>Nivel</th>
                  <th>Padre</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="partida in partidas"
                  :key="partida.id"
                  @click="selecciona(partida.id)"
                  data-bs-toggle="modal"
                  data-bs-target="#partidasModal"
                >
                  <td>{{ partida.codigo }}</td>
                  <td>{{ partida.nombre }}</td>
                  <td>
                    <span v-if="partida.acumula" class="fa fa-check"></span>
                    <span v-else class="fa fa-times"></span>
                  </td>
                  <td>{{ partida.nivel }}</td>
                  <td>{{ partida.codigopadre }}</td>
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
      id="partidasModal"
      data-bs-backdrop="static"
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
                    Crear partida
                  </h5>
                  <h5
                    class="modal-title"
                    id="staticBackdropLabel"
                    v-if="method !== 1"
                  >
                    Modificar partida
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
              ></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-2 form-label col-form-label">
                  <label for="codigo">C&oacute;digo</label>
                </div>
                <div class="col-md-10">
                  <input
                    type="text"
                    name="codigo"
                    id="codigo"
                    v-model="selectedPartida.codigo"
                    class="form-control"
                    :class="codigoError ? 'is-invalid' : ''"
                    placeholder="Ingrese el código de la partida"
                  />
                  <div class="invalid-feedback" v-if="codigoError">
                    {{ codigoError }}
                  </div>
                </div>
              </div>
              <div class="row mt-1">
                <div class="col-md-2 form-label col-form-label">
                  <label for="nombre">Nombre</label>
                </div>
                <div class="col-md-10">
                  <input
                    type="text"
                    name="nombre"
                    id="nombre"
                    v-model="selectedPartida.nombre"
                    class="form-control"
                    :class="nombreError ? 'is-invalid' : ''"
                    placeholder="Ingrese el Nombre de la partida"
                  />
                  <div class="invalid-feedback" v-if="nombreError">
                    {{ nombreError }}
                  </div>
                </div>
              </div>
              <div class="row mt-1">
                <div class="col-md-2 form-label-col-form-label">
                  <label for="nivel">Nivel</label>
                </div>
                <div class="col-md-10">
                  <input
                    type="number"
                    class="form-control"
                    name="nivel"
                    id="nivel"
                    :class="nivelError ? 'is-invalid' : ''"
                    v-model="selectedPartida.nivel"
                    placeholder="Ingrese un nivel"
                  />
                  <div class="invalid-feedback" v-if="nivelError">
                    {{ nivelError }}
                  </div>
                </div>
              </div>
              <div class="row mt-1">
                <div class="col-md-2 form-label col-form-label">
                  <label for="padre">Padre</label>
                </div>
                <div class="col-md-10">
                  <select
                    id="padre"
                    name="padre"
                    v-model="selectedPartida.padre"
                    class="form-select"
                  >
                    <option value="">--- Seleccione una Partida ---</option>
                    <option
                      :value="partida.id"
                      v-for="partida in partidasAcumula"
                      :key="partida.id"
                    >
                      {{ partida.nombre }}
                    </option>
                  </select>
                </div>
              </div>
              <div class="row mt-1">
                <div class="col-md-10 offset-md-2">
                  <input
                    type="checkbox"
                    id="acumula"
                    name="acumula"
                    v-model="selectedPartida.acumula"
                    class="form-check-input"
                  />
                  <label for="acumula" class="form-label ms-2 col-form-label">
                    Acumula
                  </label>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button
                type="submit"
                class="btn btn-primary"
                data-bs-dismiss="modal"
                @click.prevent="grabarPartida"
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
import {
  getAllPartidas,
  getOneById,
  getAllAcumula,
  add,
  edit,
} from "../../services/partida";
import Pagination from "../../components/pagination.vue";
import Loading from "../../components/loading.vue";

export default {
  name: "Partidas",
  components: {
    Pagination,
    Loading,
  },
  data() {
    return {
      partidas: [],
      hasPrevious: false,
      hasNext: false,
      totalPages: 1,
      currentPage: 1,
      selectedPartida: {
        codigo: "",
        nombre: "",
        nivel: "",
        acumula: "",
        padre: "",
        codigopadre: "",
      },
      method: 1,
      partidasAcumula: [],
      result: null,
      loading: false,
      error: [],
      success: "",
    };
  },
  created() {
    this.queryData(1);
  },
  methods: {
    isInvalid() {
      let hasErrors = false;
      if (
        this.selectedPartida.codigo === "" ||
        this.selectedPartida.codigo === null
      ) {
        this.error["codigo"] = "Ingrese un codigo";
        hasErrors = true;
      }
      if (
        this.selectedPartida.nombre === "" ||
        this.selectedPartida.nombre === null
      ) {
        this.error["nombre"] = "Ingrese un nombre para la partida";
        hasErrors = true;
      }
      if (
        this.selectedPartida.nivel === "" ||
        this.selectedPartida.nivel === null ||
        isNaN(this.selectedPartida.nivel)
      ) {
        this.error["nivel"] = "El nivel debe ser un numero";
        hasErrors = true;
      }

      return hasErrors;
    },
    async grabarPartida() {
      if (this.isInvalid()) {
        return;
      }
      this.error = [];
      this.loading = true;
      try {
        if (this.method === 1) {
          const result = await add(this.selectedPartida);
          this.success = "Partida creada satisfactoriamente";
        } else {
          const result = await edit(this.selectedPartida);
          this.cierraModal();
          this.success = "Partida actualizada satisfactoriamente";
        }
        // this.result = result;
      } catch (err) {
        // console.error(err);
        this.error = err.response.data;
      }
      const partidas = await getAllPartidas(this.currentPage);
      this.partidas = partidas.data.results;
      this.hasPrevious = partidas.data.has_previous;
      this.hasNext = partidas.data.has_next;
      this.totalPages = partidas.data.total_pages;
      this.currentPage = parseInt(partidas.data.current);
      this.loading = false;
    },
    cierraModal() {
      this.selectedPartida = {
        codigo: "",
        nombre: "",
        nivel: "",
        acumula: "",
        padre: "",
      };
      this.success = "";
      this.error = [];
      this.method = 1;
    },
    async queryData(page) {
      this.loading = true;
      const partidas = await getAllPartidas(page);
      const partidaAcumula = await getAllAcumula();

      this.partidas = partidas.data.results;
      this.hasPrevious = partidas.data.has_previous;
      this.hasNext = partidas.data.has_next;
      this.totalPages = partidas.data.total_pages;
      this.currentPage = parseInt(partidas.data.current);
      this.partidasAcumula = partidaAcumula.data;
      this.loading = false;
    },
    setPage(page) {
      if (page === 0) {
        page = this.currentPage + 1;
      } else if (page === -1) {
        page = this.currentPage - 1;
      }
      this.queryData(page);
    },
    async selecciona(id) {
      this.loading = true;
      const partida = await getOneById(id);
      this.selectedPartida = partida.data;
      this.selectedPartida.id = id;
      this.method = 2;

      this.loading = false;
    },
  },
  computed: {
    codigoError() {
      return this.error.codigo;
    },
    nombreError() {
      return this.error.nombre;
    },
    nivelError() {
      return this.error.nivel;
    },
  },
};
</script>
