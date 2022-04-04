<template>
  <div>
    <div class="row">
      <div class="col-md-8 offset-md-2 border shadow">
        <div class="row mt-3 mb-3">
          <div class="col-md-2">
            <p>Partidas:</p>
          </div>
          <div class="col-md-2 offset-md-8">
            <button class="btn btn-primary float end">Crear</button>
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
                  <td>C&oacute;digo</td>
                  <td>Nombre</td>
                  <td>Acumula</td>
                  <td>Nivel</td>
                  <td>Padre</td>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="partida in partidas"
                  :key="partida.id"
                  @click="selecciona(partida.id)"
                >
                  <td>{{ partida.codigo }}</td>
                  <td>{{ partida.nombre }}</td>
                  <td>
                    <span v-if="partida.acumula" class="fa fa-check"></span>
                    <span v-else class="fa fa-times"></span>
                  </td>
                  <td>{{ partida.nivel }}</td>
                  <td>{{ partida.padre }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { getAllPartidas, getOneById } from "../../services/partida";
import Pagination from "../../components/pagination.vue";

export default {
  name: "Partidas",
  components: {
    Pagination,
  },
  data() {
    return {
      partidas: [],
      hasPrevious: false,
      hasNext: false,
      totalPages: 1,
      currentPage: 1,
      selectedPartida: null,
      method: 1,
    };
  },
  created() {
    this.queryData(1);
  },
  methods: {
    async queryData(page) {
      const partidas = await getAllPartidas(page);
      this.partidas = partidas.data.results;
      this.hasPrevious = partidas.data.has_previous;
      this.hasNext = partidas.data.has_next;
      this.totalPages = partidas.data.total_pages;
      this.currentPage = parseInt(partidas.data.current);
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
      const partida = await getOneById(id);
      this.selectedPartida = partida.data;
      this.method = 2;
    },
  },
};
</script>
