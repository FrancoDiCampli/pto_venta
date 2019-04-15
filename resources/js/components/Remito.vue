<template>
  <div class="container">
    <div class="row" id="factura">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title">Nuevo Remito</h4>

            <div class="invoice p-3 mb-3">
              <div class="row">
                <div class="col-sm-4 invoice-col">
                  De:
                  <address>
                    <h2>Jugueteria SA</h2>
                    <br>
                    <strong>Direccion:</strong>
                    <div>San Francisco 123</div>
                    <br>
                    <strong>Telefono:</strong>
                    <div>3735-433221</div>
                    <br>
                    <strong>CUIT:</strong>
                    <div>22-8978622-9</div>
                    <br>
                  </address>
                </div>

                <div class="col-sm-8 invoice-col">
                  <div>
                    <input
                      type="text"
                      placeholder="Buscar Proveedor..."
                      v-model="buscar"
                      v-on:keyup="autoComplete"
                      class="form-control"
                    >

                    <div v-if="clientes.length">
                      <ul class="list-group">
                        <li
                          class="list-group-item"
                          v-for="(result,index) in clientes"
                          :key="index"
                          @click="seleccionaCliente(result)"
                        >{{ result.proveedor }}</li>
                      </ul>
                    </div>
                  </div>

                  <address>
                    <h2 v-text="form.nombre"></h2>

                    <strong>Direccion:</strong>
                    <div v-text="form.direccion"></div>
                    <br>

                    <strong>Tel:</strong>
                    <div v-text="form.telefono"></div>
                    <br>
                    <strong>Email:</strong>
                    <div v-text="form.mail"></div>
                    <br>
                    <strong>CUIT:</strong>
                    <div v-text="form.cuit"></div>
                    <input type="text" v-model="cuit" hidden>
                  </address>
                </div>
              </div>

              <div class="col-sm-4 invoice-col float-right"></div>
            </div>
          </div>

          <div class="card-body">
            <form>
              <input type name="user_id" v-model="userid" hidden>
              <input type name="cuit" v-model="form.cuit" hidden>
              <input type name="proveedor_id" v-model="form.id" hidden>
              <div class="row">
                <div class="col-md-2">
                  <label for>Punto de Venta</label>
                  <input
                    type="text"
                    class="form-control"
                    name="ptoVenta"
                    placeholder="Punto de Venta"
                    v-model="ptoventa"
                  >
                </div>

                <div class="col-md-3">
                  <label for>No. Remito</label>

                  <input
                    type="text"
                    class="form-control"
                    placeholder="Numero de Remito"
                    name="numremito"
                    v-model="numremito"
                  >
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label>Fecha</label>

                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="fa fa-calendar"></i>
                        </span>
                      </div>

                      <input
                        type="text"
                        name="fecha"
                        class="form-control float-right"
                        id="reservation"
                        :value="fecha"
                      >
                    </div>
                    <!-- /.input group -->
                  </div>
                </div>
              </div>

              <hr>

              <div class="row fila">
                <!-- Busqueda por cod de articulo, no por id -->
                <div class="col-md-2">
                  <label for>CodArticulo</label>
                  <input
                    type="text"
                    placeholder="Buscar Cod Articulo..."
                    v-model="cod"
                    v-on:keyup="traerCodigo"
                    @click="limpiarCodigo()"
                    class="form-control"
                  >

                  <div v-if="articulos.length">
                    <ul class="list-group">
                      <li
                        class="list-group-item"
                        v-for="(r,index) in articulos"
                        @click="cargarArticulo(r)"
                        :key="index"
                      >{{ r.codarticulo }}</li>
                    </ul>
                  </div>
                </div>

                <div class="col-md-4">
                  <label>Seleccione Articulo</label>
                  <div>
                    <input
                      type="text"
                      placeholder="Buscar Articulo..."
                      v-model="articulo"
                      v-on:keyup="traerArticulo"
                      @click="limpiarArticulo()"
                      class="form-control"
                    >
                    <div v-if="todos.length">
                      <ul class="list-group">
                        <li
                          class="list-group-item"
                          v-for="resultado in todos"
                          :key="resultado.id"
                          @click="cargarArticulo(resultado)"
                        >{{ resultado.articulo }}</li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <label for>Lote</label>
                  <input
                    type="number"
                    class="form-control"
                    placeholder="Lote"
                    min="1"
                    step="1"
                    v-model="lote"
                  >
                </div>
                <div class="col-md-2">
                  <label for>Unidades</label>
                  <input
                    type="number"
                    class="form-control"
                    placeholder="Unidades"
                    min="1"
                    step="1"
                    v-model="disponible"
                  >
                </div>
                <div class="col-md-2">
                  <label for>P Unitario</label>
                  <input
                    type="text"
                    class="form-control"
                    placeholder="P.Unitario"
                    id="precio"
                    v-model="precio"
                  >
                </div>
              </div>

              <div class="clearfix"></div>
              <hr>
              <button
                type="button"
                class="btn btn-info"
                @click="agregarFila()"
                :disabled="botonDeshabilitado"
              >
                <i class="fas fa-plus-circle"></i>
                Agregar
              </button>

              <table class="table">
                <thead>
                  <tr>
                    <th>Del</th>

                    <th>CodArticulo</th>
                    <th>Articulo</th>
                    <th>Cantidad</th>
                    <th>Lote</th>
                    <th>P. Unitario</th>
                    <th>subTotal</th>
                  </tr>
                </thead>

                <tbody>
                  <tr v-for="(invoice_product, k) in detalles" :key="k" v-if="k>0">
                    <td scope="row" class="trashIconContainer">
                      <i
                        class="fas fa-trash-alt"
                        @click="deleteRow(k, invoice_product)"
                        style="color:red"
                      ></i>
                      <input
                        name="codArticulo[]"
                        class="form-control"
                        type="text"
                        v-model="invoice_product.id"
                        hidden
                      >
                    </td>
                    <td>
                      <input class="form-control" type="text" v-model="invoice_product.codArticulo">
                    </td>
                    <td>
                      <input class="form-control" type="text" v-model="invoice_product.articulo">
                    </td>
                    <td>
                      <input
                        name="cantidad[]"
                        class="form-control text-right"
                        type="text"
                        v-model="invoice_product.unidades"
                      >
                    </td>
                    <td>
                      <input
                        name="lote[]"
                        class="form-control text-right"
                        type="number"
                        min="0"
                        step="1"
                        v-model="invoice_product.lote"
                      >
                    </td>
                    <td>
                      <input
                        name="precioUnitario[]"
                        class="form-control text-right"
                        type="number"
                        min="0"
                        step=".01"
                        v-model="invoice_product.precioUnitario"
                        @change="calculateLineTotal(invoice_product)"
                      >
                    </td>
                    <td>
                      <input
                        readonly
                        name="subTotal[]"
                        class="form-control text-right"
                        type="number"
                        min="0"
                        step=".01"
                        v-model="invoice_product.sTotal"
                      >
                    </td>
                  </tr>
                </tbody>
              </table>

              <div class="row">
                <div class="col-md-3 offset-md-9">
                  <div class="form-group bmd-form-group">
                    <label for>Total</label>
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Total"
                      name="total"
                      v-model="total"
                    >
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3 offset-md-9">
                  <div class="form-group bmd-form-group">
                    <label for>Recargo</label>
                    <input
                      @change="calculateTotal()"
                      type="text"
                      class="form-control"
                      placeholder="Recargo"
                      name="recargo"
                      v-model="invoice_tax"
                    >
                  </div>
                </div>
              </div>
            </form>
            <button
              @click="enviarDatos"
              class="btn btn-primary pull-right"
              :disabled="guardadoDeshabilitado"
            >Guardar Remito</button>
            <!-- <button @click="test" class="btn btn-primary pull-right">Test</button> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import moment from "moment";
