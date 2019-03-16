<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Remitos</h3>

            <div class="card-tools">
              <router-link to="/remito" class="btn btn-success">
                <i class="fas fa-file-invoice"></i>
                Nueva Factura
              </router-link>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>No Remito</th>
                  <th>Importe</th>
                  <th>Fecha</th>
                  <th>Proveedor</th>
                  <th>Editar</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="remito in remitos" :key="remito.id">
                  <td>{{remito.id}}</td>
                  <td>{{remito.numremito}}</td>
                  <td>{{remito.total}}</td>
                  <td>{{remito.fecha}}</td>
                  <td>{{remito.proveedor_id}}</td>
                  <td>
                    <a @click="verRemito(remito)" href="#">
                      <i class="fas fa-edit"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <!-- <pagination :data="remitos" @pagination-change-page="getResults"></pagination> -->
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>
</template>

<script>
import VueBarcode from "@xkeshi/vue-barcode";
export default {
  data() {
    return {
      remitos: {},
      form: new Form({
        id: "",
        numremito: "",
        fecha: "",
        recargo: "",
        total: "",
        proveedor_id: ""
      })
    };
  },
  components: {
    barcode: VueBarcode
  },
  watch: {},
  methods: {
    loadRemitos() {
      var me = this;
      axios
        .get("/api/remitos")
        .then(function(response) {
          me.remitos = response.data;
          console.log(me.remitos);
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        })
        .then(function() {
          // always executed
        });
    },
    verRemito() {}
  },
  created() {
    this.loadRemitos();
    Fire.$on("searching", () => {
      let query = this.$parent.search;
      axios
        .get("api/findArticulo?q=" + query)
        .then(data => {
          this.articulos = data.data;
        })
        .catch(() => {});
    });
  }
};
</script>
