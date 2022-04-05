import axios from "axios";

/**
 *
 * @returns Promise
 */
export function getAllProveedores(page) {
  return axios.get("/api/proveedores", {
    params: { page },
  });
}
