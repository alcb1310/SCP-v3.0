import axios from "axios";

/**
 *
 * @param integer page
 * @returns Promise
 */
export function getAllPartidas(page) {
  return axios.get("/api/partidas", {
    params: { page },
  });
}

/**
 *
 * @param integer id
 * @returns Promise
 */
export function getOneById(id) {
  return axios.get("/api/partidas/" + id);
}

/**
 *
 * @returns Promise
 */
export function getAllAcumula() {
  return axios.get("/api/partidas-acumula");
}

/**
 *
 * @param object partidas
 * @returns Promise
 */
export function add(partida) {
  var params = new URLSearchParams();
  params.append("codigo", partida.codigo);
  params.append("nombre", partida.nombre);
  params.append("acumula", partida.acumula);
  params.append("nivel", partida.nivel);
  params.append("padre", partida.padre);

  return axios.post("/api/partidas-add", params);
}

/**
 *
 * @param object partidas
 * @returns Promise
 */
export function edit(partida) {
  var params = new URLSearchParams();
  params.append("codigo", partida.codigo);
  params.append("nombre", partida.nombre);
  params.append("acumula", partida.acumula);
  params.append("nivel", partida.nivel);
  params.append("padre", partida.padre);

  return axios.post(`/api/partidas-edit/${partida.id}`, params);
}
