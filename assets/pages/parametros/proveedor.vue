<template>
  <div class="row">
    <div class="col-md-8 offset-md-2 border shadow">
      <div class="row m-3">
        <div class="col-md-2">
          <div>Proveedor</div>
          <loading :loading="loading" />
        </div>
        <div class="col-md-1 offset-md-9">
          <button class="btn btn-primary">Crear</button>
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
                  <tr v-for="proveedor in proveedores" :key="proveedor.id">
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
</template>

<script>
// Importing all scripts
import { getAllProveedores } from "../../services/proveedor";

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
    };
  },
  created() {
    this.queryData(1);
  },
  methods: {
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
  },
};
</script>