export default {
  data() {
    return {
      ptoventa: 1,
      fecha: "",
      facturas: true,
      numremito: null,
      cliente: "",
      buscar: "",
      clientes: {},
      userid: "",
      cod: "",
      articulo: "",
      articulos: {},
      id: "",
      todos: {},
      disponible: "",
      lote: null,
      precio: "",
      botonDeshabilitado: true,
      total: 0,
      invoice_tax: 21,
      guardadoDeshabilitado: false,
      cuit: "",
      form: new Form({
        id: "",
        proveedor: "",
        cuit: "",
        direccion: "",
        telefono: ""
      }),
      detalles: [
        {
          id: "",
          codArticulo: "",
          articulo: "",
          precioUnitario: "",
          lote: "",
          unidades: "",
          sTotal: 0
        }
      ],

      factura: new Form({})
    };
  },
  methods: {
    test() {
      this.detalles = {};
      this.form.reset();
      this.ptoventa = 1;
      this.numfactura = null;
      this.fecha = null;
      this.total = 0;
      this.invoice_tax = 21;
      this.cod = null;
      this.articulo = null;
      this.fechar();
      this.traerFactura();
    },

    enviarDatos() {
      console.log(this.numremito);
      axios({
        method: "post",
        url: "/api/remitos",
        data: {
          detalles: this.detalles,
          cliente: this.form,
          ptoventa: this.ptoventa,
          numremito: this.numremito,
          cuit: this.form.cuit,
          fecha: this.fecha,
          total: this.total,
          recargo: this.invoice_tax,
          cliente_id: this.form.id,
          user_id: 1
        }
      })
        .then(function(response) {})
        .catch(function(error) {
          console.log(error);
        })
        .then(function() {});
    },
    agregarFila() {
      this.detalles.push({
        id: this.id,
        codArticulo: this.cod,
        lote: this.lote,
        articulo: this.articulo,
        precioUnitario: this.precio,
        unidades: this.disponible,
        sTotal: this.precio * this.disponible
      });

      this.botonDeshabilitado = true;
      this.detalle++;
      this.calculateTotal();
    },
    deleteRow(index, invoice_product) {
      var idx = this.detalles.indexOf(invoice_product);

      if (idx > -1) {
        this.detalles.splice(idx, 1);
      }
      this.calculateTotal();
      this.detalle--;
    },
    calculateLineTotal(invoice_product) {
      var me = this;
      var cod = invoice_product.id;
      var tope = 0;

      axios.get("/api/codArticulo/" + this.cod).then(response => {
        var r = response.data;

        tope = r.cantidad;
        me.max = tope;
      });

      var total =
        parseFloat(invoice_product.precioUnitario) *
        parseFloat(invoice_product.unidades);
      if (!isNaN(total)) {
        invoice_product.sTotal = total.toFixed(2);
      }
      this.calculateTotal();
    },
    calculateTotal() {
      var subtotal, total;
      subtotal = this.detalles.reduce(function(sum, product) {
        var lineTotal = parseFloat(product.sTotal);
        if (!isNaN(lineTotal)) {
          return sum + lineTotal;
        }
      }, 0);

      this.sTotal = subtotal.toFixed(2);

      total = subtotal * (this.invoice_tax / 100) + subtotal;
      total = parseFloat(total);
      if (!isNaN(total)) {
        this.total = total.toFixed(2);
      } else {
        this.total = "0.00";
      }
    },

    cargarArticulo(res) {
      this.precio = res.costo;
      this.id = res.id;
      this.cod = res.codarticulo;
      this.articulo = res.articulo;
      this.lote = null;
      this.disponible = null;
      this.todos = {};
      this.articulos = {};
      this.botonDeshabilitado = false;
    },
    traerInventario(val) {
      axios.get("/api/traerInventario/" + val).then(response => {
        this.disponible = response.data.stock;
        this.max = response.data.stock;
        this.precio = response.data.inventarios[0].precioventa;
      });
    },

    autoComplete() {
      var me = this;
      me.clientes = {};
      if (me.buscar.length > 0) {
        axios.get("/api/proveedores/" + me.buscar).then(response => {
          me.userid = response.data.user;
          me.clientes = response.data.proveedores;
        });
      } else {
        me.clientes = {};
        me.buscar = "";
      }
    },
    seleccionaCliente(cliente) {
      this.cui = cliente.doc;
      this.form.fill(cliente);
      this.buscar = "";
      this.clientes = "";
    },
    fechar: function() {
      this.fecha = moment().format("DD-MM-YYYY");
    },

    traerCodigo() {
      var me = this;

      if (me.cod.length > 0) {
        axios.get("/api/codArticulo/" + this.cod).then(response => {
          me.articulos = response.data;
        });
      } else {
        me.articulos = {};
      }
    },
    traerArticulo() {
      var me = this;

      if (me.articulo.length > 0) {
        axios.get("/api/nomArticulo/" + this.articulo).then(response => {
          me.todos = response.data;
        });
      } else {
        me.articulos = {};
      }
    },
    limpiarArticulo() {
      this.articulo = "";
      this.lote = null;
      this.disponible = null;
    },
    limpiarCodigo() {
      this.cod = "";
      this.lote = null;
      this.disponible = null;
    },
    eliminarPorNulo() {
      this.detalles.splice(0);
    }
  },
  watch: {
    numremito() {
      console.log(this.numremito);
    },
    detalle(newval, oldval) {
      if (this.cuit > 0 && this.detalle > 0 && this.total > 0) {
        this.guardadoDeshabilitado = false;
      } else {
        if (this.detalle == 0) {
          this.total = 0;
          this.guardadoDeshabilitado = true;
        }
      }
    },

    cuit(newval, oldval) {
      if (this.cuit > 0 && this.detalle > 0 && this.total > 0) {
        this.guardadoDeshabilitado = false;
      } else {
        if (this.detalle == 0) {
          this.total = 0;
          this.guardadoDeshabilitado = true;
        }
      }
    },
    cantidad(newval, oldval) {
      this.subTotal = this.cantidad * this.precio;
    },
    precio(newval, oldval) {
      this.subTotal = this.cantidad * this.precio;
    }
  },
  mounted() {
    this.fechar();
  }
};
</script>

