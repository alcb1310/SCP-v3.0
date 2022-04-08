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

/**
 *
 * @param int id
 * @returns Promise
 */
export function getProveedor(id) {
  console.log(id);
  return axios.get(`/api/proveedores/${id}`);
}

/**
 *
 * @param Object proveedor
 * @returns Promise
 */
export function addProveedor(proveedor) {
  var params = new URLSearchParams();
  params.append("ruc", proveedor.ruc);
  params.append("nombre", proveedor.nombre);
  params.append("contacto", proveedor.contacto);
  params.append("telefono", proveedor.telefono);
  params.append("email", proveedor.email);

  return axios.post("/api/proveedores-add", params);
}

/**
 *
 * @param Object proveedor
 * @returns Promise
 */
export function editProveedor(proveedor) {
  var params = new URLSearchParams();
  params.append("ruc", proveedor.ruc);
  params.append("nombre", proveedor.nombre);
  params.append("contacto", proveedor.contacto);
  params.append("telefono", proveedor.telefono);
  params.append("email", proveedor.email);

  return axios.post(`/api/proveedores-edit/${proveedor.id}`, params);
}
