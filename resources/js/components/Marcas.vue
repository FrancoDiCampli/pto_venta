<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="header-tittle">Marcas</h3>

            <div class="card-tools">
              <button class="btn btn-success" @click="newMarca">
                <i class="fas fa-user-plus"></i>
                Nueva Marca
              </button>
            </div>
          </div>

          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <tbody>
                <tr>
                  <th>ID</th>
                  <th>Marca</th>
                  <th>File</th>

                  <th>Acciones</th>
                </tr>

                <tr v-for="marca in marcas.data" :key="marca.id ">
                  <td>{{marca.id}}</td>
                  <td>{{marca.marca}}</td>
                  <td>
                    <img :src="marca.file" style="width:120px;">
                  </td>

                  <td>
                    <a @click="editMarca(marca)" href="#">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a @click="deleteMarca(marca.id)">
                      <i class="fas fa-trash-alt red"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="card-foote">
            <pagination :data="marcas" @pagination-change-page="getResults"></pagination>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div
      class="modal fade"
      id="marca"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-show="!editMode" class="modal-title" id="exampleModalLabel">Nueva Marca</h5>
            <h5 v-show="editMode" class="modal-title" id="exampleModalLabel">Actualizar Marca</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form @submit.prevent="editMode ? updateMarca() : createMarca()">
            <div class="modal-body">
              <div class="form-group col-12">
                <label>Marca</label>
                <input
                  v-model="form.marca"
                  type="text"
                  name="marca"
                  placeholder="Marca"
                  class="form-control cap"
                  :class="{ 'is-invalid': form.errors.has('marca') }"
                >
                <has-error :form="form" field="marca"></has-error>
              </div>

              <div class="form-group col-5">
                <label>Foto</label>
                <img :src="image" class="profile-user-img img-responsive" style="max-width:100%">
                <input type="file" v-on:change="onFileChange" class="form-control">
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
              <button v-show="editMode" type="submit" class="btn btn-success">Actualizar</button>
              <button v-show="!editMode" type="submit" class="btn btn-primary">Crear</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- end Modal -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      editMode: false,
      marcas: {},
      image: "",
      busqueda: {},

      form: new Form({
        id: "",
        marca: "",
        file: ""
      })
    };
  },

  methods: {
    deleteMarca(id) {
      swal({
        title: "Estas Seguro?",
        text: "Estas a punto de eliminar una marca!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminalo!"
      }).then(result => {
        this.form
          .delete("api/marcas/" + id)
          .then(() => {
            if (result.value) {
              swal("Eliminado!", "success");
              this.loadMarcas();
            }
          })
          .catch(() => {});
      });
    },

    getResults(page = 1) {
      axios.get("api/marcas?page=" + page).then(response => {
        this.marcas = response.data;
      });
    },

    updateMarca() {
      this.form.file = this.image;
      this.form
        .put("api/marcas/" + this.form.id)
        .then(() => {
          $("#marca").modal("hide");
          this.loadMarcas();
          swal("Actualizado!", "La informacion ha sido actualizada", "success");
        })
        .catch(() => {});
    },

    editMarca(marca) {
      this.form.errors.clear();
      this.editMode = true;
      this.form.reset();

      $("#marca").modal("show");
      this.form.fill(marca);

      this.image = marca.file;
    },

    newMarca() {
      this.editMode = false;
      this.form.reset();
      this.image = "";
      $("#marca").modal("show");
    },

    loadMarcas() {
      this.form.reset();
      axios.get("api/marcas").then(({ data }) => (this.marcas = data));
    },

    createMarca() {
      this.form.file = this.image;
      this.form
        .post("api/marcas")
        .then(() => {
          $("#marca").modal("hide");
          this.loadMarcas();
          toast({
            type: "success",
            title: "Marca creada"
          });
        })
        .catch(() => {});
    },

    onFileChange(e) {
      let files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.createImage(files[0]);
    },

    createImage(file) {
      let reader = new FileReader();
      let vm = this;
      reader.onload = e => {
        vm.image = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  },

  created() {
    Fire.$on("searching", () => {
      let query = this.$parent.search;
      axios
        .get("api/findMarca?q=" + query)
        .then(data => {
          this.marcas = data.data;
        })
        .catch(() => {});
    });
    this.loadMarcas();
  }
};
</script>

