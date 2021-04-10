<template>
  <div>
    <h4 class="text-center">Gestión De Articulos</h4>
    <hr />
    <div class="row">
      <button
        @click="
          modificar = false;
          abrirModal();
        "
        type="button"
        class="btn btn-primary"
      >
        Agregar Nuevo
      </button>

      <!-- Modal -->
      <div class="modal" :class="{ mostrar: modal }">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">
                {{ tituloModal }}
              </h5>
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
                @click="cerrarModal()"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form>
                <div class="form-group">
                  <label for="exampleInputEmail1">Nombre:</label>
                  <input
                    v-model="articulo.nombre"
                    type="text"
                    class="form-control"
                    id="nombre"
                    placeholder="Nombre Del Articulo"
                  />

                  <label for="exampleInputEmail1">Descripción:</label>
                  <input
                    v-model="articulo.descripcion"
                    type="text"
                    class="form-control"
                    id="descripcion"
                    placeholder="Descripción Del Articulo"
                  />

                  <label for="exampleInputEmail1">Stock:</label>
                  <input
                    v-model="articulo.stock"
                    type="number"
                    class="form-control"
                    id="stock"
                    placeholder="Stock"
                  />
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-dismiss="modal"
                @click="cerrarModal()"
              >
                Cancelar
              </button>
              <button @click="guardar()" type="button" class="btn btn-success">Guardar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br />
    <div class="row">
      <table class="table table-striped">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Id</th>
            <th scope="col">Nombre</th>
            <th scope="col">Descripción</th>
            <th scope="col">Stock</th>
            <th scope="col" colspan="2" class="text-center">Acción</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="art in articulos" :key="art.id">
            <th scope="row">{{ art.id }}</th>
            <td>{{ art.nombre }}</td>
            <td>{{ art.descripcion }}</td>
            <td>{{ art.stock }}</td>
            <td>
              <button
                @click="
                  modificar = true;
                  abrirModal(art);
                "
                class="btn btn-warning"
              >
                Editar
              </button>
            </td>
            <td>
              <button @click="eliminar(art.id)" class="btn btn-danger">
                Eliminar
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      articulo: {
        nombre: "",
        descripcion: "",
        stock: "",
      },
      id:0,
      modificar: true,
      modal: 0,
      tituloModal: "",
      articulos: [],
    };
  },
  methods: {
    async listar() {
      const res = await axios.get("articulos");
      this.articulos = res.data;
    },
    async eliminar(id) {
      const res = await axios.delete("/articulos/" + id);
      this.listar();
    },
    async guardar() {
      if (this.modificar) {
        const res = await axios.put("/articulos/" + this.id,this.articulo);
      } else {
        const res = await axios.post("/articulos",this.articulo);
      }
      this.cerrarModal();
      this.listar();
    },
    abrirModal(data = {}) {
      this.modal = 1;
      if (this.modificar) {
        this.id=data.id;
        this.tituloModal = "Modificar Articulo";
        this.articulo.nombre = data.nombre;
        this.articulo.descripcion = data.descripcion;
        this.articulo.stock = data.stock;
      } else {
        this.id=0;
        this.tituloModal = "Crear Articulo";
        this.articulo.nombre = "";
        this.articulo.descripcion = "";
        this.articulo.stock = 1;
      }
    },
    cerrarModal() {
      this.modal = 0;
    },
  },
  created() {
    this.listar();
  },
};
</script>
<style>
.mostrar {
  display: list-item;
  opacity: 1;
  background: rgba(49, 45, 73, 0.638);
}
</style>