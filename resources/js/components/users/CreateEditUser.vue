<template>
  <div>
    <div
      class="modal fade"
      id="formUserModal"
      tabindex="-1"
      aria-labelledby="formUserModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="formUserModalLabel">
              Gestionar usuario
            </h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              @click="(editar = false), resetData()"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label for="nombre">Nombre</label>
                  <input
                    type="text"
                    class="form-control"
                    id="nombre"
                    v-model="formUser.name"
                  />
                </div>
                <div class="form-group col-md-4">
                  <label for="name">Apellidos</label>
                  <input
                    type="text"
                    class="form-control"
                    id="name"
                    v-model="formUser.last_name"
                  />
                </div>
                <div class="form-group col-md-4">
                  <label for="email">Email</label>
                  <input
                    type="text"
                    class="form-control"
                    id="email"
                    v-model="formUser.email"
                  />
                </div>
                <div class="form-group col-md-4">
                  <label for="phone">Celular</label>
                  <input
                    type="number"
                    class="form-control"
                    id="phone"
                    v-model="formUser.phone"
                  />
                </div>
                <div class="form-group col-md-4">
                  <label for="type_document">Tipo Documento</label>
                  <select
                    name="type_document"
                    id="type_document"
                    class="custom-select"
                    v-model="formUser.type_document"
                  >
                    <option value="0" disabled>--Seleccionar--</option>
                    <option
                      v-for="(d, key) in type_documents"
                      :key="key"
                      :value="key"
                    >
                      {{ d }}
                    </option>
                  </select>
                </div>
                <div class="form-group col-md-4">
                  <label for="document">Nro. Documento</label>

                  <input
                    type="number"
                    class="form-control"
                    id="document"
                    v-model="formUser.document"
                  />
                </div>
                <div class="form-group col-md-4">
                  <label for="address">Direccion</label>

                  <input
                    type="text"
                    class="form-control"
                    id="address"
                    v-model="formUser.address"
                  />
                </div>
                <div class="form-group col-md-4">
                  <label for="headquarter_id">Sede</label>
                  <v-select
                    :options="headquarterList.data"
                    :label="'headquarter'"
                    :reduce="(headquarter) => headquarter.id"
                    v-model="formUser.headquarter_id"
                  >
                  </v-select>
                </div>
                <div class="form-group col-md-4">
                  <label for="rol_id">Rol</label>
                  <select
                    name="rol_id"
                    id="rol_id"
                    class="custom-select"
                    v-model="formUser.rol_id"
                  >
                    <option value="0" disabled>--Seleccionar--</option>
                    <option value="1">Administrador</option>
                    <option value="2">Operario</option>
                  </select>
                </div>
                <div class="form-group col-md-4">
                  <label for="password">Contraseña</label>
                  <input
                    type="password"
                    class="form-control"
                    id="password"
                    v-model="formUser.password"
                    autocomplete="false"
                  />
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
              @click="editar = false"
            >
              Cerrar
            </button>
            <button
              type="button"
              class="btn btn-primary rounded"
              @click="editar ? editUser() : createUser()"
            >
              Guardar
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      editar: false,
      headquarterList: [],
      formUser: {
        name: "",
        email: "",
        password: "",
        nombre: "",
        phone: "",
        address: "",
        type_document: "CC",
        document: 0,
        photo: "",
        status: "1",
        rol_id: "",
        headquarter_id: "",
      },
      type_documents: this.$root.$data.type_documents,
    };
  },
  // Function createUsers
  created() {
    this.listHeadquarters(1);
  },
  methods: {
    createUser() {
      let me = this;
      axios.post("api/users", this.formUser).then(function () {
        $("#formUserModal").modal("hide");
        me.$emit("listar-users");
      });
    },
    abirEditarUser(client) {
      this.editar = true;
      let me = this;
      $("#formUserModal").modal("show");
      me.formUser = client;
    },
    editUser() {
      let me = this;
      axios
        .put("api/users/" + this.formUser.id, this.formUser)
        .then(function () {
          $("#formUserModal").modal("hide");
          me.$emit("listar-users");
        });
      this.editar = false;
    },
    resetData() {
      let me = this;
      Object.keys(this.formUser).forEach(function (key, index) {
        me.formUser[key] = "";
      });
    },

    listHeadquarters(page = 1) {
      let me = this;
      axios.get(`api/headquarters?page=${page}`).then(function (response) {
        me.headquarterList = response.data;
      });
    },
  },
};
</script>
