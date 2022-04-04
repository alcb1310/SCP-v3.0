<template>
  <div>
    <nav
      class="navbar navbar-expand-lg navbar-dark"
      style="background: rgb(0, 102, 153)"
    >
      <div class="container-fluid">
        <a class="navbar-brand" @click.prevent="open('')"
          >Sistema Control Presupuestario</a
        >
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNavDropdown"
          aria-controls="navbarNavDropdown"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle active"
                href="#"
                id="navbarDropdownMenuLink"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                Transacciones
              </a>
              <ul
                class="dropdown-menu"
                aria-labelledby="navbarDropdownMenuLink"
              >
                <li>
                  <a class="dropdown-item" @click.prevent="open('obra')"
                    >Obra</a
                  >
                </li>
                <li>
                  <a class="dropdown-item" @click.prevent="open('presupuesto')"
                    >Presupuesto</a
                  >
                </li>
                <li>
                  <a class="dropdown-item" @click.prevent="open('factura')"
                    >Factura</a
                  >
                </li>
                <li>
                  <a class="dropdown-item" @click.prevent="open('cierre_mes')"
                    >Cierre mes</a
                  >
                </li>
                <li>
                  <a class="dropdown-item" @click.prevent="open('avance_obra')"
                    >Avance Obra</a
                  >
                </li>
                <li>
                  <a class="dropdown-item" @click.prevent="open('flujo')"
                    >Flujo</a
                  >
                </li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle active"
                href="#"
                id="navbarDropdownMenuLink"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                Reportes
              </a>
              <ul
                class="dropdown-menu"
                aria-labelledby="navbarDropdownMenuLink"
              >
                <li>
                  <a class="dropdown-item" @click.prevent="open('cuadre')"
                    >Cuadre</a
                  >
                </li>
                <li>
                  <a class="dropdown-item" @click.prevent="open('gastado_mes')"
                    >Gastado mes</a
                  >
                </li>
                <li>
                  <a
                    class="dropdown-item"
                    @click.prevent="open('control_actual')"
                    >Control Actual</a
                  >
                </li>
                <li>
                  <a
                    class="dropdown-item"
                    @click.prevent="open('control_fechas')"
                    >Control por Fechas</a
                  >
                </li>
                <li>
                  <a
                    class="dropdown-item"
                    @click.prevent="open('gastado_mensual')"
                    >Gastado Mensual</a
                  >
                </li>
                <li>
                  <a
                    class="dropdown-item"
                    @click.prevent="open('presupuesto_ejecutado')"
                    >Presupuesto vs. Ejecutado</a
                  >
                </li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle active"
                href="#"
                id="navbarDropdownMenuLink"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                Par&aacute;metros
              </a>
              <ul
                class="dropdown-menu"
                aria-labelledby="navbarDropdownMenuLink"
              >
                <li>
                  <a class="dropdown-item" @click.prevent="open('proveedor')"
                    >Proveedor</a
                  >
                </li>
                <li>
                  <a class="dropdown-item" @click.prevent="open('partidas')"
                    >Partidas</a
                  >
                </li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle active"
                href="#"
                id="navbarDropdownMenuLink"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                Usuarios
              </a>
              <ul
                class="dropdown-menu"
                aria-labelledby="navbarDropdownMenuLink"
              >
                <li>
                  <a
                    class="dropdown-item"
                    @click.prevent="open('cambio_contrasena')"
                    >Cambio Contrase&ntilde;a</a
                  >
                </li>
                <li>
                  <a
                    class="dropdown-item"
                    @click.prevent="open('nuevo_usuario')"
                    >Crear usuario</a
                  >
                </li>
                <li>
                  <a
                    class="dropdown-item"
                    @click.prevent="open('resetea_contrasena')"
                    >Resetear Contrase&ntilde;a</a
                  >
                </li>
              </ul>
            </li>
            <li class="nav-item float-end">
              <a class="nav-link active" href="/logout">Salir</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="row mt-3">
      <div class="offset-md-2">
        <p style="color: green">Bienvenido {{ user.nombre }}</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "NavBar",
  props: {
    user: {
      type: Object,
      required: true,
    },
  },
  methods: {
    open(data) {
      this.$emit("menuSelected", data);
    },
  },
};
</script>
