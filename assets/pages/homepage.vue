<template>
  <nav-bar :user="user" @menuSelected="select" />
  <div v-if="selectedMenu">
    <!-- Transacciones start -->
    <obra v-if="selectedMenu === 'obra'" />
    <presupuesto v-if="selectedMenu === 'presupuesto'" />
    <factura v-if="selectedMenu === 'factura'" />
    <cierre-mes v-if="selectedMenu === 'cierre_mes'" />
    <avance-obra v-if="selectedMenu === 'avance_obra'" />
    <flujo v-if="selectedMenu === 'flujo'" />
    <!-- Transacciones end -->

    <!-- Reportes start -->
    <cuadre v-if="selectedMenu === 'cuadre'" />
    <gastado-mes v-if="selectedMenu === 'gastado_mes'" />
    <control-actual v-if="selectedMenu === 'control_actual'" />
    <control-fechas v-if="selectedMenu === 'control_fechas'" />
    <gastado-mensual v-if="selectedMenu === 'gastado_mensual'" />
    <presupuesto-ejecutado v-if="selectedMenu === 'presupuesto_ejecutado'" />
    <!-- Reportes end -->

    <!-- Parametros start -->
    <proveedor v-if="selectedMenu === 'proveedor'" />
    <partidas v-if="selectedMenu === 'partidas'" />
    <!-- Parametros end -->

    <!-- Usuarios start -->
    <cambio-contrasena v-if="selectedMenu === 'cambio_contrasena'" />
    <usuario v-if="selectedMenu === 'nuevo_usuario'" />
    <resetea-contrasena v-if="selectedMenu === 'resetea_contrasena'" />
    <!-- Usuarios end -->
  </div>
  <img
    src="/images/implantacion.webp"
    alt="Implantacion Cantagua II"
    class="responsive"
    :width="max_width"
    v-else
  />
</template>

<script>
import NavBar from "../components/nav-bar.vue";
import { getNombreDelUsuario } from "../services/user";

// Transacciones start
import Obra from "./transacciones/obra.vue";
import Presupuesto from "./transacciones/presupuesto.vue";
import Factura from "./transacciones/factura.vue";
import CierreMes from "./transacciones/cierre-mes.vue";
import AvanceObra from "./transacciones/avance-obra.vue";
import Flujo from "./transacciones/flujo.vue";
// Transacciones end

// Reportes start
import Cuadre from "./reportes/cuadre.vue";
import GastadoMes from "./reportes/gastado-mes.vue";
import ControlActual from "./reportes/control-actual.vue";
import ControlFechas from "./reportes/control-fechas.vue";
import GastadoMensual from "./reportes/gastado-mensual.vue";
import PresupuestoEjecutado from "./reportes/presupuesto-ejecutado.vue";
// Reportes end

// Parametros start
import Proveedor from "./parametros/proveedor.vue";
import Partidas from "./parametros/partidas.vue";
// Parametros end

// Usuarios start
import CambioContrasena from "./usuarios/cambio-contrasena.vue";
import Usuario from "./usuarios/nuevo-usuario.vue";
import ReseteaContrasena from "./usuarios/resetea-contrasena.vue";
// Usuarios end

export default {
  name: "HomePage",
  components: {
    NavBar,
    Obra,
    Presupuesto,
    CierreMes,
    Factura,
    AvanceObra,
    Flujo,
    Proveedor,
    Partidas,
    Cuadre,
    GastadoMes,
    ControlActual,
    ControlFechas,
    GastadoMensual,
    PresupuestoEjecutado,
    CambioContrasena,
    Usuario,
    ReseteaContrasena,
  },
  data() {
    return {
      user: {},
      selectedMenu: "",
      max_width: "250px",
    };
  },
  async created() {
    const userData = await getNombreDelUsuario(window.username);
    this.user = userData.data;
  },
  methods: {
    select(itemName) {
      this.selectedMenu = itemName;
    },
  },
};
</script>
