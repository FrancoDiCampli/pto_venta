<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Reporte de Compras</h3>

            <div class="card-tools"></div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <!-- Date range -->
            <div class="row">
              <h2>Selecciona un rango de fechas</h2>
            </div>
            <div class="row">
              <div class="col-3">
                <datepicker v-model="start" :language="es" :format="customFormatter"></datepicker>
              </div>

              <div class="col-3">
                <datepicker v-model="end" :language="es" :format="customFormatter"></datepicker>
              </div>
              <div class="col-6">
                <button
                  class="btn btn-primary"
                  @click="loadRemitosFecha"
                  :disabled="disabled"
                >Enviar</button>
              </div>
            </div>

            <div class="row">
              <div class="col-8">
                <div>
                  <input
                    type="text"
                    placeholder="Buscar Producto..."
                    v-model="buscarProducto"
                    @click="limpiar"
                    v-on:keyup="autoComplete"
                    class="form-control"
                  >

                  <div v-if="productos.length">
                    <ul class="list-group">
                      <li
                        class="list-group-item"
                        v-for="(result,index) in productos"
                        :key="index"
                        @click="seleccionaProducto(result)"
                      >{{ result.articulo }}</li>
                    </ul>
                  </div>
                </div>
              </div>

              <div class="col-4">
                <button
                  class="btn btn-primary"
                  @click="loadRemitosProducto"
                  :disabled="deshabilitado"
                >Enviar</button>
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Remito No</th>
                      <th>Fecha</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="remito in remitos" :key="remito.id">
                      <td>{{remito.numremito}}</td>
                      <td>{{remito.fecha}}</td>
                      <td v-if="xprod">{{remito.pivot.subtotal}}</td>
                      <td v-else>{{remito.total}}</td>
                    </tr>
                    <tr>Total:
                      <p>{{total}}</p>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- /.form group -->
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <div class="small">
              <line-chart :chart-data="datacollection"></line-chart>
            </div>
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>
</template>

<script>
import Datepicker from "vuejs-datepicker";
import { es } from "vuejs-datepicker/dist/locale";
import moment from "moment";
import LineChart from "./graph/LineChart.js";
export default {
  data() {
    return {
      i: "",
      f: "",
      start: "",
      end: "",
      es: es,
      disabled: true,
      remitos: {},
      ttotal: null,
      detalles: [],
      buscarProducto: "",
      productos: {},
      deshabilitado: true,
      cod: "",
      xprod: false,
      datacollection: {},
      importe: null,
      dia: null
    };
  },
  components: {
    Datepicker,
    LineChart
  },
  watch: {
    start: function() {
      this.i = this.customFormatter(this.start);
      if (this.start && this.end) {
        this.start = this.customFormatter(this.start);
        this.disabled = false;
        console.log(this.start);
      } else {
        this.disabled = true;
      }
    },
    end: function() {
      this.f = this.customFormatter(this.end);
      if (this.start && this.end) {
        this.end = this.customFormatter(this.end);
        this.disabled = false;
      } else {
        this.disabled = true;
      }
    },
    buscarProducto: function() {
      if (this.buscarProducto.length > 0) {
        this.deshabilitado = false;
      } else {
        this.deshabilitado = true;
      }
    }
  },
  methods: {
    loadRemitosProducto() {
      var me = this;
      me.remitos = {};
      me.xprod = true;
      axios
        .get("api/remitosProducto/" + me.cod)
        .then(function(response) {
          me.remitos = response.data.remitos;
          me.detalles = response.data.detalles;
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        })
        .then(function() {
          // always executed
        });
    },
    loadRemitosFecha() {
      var me = this;
      me.xprod = false;
      me.remitos = {};
      axios
        .get("api/remitos/" + me.i + "/" + me.f)
        .then(function(response) {
          me.remitos = response.data.remitos;
          me.detalles = response.data.detalles;

          let results = response.data.remitos;

          let fecha = results.map(a => a.fecha);
          let tot = results.map(a => a.total);

          me.importe = tot;

          me.dia = fecha;

          me.datacollection = {
            labels: me.dia,
            datasets: [
              {
                label: "Compras durante el periodo",
                backgroundColor: "#f87979",
                data: me.importe
              }
            ]
          };
          console.log(me.datacollection);
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        })
        .then(function() {
          // always executed
        });
      console.log(this.datacollection);
      // this.fillData(this.remitos.total);
    },
    seleccionaProducto(prod) {
      this.buscarProducto = prod.articulo;
      this.cod = prod.id;
      this.productos = {};
    },
    autoComplete() {
      var me = this;

      if (me.buscarProducto.length > 0) {
        axios.get("/api/nomArticulo/" + this.buscarProducto).then(response => {
          me.productos = response.data;
        });
      } else {
        me.productos = {};
      }
    },
    customFormatter(date) {
      return moment(date).format("YYYY-MM-DD");
    },
    limpiar() {
      this.buscarProducto = "";
    }
  },
  computed: {
    total() {
      const tot = this.detalles.reduce((acc, item) => {
        return acc + parseFloat(item.total);
      }, 0);

      return tot;
    }
  },
  created() {},
  mounted() {}
};
</script>
