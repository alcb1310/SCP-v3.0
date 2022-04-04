import axios from "axios";

export function getAllPartidas(page) {
  return axios.get("/api/partidas", {
    params: { page },
  });
}

export function getOneById(id) {
  return axios.get("/api/partidas/" + id);
}
