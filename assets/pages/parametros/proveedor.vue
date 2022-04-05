<template>
  <div>
    <div class="row">
      <div class="col-md-8 offset-md-2 border shadow">
        <div class="row m-3">
          <div class="col-md-2">
            <div>Proveedor</div>
            <loading :loading="loading" />
          </div>
          <div class="col-md-1 offset-md-9">
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
                      <th>RUC</th>
                      <th>Nombre</th>
                      <th>Contacto</th>
                      <td>Tel&eacute;fono</td>
                      <td>E-mail</td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="proveedor in proveedores"
                      :key="proveedor.id"
                      @click="selecciona(proveedor.id)"
                      data-bs-toggle="modal"
                      data-bs-target="#partidasModal"
                    >
                      <td>{{ proveedor.ruc }}</td>
                      <td>{{ proveedor.nombre }}</td>
                      <td>{{ proveedor.contacto }}</td>
                      <td>{{ proveedor.telefono }}</td>
                      <td>{{ proveedor.email }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
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
                  <h5 v-if="method === 1">Crea Proveedor</h5>
                  <h5 v-else>Edita Proveedor</h5>
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
              <div class="row mb-1">
                <div class="col-md-2 form-label col-form-label">
                  <label for="ruc">RUC</label>
                </div>
                <div class="col-md-10">
                  <input
                    type="text"
                    name="ruc"
                    id="ruc"
                    v-model="selectedProveedor.ruc"
                    class="form-control"
                    :class="rucError ? 'is-invalid' : ''"
                    placeholder="Ingrese el RUC del proveedor"
                  />
                  <div class="invalid-feedback" v-if="rucError">
                    {{ rucError }}
                  </div>
                </div>
              </div>
              <div class="row mb-1">
                <div class="col-md-2 form-label col-form-label">
                  <label for="nombre">Nombre</label>
                </div>
                <div class="col-md-10">
                  <input
                    type="text"
                    name="nombre"
                    id="nombre"
                    v-model="selectedProveedor.nombre"
                    class="form-control"
                    :class="nombreError ? 'is-invalid' : ''"
                    placeholder="Ingrese el nombre del proveedor"
                  />
                  <div class="invalid-feedback" v-if="nombreError">
                    {{ nombreError }}
                  </div>
                </div>
              </div>
              <div class="row mb-1">
                <div class="col-md-2 form-label col-form-label">
                  <label for="contacto">Contacto</label>
                </div>
                <div class="col-md-10">
                  <input
                    v-model="selectedProveedor.contacto"
                    type="text"
                    name="contacto"
                    id="contacto"
                    class="form-control"
                    placeholder="Ingrese el nombre del contacto"
                  />
                </div>
              </div>
              <div class="row mb-1">
                <div class="col-md-2 form-label col-form-label">
                  <label for="telefonno">Telefono</label>
                </div>
                <div class="col-md-10">
                  <input
                    v-model="selectedProveedor.telefono"
                    type="text"
                    name="telefono"
                    id="telefono"
                    class="form-control"
                    placeholder="Ingrese el telefono"
                  />
                </div>
              </div>
              <div class="row mb-1">
                <div class="col-md-2 form-label col-form-label">
                  <label for="telefonno">E-mail</label>
                </div>
                <div class="col-md-10">
                  <input
                    v-model="selectedProveedor.email"
                    type="email"
                    name="email"
                    id="email"
                    class="form-control"
                    placeholder="Ingrese el e-mail"
                  />
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-primary">Grabar</button>
              <button
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
                @click="cierraModal"
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
// Importing all scripts
import { getAllProveedores, getProveedor } from "../../services/proveedor";

//Importing all components
import Pagination from "../../components/pagination.vue";
import Loading from "../../components/loading.vue";

export default {
  name: "Proveedor",
  components: {
    Loading,
    Pagination,
  },
  data() {
    return {
      loading: false,
      proveedores: [],
      hasPrevious: false,
      hasNext: false,
      totalPages: 1,
      currentPage: 1,
      error: [],
      success: "",
      method: 1,
      selectedProveedor: {
        id: "",
        ruc: "",
        nombre: "",
        contacto: "",
        email: "",
        telefono: "",
      },
    };
  },
  created() {
    this.queryData(1);
  },
  computed: {
    rucError() {
      return this.error["ruc"];
    },
    nombreError() {
      return this.error["nombre"];
    },
  },
  methods: {
    async selecciona(id) {
      this.loading = true;
      const result = await getProveedor(id);
      this.selectedProveedor = result.data;
      this.method = 2;
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
    async queryData(page) {
      this.loading = true;
      const results = await getAllProveedores(page);
      this.proveedores = results.data.results;
      this.loading = false;
      this.partidas = results.data.results;
      this.hasPrevious = results.data.has_previous;
      this.hasNext = results.data.has_next;
      this.totalPages = results.data.total_pages;
      this.currentPage = parseInt(results.data.current);
      this.loading = false;
    },
    cierraModal() {
      this.selectedProveedor = {
        id: "",
        ruc: "",
        nombre: "",
        contacto: "",
        email: "",
        telefono: "",
      };
      this.success = "";
      this.error = [];
      this.method = 1;
    },
  },
};
</script>
