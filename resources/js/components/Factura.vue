<template>

    <div class="container">
     
        <div class="row" id="factura">

           <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Nueva Facura</h4>
                    
                    
                    <div class="invoice p-3 mb-3">
                
                        <div class="row">
                            <div class="col-sm-4 invoice-col">
                                De:
                                <address>
                                    <h2>Jugueteria SA</h2>
                                    <br>
                                    <strong>Direccion:  </strong><div>San Francisco 123</div><br>
                                    <strong>Telefono:  </strong><div>3735-433221</div><br>
                                    <strong>CUIT:  </strong><div>22-8978622-9</div><br>
                                </address>
                            </div>

                            <div class="col-sm-8 invoice-col">
                                
                                <div>
                                    <input type="text" 
                                        placeholder="Buscar Cliente..." 
                                        v-model="buscarCliente" 
                                        v-on:keyup="autoComplete" 
                                        class="form-control">

                                    <div v-if="clientes.length">
                                    <ul class="list-group">
                                    <li class="list-group-item" 
                                        v-for="(result,index) in clientes" 
                                        :key="index" @click="seleccionaCliente(result)">{{ result.nombre }}</li>
                                    </ul>
                                    </div>

                                </div>
                            
                                <address>
                                    <h2 v-text="form.nombre"></h2>

                                    <strong>Direccion:  </strong><div v-text="form.direccion"></div><br>
                                
                                    <strong>Tel: </strong> <div v-text="form.telefono"></div><br>
                                    <strong>Email: </strong> <div v-text="form.mail"></div><br>
                                    <strong>CUIT: </strong> <div v-text="form.doc"></div> 
                                    <input type="text" v-model="cuit" hidden>
                                </address>
                                
                            </div>

                        </div>

                        <div class="col-sm-4 invoice-col float-right">
                    
                        </div>

                    </div>
                   
                    </div>

                    <div class="card-body">
                        <form action="" @submit.prevent="guardarFactura()" >
                             <input type="" name="user_id" v-model="userid" hidden >
                            <input type="" name="cuit" v-model="form.doc" hidden >
                            <input type="" name="cliente_id" v-model="form.id" hidden >
                            <div class="row">

                                <div class="col-md-2">
                                <label for="">Punto de Venta</label>
                                    <input type="text" class="form-control" name="ptoVenta" placeholder="Punto de Venta" value="1">
                                </div>

                                <div class="col-md-3">
                                    <label for="">Num Factura</label>
                                    
                                    <input 
                                        type="text" v-show="facturas" class="form-control" placeholder="Numero de Factura" 
                                        name="numFactura" v-model="numfactura">

                                    <input 
                                        type="text" v-show="!facturas" class="form-control" placeholder="Numero de Factura" 
                                        name="numFactura" value="1">

                                                
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
                                            type="text" name="fecha" 
                                            class="form-control float-right" 
                                            id="reservation" :value="fecha">
                                    </div>
                                    <!-- /.input group -->
                                    </div>
                                </div>

                            </div>

                            <hr>

                            <div class="row fila">

                                <!-- Busqueda por cod de articulo, no por id -->
                                <div class="col-md-4">
                                    <label for="">CodArticulo</label>
                                    <input 
                                    type="text" 
                                    placeholder="Buscar Cod Articulo..." 
                                    v-model="cod" 
                                    v-on:keyup="traerCodigo" 
                                    @click="limpiarCodigo()"
                                    class="form-control">

                                    <div v-if="articulos.length">
                                    <ul class="list-group">
                                    <li class="list-group-item" 
                                        v-for="(r,index) in articulos"
                                        @click="cargarArticulo(r)"  
                                        :key="index">{{ r.codarticulo }}</li>
                                    </ul>
                                    </div>
                                </div>

 
                              <div class="col-md-4">
                                <label>Seleccione Articulo</label>
                                <div>
                                <input 
                                    type="text" 
                                    placeholder="Buscar Articulo..." 
                                    v-model="articulo" v-on:keyup="traerArticulo"
                                    @click="limpiarArticulo()"
                                   
                                    class="form-control">
                                <div v-if="todos.length">
                                <ul class="list-group">
                                <li class="list-group-item" 
                                    v-for="resultado in todos" 
                                    :key="resultado.id"
                                    @click="cargarArticulo(resultado)">{{ resultado.articulo }}
                                </li>
                                </ul>
                                </div>
                                </div>
                                
                              </div>

                                <div class="col-md-2">
                                <label for="">Unidades</label>
                                  <input type="number" class="form-control" 
                                  placeholder="Unidades" 
                                  min="1" 
                                  :max="max"
                                  step="1" 
                                  v-model="disponible">
                              
                                </div>
                                <div class="col-md-2">
                                <label for="">P Unitario</label>
                                  <input type="text" class="form-control" placeholder="P.Unitario" id="precio" v-model="precio">
                              
                                </div> 

                             

                            </div>

                         <div class="clearfix"></div>
                            <hr>
                            <button 
                                type='button' 
                                class="btn btn-info" 
                                @click="agregarFila()"
                                :disabled="botonDeshabilitado">
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
                                    <th>P. Unitario</th>
                                    <th>subTotal</th>
                                    </tr>
                                </thead>

                                <tbody>
                                      <tr v-for="(invoice_product, k) in detalles"  :key="k" v-if="k>0" >
                                        <td scope="row" class="trashIconContainer">
                                    
                                        <i class="fas fa-trash-alt" 
                                            @click="deleteRow(k, invoice_product)" 
                                            style="color:red"></i>
                                        <input name="codArticulo[]" 
                                            class="form-control" type="text" 
                                            v-model="invoice_product.id" hidden/>

                                        </td>
                                        <td>
                                            <input  class="form-control" type="text" v-model="invoice_product.codArticulo" />
                                        </td>
                                        <td>
                                            <input class="form-control " type="text" v-model="invoice_product.articulo" />
                                        </td>
                                         <td>
                                            <input 
                                                name="cantidad[]" 
                                                class="form-control text-right" 
                                                type="text" 
                                                v-model="invoice_product.unidades" 
                                            
                                            />
                                        </td>
                                        <td>
                                            <input name="precioUnitario[]" class="form-control text-right" type="number" min="0" step=".01" v-model="invoice_product.precioUnitario" @change="calculateLineTotal(invoice_product)"
                                            />
                                        </td>
                                        <td>
                                            <input readonly name="subTotal[]" class="form-control text-right" type="number" min="0" step=".01" v-model="invoice_product.sTotal" />
                                        </td> 
                                      </tr>

                                    
                                </tbody>
                            </table>

                             <div class="row">

                              <div class="col-md-3 offset-md-9">
                                <div class="form-group bmd-form-group">
                                  <label for="">Total</label>
                                  <input type="text" class="form-control" placeholder="Total" name="total" v-model="total">
                                </div>
                              </div>
                            </div>

                             <div class="row">

                              <div class="col-md-3 offset-md-9">
                                <div class="form-group bmd-form-group">
                                  <label for="">Recargo</label>
                                  <input 
                                    @change="calculateTotal()"
                                    type="text"
                                    class="form-control" 
                                    placeholder="Recargo"
                                    name="recargo" 
                                    v-model="invoice_tax">
                                </div>
                              </div>
                            </div>
                             <button 
                                @click="enviarDatos()"
                                class="btn btn-primary pull-right"
                                :disabled="guardadoDeshabilitado"
                                >Guardar Factura</button>

                        </form>


                    </div>  

            </div>
    
            </div>
        </div>
    </div>
        
   
