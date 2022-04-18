import axios from "axios";

export function getAllPresupuestos(page) {
  return axios.get("/api/presupuestos", {
    params: {
      page,
    },
  });
}
