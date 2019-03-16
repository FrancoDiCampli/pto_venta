<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Lista de Articulos</h3>

            <div class="card-tools">
              <button class="btn btn-success" @click="newArticle">
                <i class="fas fa-user-plus"></i>
                Nuevo Articulo
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <tbody>
                <tr>
                  <th>ID</th>
                  <!-- <th>CodArticulo</th> -->
                  <th>BarCode</th>

                  <th>Articulo</th>

                  <th>Precio</th>
                  <th>Stock</th>

                  <th>Foto</th>

                  <th>Editar</th>
                </tr>

                <tr v-for="articulo in articulos.data" :key="articulo.id">
                  <td>{{articulo.id}}</td>
                  <!-- <td>{{articulo.codarticulo}}</td> -->
                  <td>
                    <a href @click.prevent="print(articulo.codarticulo)">
                      <barcode :value="articulo.codarticulo" :options="options" :tag="tag"></barcode>
                    </a>
                  </td>
                  <td>{{articulo.articulo}}</td>
                  <td>{{articulo.precio}}</td>
                  <td>{{articulo.stock.total}}</td>

                  <td>
                    <img :src="articulo.foto" style="width:120px;">
                  </td>

                  <td>
                    <a @click="editUser(articulo)" href="#">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a @click="deleteCliente(articulo.id)">
                      <i class="fas fa-trash-alt red"></i>
                    </a>

                    <router-link :to="{ path: '/inventarios/'+ articulo.id}" class="nav-link">
                      <i class="fas fa-warehouse"></i>
                    </router-link>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-foote">
            <pagination :data="articulos" @pagination-change-page="getResults"></pagination>
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>

    <!-- Modal -->
    <div
      class="modal fade"
      id="usuario"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-show="!editMode" class="modal-title" id="exampleModalLabel">Nuevo Articulo</h5>
            <h5 v-show="editMode" class="modal-title" id="exampleModalLabel">Actualizar Articulo</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editMode ? updateArticle() : createArticle()">
            <div class="modal-body">
              <div class="form-group col-5">
                <label>Código Articulo</label>
                <input
                  v-model="form.codarticulo"
                  type="text"
                  name="codarticulo"
                  placeholder="codarticulo"
                  v-mask="'#####'"
                  class="form-control cap"
                  :class="{ 'is-invalid': form.errors.has('codarticulo') }"
                >
                <has-error :form="form" field="codarticulo"></has-error>
              </div>

              <div class="form-group col-12">
                <label>Articulo</label>
                <input
                  v-model="form.articulo"
                  type="text"
                  name="articulo"
                  placeholder="Articulo"
                  class="form-control cap"
                  :class="{ 'is-invalid': form.errors.has('articulo') }"
                >
                <has-error :form="form" field="articulo"></has-error>
              </div>

              <div class="form-group col-12">
                <label>Descripcion</label>
                <textarea
                  v-model="form.descripcion"
                  type="text"
                  name="descripcion"
                  placeholder="Descripcion"
                  class="form-control cap"
                  :class="{ 'is-invalid': form.errors.has('descripcion') }"
                >
                    <has-error :form="form" field="descripcion"></has-error>
                    </textarea>
              </div>

              <div class="row">
                <div class="form-group col-4">
                  <label>Costo</label>
                  <input
                    v-model="form.costo"
                    type="text"
                    name="costo"
                    placeholder="Costo"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('costo') }"
                  >
                  <has-error :form="form" field="costo"></has-error>
                </div>
                <div class="form-group col-4">
                  <label>Utilidades</label>
                  <input
                    v-model="utilidades"
                    type="text"
                    name="utilidades"
                    placeholder="utilidades"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('utilidades') }"
                  >
                  <has-error :form="form" field="utilidades"></has-error>
                </div>
                <div class="form-group col-4">
                  <label>Precio</label>
                  <input
                    v-model="form.precio"
                    type="text"
                    name="precio"
                    placeholder="precio"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('precio') }"
                  >
                  <has-error :form="form" field="precio"></has-error>
                </div>
              </div>
              <div class="form-group col-7">
                <label>Marca</label>
                <select
                  name="marca_id"
                  v-model="form.marca_id"
                  id="marca_id"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('marca_id') }"
                >
                  <option v-for="marca in marcas" :key="marca.id" :value="marca.id">{{marca.marca}}</option>
                </select>
                <has-error :form="form" field="type"></has-error>
              </div>

              <div class="form-group col-7">
                <label>Categoria</label>
                <select
                  name="categoria_id"
                  v-model="form.categoria_id"
                  id="categoria_id"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('categoria_id') }"
                >
                  <option
                    v-for="categoria in categorias"
                    :key="categoria.id"
                    :value="categoria.id"
                  >{{categoria.categoria}}</option>
                </select>
                <has-error :form="form" field="type"></has-error>
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
    <!-- Modal para preguntar cantidad de elemento a imprimir -->
    <div
      class="modal fade"
      id="barcode"
      tabindex="-1"
      role="dialog"
      aria-labelledby="barcodeExample"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5>Ingrese la cantidad a imprimir</h5>
          </div>
          <div class="modal-body">
            <form action="/print" method="POST">
              <input type="text" class="form-control" name="code" v-model="code" hidden>
              <input type="text" class="form-control" name="cant">
              <button class="btn btn-success" type="submit">Print</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Fin del modal -->
  </div>
