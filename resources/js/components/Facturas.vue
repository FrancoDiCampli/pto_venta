<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Facturas</h3>

            <div class="card-tools">
              <router-link to="/factura" class="btn btn-success">
                <i class="fas fa-file-invoice"></i>
                Nueva Factura
              </router-link>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <tbody>
                <tr>
                  <th>ID</th>
                  <th>No Factura</th>

                  <th>CUIT</th>

                  <th>Importe</th>
                  <th>Fecha</th>

                  <th>Editar</th>
                </tr>

                <tr v-for="articulo in articulos.data" :key="articulo.id">
                  <td>{{articulo.id}}</td>
                  <td>{{articulo.numfactura}}</td>
                  <td>{{articulo.cuit}}</td>
                  <td>{{articulo.total}}</td>
                  <td>{{articulo.fecha}}</td>

                  <td>
                    <a @click="editUser(articulo)" href="#">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a @click="deleteCliente(articulo.id)">
                      <i class="fas fa-trash-alt red"></i>
                    </a>
                    <a v-if="articulo.comprobante" @click="mira(articulo)" href="#">
                      <i class="fas fa-file-invoice"></i>
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
          <div class="modal-header">Aqui va la factura</div>

          <div class="moadl-body">
            <div class="container">
              <div class="row text-center">
                <div class="col-6 bordeado">
                  <h1>Logotipo</h1>
                  <p>
                    <strong>Razon Social:</strong> Di Campli Franco A.
                    <br>
                    <strong>Domicilio comercial:</strong> Jose Martin 51 - Villa Angela Chaco
                    <br>
                    <strong>Condicion frente al IVA:</strong>Responsable Monotributo
                    <br>
                  </p>
                </div>

                <div class="col-1 bordeado">
                  <h1>C</h1>
                </div>

                <div class="col-5 bordeado">
                  <h2>FACTURA</h2>
                  <p>
                    <strong>Punto de Venta:{{form.ptoventa}}</strong>
                    <br>
                    <strong>Comp Nro:{{form.numfactura}}</strong>
                    <br>
                    <strong>Fecha de Emision:{{form.fecha}}</strong>
                    <br>
                  </p>
                  <p>
                    <strong>CUIT:23288066469</strong>
                    <br>
                    <strong>Ingresos Brutos:23288066469</strong>
                    <br>
                    <strong>Fecha Inicio de Actividades:02/02/02</strong>
                    <br>
                  </p>
                </div>
              </div>

              <!-- <div class="row bordeado">
                <div class="col-12">
                  <p>
                    <strong>Periodo Facturado Desde:</strong>
                    <strong>Hasta:</strong>
                    <strong>Fecha Vto de Pago:</strong>
                  </p>
                </div>
              </div>-->
              <div class="row">
                <div class="col-6 bordeado">
                  <p>
                    <strong>CUIT:</strong>
                    {{cliente.cuit}}
                    <br>
                    <strong>Condicion frente al IVA:</strong>
                    {{this.condicion}}
                    <br>
                    <strong>Condicion de Venta:</strong>
                    {{cliente.condicionpago}}
                    <br>
                  </p>
                </div>

                <div class="col-6 bordeado">
                  <p>
                    <strong>Apellido y Nombre/Razon Social</strong>
                    {{cliente.razonsocial}}
                    <br>
                    <strong>Domicilio:</strong>
                    {{cliente.direccion}}
                    <br>
                  </p>
                </div>
              </div>

              <div class="row">
                <div class="col-12">
                  <table class="table table-bordered">
                    <thead class="thead-light">
                      <tr>
                        <th>Cod</th>
                        <th>Prod</th>
                        <th>C.</th>
                        <th>P.Unitario</th>

                        <th>STotal</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="detalle in detalles" :key="detalle.id">
                        <td>{{detalle.codarticulo}}</td>
                        <td>{{detalle.articulo}}</td>
                        <td>{{detalle.pivot.cantidad}}</td>
                        <td>{{detalle.pivot.preciounitario}}</td>
                        <td>{{detalle.pivot.subtotal}}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="row">
                <div class="col-8">&nbsp</div>
                <div class="col-4 text-right">
                  <p>
                    <strong>Subtotal:</strong>
                    {{form.total}}
                    <br>
                    <strong>Importe Otros Tributos:</strong> 0,00
                    <br>
                    <strong>Importe Total</strong>
                    {{form.total}}
                    <br>
                  </p>
                </div>
              </div>

              <div class="row">
                <!-- <div class="col-12 bordeado">
                  <barcode :value="codigobarra" :options="options" :tag="tag"></barcode>
                  <p>{{codigobarra}}</p>
                </div>-->
              </div>

              <div class="row">
                <div class="col-1 bordeado">Pag. 1/1</div>

                <div class="col-5 bordeado">
                  <button
                    class="btn btn-success"
                    @click.prevent="generar(form.numfactura)"
                  >Generar Factura</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- end Modal -->
    </div>
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
      detalles: {},
      condicion: null,
      cae: null,
      vtocae: null,
      codigobarra: "0",

      cliente: new Form({
        id: "",
        razonsocial: "",
        cuit: "",
        doc: "",
        direccion: "",
        cp: "",
        estado: "",
        localidad: "",
        provincia: "",
        condicionpago: "",
        enviarcomprobante: 0,
        mail: "",
        telefono: "",
        estado: 0,
        foto: ""
      }),

      form: new Form({
        id: "",
        ptoventa: "",
        numfactura: "",
        cuit: "",
        fecha: "",
        recargo: "",
        total: "",
        cliente_id: ""
      }),
      afip: new Form({
        DocNro: "",
        CbteDesde: "",
        CbteFch: "",
        ImpTotal: "",
        CodAutorizacion: "",
        FchVto: "",
        FchProceso: ""
      }),
      tag: "svg",
      options: {
        lineColor: "#000",
        fontSize: 12,
        font: "Courier",
        width: 2,
        height: 30,
        marginBottom: 20,
        format: "ITF",
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
    mira(articulo) {
      this.form.errors.clear();
      this.editMode = true;
      this.form.reset();
      this.traerFactura(articulo.id);
      this.traerCliente(articulo.cliente_id);
      // this.traerAfip(articulo.numfactura);
      $("#usuario").modal("show");
      this.form.fill(articulo);
      this.traerafip(articulo.id);
      var me = this;
      axios
        .get("/api/detalles/" + this.form.id)
        .then(function(response) {
          me.detalles = response.data.detalle;
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        })
        .then(function() {
          // always executed
        });
    },
    traerafip(id) {
      axios.get("api/afip/" + id).then(response => {
        console.log(response);
      });
    },
    generar(numfactura) {
      axios.get("api/facturar/" + numfactura).then(response => {
        console.log(response.data);
      });
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
      this.traerFactura(articulo.id);
      this.traerCliente(articulo.cliente_id);
      // this.traerAfip(articulo.numfactura);
      $("#usuario").modal("show");
      this.form.fill(articulo);
      var me = this;
      axios
        .get("/api/detalles/" + this.form.id)
        .then(function(response) {
          console.log(response.data.detalle);
          me.detalles = response.data.detalle;
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        })
        .then(function() {
          // always executed
        });
    },
    traerFactura(id) {
      axios
        .get("/api/factura/" + id)
        .then(function(response) {
          console.log(response.data);
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        })
        .then(function() {
          // always executed
        });
    },
    traerCliente(id) {
      var me = this;
      axios
        .get("/api/clientes/" + id)
        .then(function(response) {
          me.cliente = response.data;
          if (me.cliente.percibeiva) {
            me.condicion = "Responsable Inscripto";
          } else {
            me.condicion = "Consumidor Final";
          }
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        })
        .then(function() {
          // always executed
        });
    },
    traerAfip(factura) {
      var me = this;
      axios
        .get("/api/afip/" + factura)
        .then(function(response) {
          me.cae = response.data.factura.CodAutorizacion;
          me.vtocae = response.data.factura.FchVto;
          me.codigobarra = response.data.cod;
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        })
        .then(function() {
          // always executed
        });
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
      axios
        .get("api/lista")
        .then(({ data }) => (this.articulos = data.facturas));
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
