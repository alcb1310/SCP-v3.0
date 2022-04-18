import axios from "axios";

/**
 *
 * @returns Promise
 */
export function getAllObras() {
  return axios.get("/api/obras");
}

/**
 *
 * @param Integer id
 * @returns Promise
 */
export function getOneObra(id) {
  return axios.get(`/api/obras/${id}`);
}

export function addObra(obra) {
  var params = new URLSearchParams();
  params.append("nombre", obra.nombre);
  params.append("casas", obra.casas);
  params.append("activo", obra.activo);

  return axios.post("/api/obras", params);
}

export function editObra(obra) {
  var params = new URLSearchParams();
  params.append("nombre", obra.nombre);
  params.append("casas", obra.casas);
  params.append("activo", obra.activo);

  return axios.put(`/api/obras/${obra.id}`, params);
}

/**
 *
 * @returns Promise
 */
export function getAllActive() {
  return axios.get("/api/obras?activo=true");
}