</template>

<script>
 import moment from 'moment'
     export default {
        
         data(){
             return{
                    fecha:'',
                    facturas:true,
                    numfactura: 100,
                    cliente:'',
                    buscarCliente:'',
                    clientes:{},
                    userid:'',
                    cod:'',
                    articulo:'',
                    articulos:{},
                    id:'',
                    todos:{},
                    disponible:'',
                    max:'',
                    precio:'',
                    botonDeshabilitado: true,
                    total:0,
                    invoice_tax:21,
                    guardadoDeshabilitado:false,
                    cuit:'',
                 form: new Form({
                    id:'',
                    nombre : '',
                    doc: '',
                    direccion: '',
                    cp: '',
                    percibeiva: 0,
                    percibeiibb: 0,
                    condicionpago: '',
                    enviarcomprobante: 0,
                    mail: '',
                    telefono:'',
                    estado:0,
                    foto:'',

                }),
                detalles: [{
                    id:'',
                    codArticulo: '',
                    articulo: '',
                    precioUnitario: '',
                    unidades: '',
                    sTotal: 0
                }],


             }
         },
         methods:{
             enviarDatos(){

             },
             agregarFila() {
                this.detalles.push({
                    id:this.id,
                    codArticulo: this.cod,
                
                    articulo: this.articulo,
                    precioUnitario: this.precio,
                    unidades:this.disponible,
                    sTotal: (this.precio*this.disponible)
                    
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
                var tope  = 0;
               
                 axios.get('/api/codArticulo/'+this.cod).then(response => {
                    
                    var r = response.data;
            
                    tope = r.cantidad;
                    me.max = tope;
               
                });
                
                var total = parseFloat(invoice_product.precioUnitario) * parseFloat(invoice_product.unidades);
                if (!isNaN(total)) {
                    invoice_product.sTotal = total.toFixed(2);
                    }
                    this.calculateTotal();
            
            },
            calculateTotal() {
                var subtotal, total;
                subtotal = this.detalles.reduce(function (sum, product) {
                    var lineTotal = parseFloat(product.sTotal);
                    if (!isNaN(lineTotal)) {
                        return sum + lineTotal;
                    }
                }, 0);

                this.sTotal = subtotal.toFixed(2);

                total = (subtotal * (this.invoice_tax / 100)) + subtotal;
                total = parseFloat(total);
                if (!isNaN(total)) {
                    this.total = total.toFixed(2);
                } else {
                    this.total = '0.00'
                }
            },
           
             cargarArticulo(res){
                
                this.precio = res.precio;
                this.id = res.id;
                this.cod = res.codarticulo;
                this.articulo = res.articulo;
                this.traerInventario(this.cod);
                
                this.todos = {};
                this.articulos = {};
                this.botonDeshabilitado = false;
                

             },
             traerInventario(val){
                  axios.get('/api/traerInventario/'+val).then(response => {
                this.disponible = response.data.stock;
                this.max = response.data.stock;
                this.precio = response.data.inventarios[0].precioventa;
               
                });
             },
             guardarFactura(){

             },
             autoComplete(){
                var me = this;
                me.clientes = {};
                if(me.buscarCliente.length > 0){
                axios.get('/api/buscarCliente/'+me.buscarCliente).then(response => {
                    me.userid = response.data.user;
                me.clientes = response.data.clientes;
                
                
                });
                }else{
                    me.clientes ={};
                    me.buscarCliente ='';
                }
       
            },
            seleccionaCliente(cliente){
                this.cui = cliente.doc;
                this.form.fill(cliente);
                this.buscarCliente = '';
                this.clientes = '';

            },
            traerFactura(){
                 var me = this;
               
                axios.get('/api/facturas/').then(response => {
                   me.numfactura = response.data;
                    me.numfactura = me.numfactura.factura[0].numfactura + 1;
                });
               
            },
            fechar: function () {
                
                this.fecha = moment().format("DD-MM-YYYY");  
                console.log(this.fecha);
            },

            traerCodigo(){
                var me = this;
               
                if(me.cod.length > 0){
                axios.get('/api/codArticulo/'+this.cod).then(response => {
                me.articulos = response.data;
               
                
                });
                }else{
                    me.articulos ={};
                }
            },
            traerArticulo(){
                var me = this;
               
                if(me.articulo.length > 0){
                axios.get('/api/nomArticulo/'+this.articulo).then(response => {
                me.todos = response.data;
               
                
                });
                }else{
                    me.articulos ={};
                }
            },
            limpiarArticulo(){
                this.articulo = '';
            },
            limpiarCodigo(){
                this.cod = '' ;
            }
         },
         watch:{
              detalle(newval,oldval){
                if(this.cuit>0 && this.detalle>0 && this.total>0){
                    this.guardadoDeshabilitado = false;
                    
                    }else{
                        if(this.detalle == 0 ){
                            this.total = 0;
                            this.guardadoDeshabilitado = true;
                        }
                    }
                
                },

             cuit(newval, oldval){
                if(this.cuit>0 && this.detalle>0 && this.total>0){
                    this.guardadoDeshabilitado = false;
                }else{
                    if(this.detalle == 0 ){
                        this.total = 0;
                        this.guardadoDeshabilitado = true;
                    }
                }
            
            },
            cantidad(newval, oldval){
            this.subTotal = (this.cantidad * this.precio);
            
            },
            precio(newval, oldval){
            this.subTotal = (this.cantidad * this.precio);
            }

         },
        mounted() {
           this.traerFactura();
           this.fechar();
        }
    }

</script>