</template>

<script>
import VueBarcode from "@xkeshi/vue-barcode";
export default {
  data() {
    return {
      utilidades: null,
      stock: 10,
      precio: 10,
      editMode: false,
      articulos: {},
      marcas: {},
      categorias: {},
      image: "",
      busqueda: {},
      id: 10,
      code: null,
      height: 100,
      form: new Form({
        id: "",
        codarticulo: "",
        articulo: "",
        descripcion: "",
        costo: "",
        utilidades: "",
        precio: "",
        foto: "",
        marca_id: 0,
        categoria_id: 0
      }),
      tag: "svg",
      options: {
        lineColor: "#000",
        fontSize: 12,
        font: "Courier",
        width: 2,
        height: 30,
        marginBottom: 20,
        format: "MSI",
        background: "#fff"
      }
    };
  },
  components: {
    barcode: VueBarcode
  },
  watch: {
    utilidades: function() {
      var por = this.utilidades / 100;
      this.form.precio = this.form.costo + this.form.costo * por;
    }
  },
  methods: {
    print(val) {
      this.code = val;
      $("#barcode").modal("show");
    },
    deleteCliente(id) {
      swal({
        title: "Estas Seguro?",
        text: "Estas a punto de eliminar un cliente!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminalo!"
      }).then(result => {
        this.form
          .delete("api/clientes/" + id)
          .then(() => {
            if (result.value) {
              swal("Eliminado!", "success");
              this.loadUsers();
            }
          })
          .catch(() => {});
      });
    },
    getResults(page = 1) {
      axios.get("api/articulos?page=" + page).then(response => {
        this.users = response.data;
      });
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
    },
    updateArticle() {
      this.form.foto = this.image;
      this.form.utilidades = this.utilidades;
      this.form
        .put("api/articulos/" + this.form.id)
        .then(() => {
          $("#usuario").modal("hide");
          this.loadArticles();
          swal("Actualizado!", "La informacion ha sido actualizada", "success");
        })
        .catch(() => {});
    },
    editUser(articulo) {
      this.form.errors.clear();
      this.editMode = true;
      this.form.reset();

      $("#usuario").modal("show");
      this.form.fill(articulo);

      this.image = articulo.foto;
    },

    newArticle() {
      this.editMode = false;
      this.form.reset();
      this.image = "";
      $("#usuario").modal("show");
    },

    validarInputs() {
      var cad = this.form.doc;

      this.form.doc = cad.replace(/\./g, "");
    },
    loadArticles() {
      this.form.reset();

      var me = this;
      axios
        .get("api/articulos")
        .then(function(response) {
          (me.articulos = response.data.articulos),
            (me.marcas = response.data.marcas),
            (me.categorias = response.data.categorias);
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        })
        .then(function() {
          // always executed
        });
    },

    createArticle() {
      this.form.foto = this.image;
      this.form.utilidades = this.utilidades;
      this.form
        .post("api/articulos")
        .then(() => {
          $("#usuario").modal("hide");
          this.loadArticles();
          toast({
            type: "success",
            title: "Articulo creado"
          });
        })
        .catch(() => {});
    }
  },
  created() {
    Fire.$on("searching", () => {
      let query = this.$parent.search;
      axios
        .get("api/findArticulo?q=" + query)
        .then(data => {
          this.articulos = data.data;
        })
        .catch(() => {});
    });

    this.loadArticles();
  }
};
</script>
