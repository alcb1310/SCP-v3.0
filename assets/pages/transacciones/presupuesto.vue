<template>
  <modal-presupuestos :visible="modalVisible" @cierraModal="doClose" />

  <div class="row">
    <div class="col-md-8 offset-md-2 border shadow">
      <div class="row mt-3 mb-3">
        <div class="col-md-2">
          <p>Presupuesto</p>
          <loading :loading="isLoading" />
          <pagination
            :currentPage="currentPage"
            :hasNext="hasNext"
            :hasPrevious="hasPrevious"
            :maxPages="maxPages"
            @pager="changePage"
          />
        </div>
        <div class="col-md-2 offset-md-8">
          <button class="btn btn-primary float end" @click="openModal">
            Crear
          </button>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col m-3">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th rowspan="2" class="text-center align-middle">Obra</th>
            <th rowspan="2" class="text-center align-middle">Codigo</th>
            <th colspan="3" class="text-center align-middle">Inicial</th>
            <th colspan="3" class="text-center align-middle">Por Gastar</th>
            <th rowspan="2" class="text-center align-middle">Presupuesto</th>
          </tr>
          <tr>
            <th class="text-center align-middle">Cantiadad</th>
            <th class="text-center align-middle">Unitario</th>
            <th class="text-center align-middle">Total</th>
            <th class="text-center align-middle">Cantiadad</th>
            <th class="text-center align-middle">Unitario</th>
            <th class="text-center align-middle">Total</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="presupuesto in presupuestos" :key="presupuesto.id">
            <td>{{ presupuesto.obra.nombre }}</td>
            <td>{{ presupuesto.partida.nombre }}</td>
            <td class="text-end">{{ format(presupuesto.cantini) }}</td>
            <td class="text-end">{{ format(presupuesto.costoini) }}</td>
            <td class="text-end">{{ format(presupuesto.totalini) }}</td>
            <td class="text-end">{{ format(presupuesto.porgascan) }}</td>
            <td class="text-end">{{ format(presupuesto.porgasuni) }}</td>
            <td class="text-end">{{ format(presupuesto.porgastot) }}</td>
            <td class="text-end">{{ format(presupuesto.presactu) }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import { getAllPresupuestos } from "../../services/presupuesto";

import formatNumber from "../../helper/format-number";

import Pagination from "../../components/pagination.vue";
import Loading from "../../components/loading.vue";
import ModalPresupuestos from "../../components/modal-presupuesto.vue";

export default {
  name: "Presupuesto",
  components: {
    Pagination,
    Loading,
    ModalPresupuestos,
  },
  data() {
    return {
      presupuestos: [],
      currentPage: 1,
      maxPages: 0,
      hasNext: false,
      hasPrevious: false,
      isLoading: false,
      modalVisible: false,
    };
  },
  async created() {
    this.getPresupuestos(1);
  },
  methods: {
    async getPresupuestos(page) {
      this.isLoading = true;
      const result = await getAllPresupuestos(page);
      this.maxPages = result.data.total_pages;
      this.hasNext = result.data.has_next;
      this.hasPrevious = result.data.has_previous;
      this.presupuestos = result.data.results;
      this.isLoading = false;
    },
    format(number) {
      if (number) {
        return formatNumber(number);
      }
      return null;
    },
    changePage(event) {
      if (event === 0) {
        this.currentPage++;
      } else if (event === -1) {
        this.currentPage--;
      } else {
        this.currentPage = event;
      }
      this.getPresupuestos(this.currentPage);
    },
    openModal() {
      this.modalVisible = true;
    },
    doClose(event) {
      this.modalVisible = false;
    },
  },
};
</script>
