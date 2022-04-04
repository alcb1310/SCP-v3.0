import axios from "axios";

/**
 * Obtiene la informacion del usuario
 *
 * @param string username
 * @returns Promise
 */
export function getNombreDelUsuario(username) {
  return axios.get("/api/users", {
    params: { username },
  });
}
