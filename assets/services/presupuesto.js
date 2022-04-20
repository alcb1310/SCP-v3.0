import axios from "axios";

export function getAllPresupuestos(page) {
  return axios.get("/api/presupuestos", {
    params: {
      page,
    },
  });
}

export function addPresupuesto(presupuesto) {
  var params = new URLSearchParams();
  params.append("obra", presupuesto.obra);
  params.append("partida", presupuesto.partida);
  params.append("cantidad", presupuesto.cantidad);
  params.append("unitario", presupuesto.unitario);
  params.append("total", presupuesto.total);

  return axios.post("/api/presupuestos", params);
}
