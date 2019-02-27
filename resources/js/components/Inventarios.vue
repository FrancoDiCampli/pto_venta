<template>
    <div class="container">
      <pre>
        
      </pre>

        <div class="row">
            
        <h2>Alta del  Articulo:{{articulos.articulo}}</h2>
        
            <button class="btn btn-success" @click="newArticle">
                Crear inventario
            </button>


   
        <table class="table">
            <thead>
                <tr>
                
                    <th>stock</th>
                    <th>lote</th>
                    <th>Fecha de Vencimiento</th>
                    <th>Tipo de Movimiento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            
                <tr v-for="inventario in inventarios.data" :key="inventario.id">
                
                    <td>{{inventario.cantidad}}</td>
                    <td>{{inventario.lote}}</td>
                    <td>{{inventario.vencimiento}}</td>
                    <td>
                        <div class="form-group bmd-form-group">
                                <select 
                                    class="form-control" name="tipomovimiento[]"  v-model="tipomovimiento" >
                                
                                    <option value="1">Alta</option>
                                    <option value="2">Venta</option>
                                    <option value="3">Devolucion</option>
                                    <option value="4">Baja x Vencimiento</option>
                            
                                </select>
                        </div>
                    </td>
                    <td>
                        <a class="btn btn-primary" @click="editArticle(inventario)">
                        <i class="fas fa-edit"></i>Editar
                        </a>

                        <a class="btn btn-success" href="">
                                <i class="fas fa-edit"></i>Movimientos
                                </a>
                    </td>
                </tr>
            
            </tbody>
        </table>

        <div class="row">
                <div class="col-md-9">
                        <div class="form-group bmd-form-group">
                        <label for="">Total</label>
                        <input type="text" class="form-control" :value="suma">
                        </div>
                    </div>
        </div>
        
    

        <div class="modal fade bd-example-modal-lg" id="inventario" 
            tabindex="-1" role="dialog" 
            aria-labelledby="exampleModalLabel" 
            aria-hidden="true">

            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 v-show="!editMode" class="modal-title" id="exampleModalLabel">Alta Inventario Articulo</h5>
                        <h5 v-show="editMode" class="modal-title" id="exampleModalLabel">Actualizar Cantidad Articulo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header card-header-primary">
                                    <h4 class="card-title">{{articulos.articulo}}</h4>
                                    </div>

                                    <div class="card-body">
                                        <form @submit.prevent="editMode ? updateArticle() : createArticle()">
                                    
                                        <input type="text"  name="articulo_id" hidden v-model="form.articulo_id">
                                        <div class="row">
                                            <div class="form-group col-4">
                                                <label>Cantidad</label>
                                                <input 
                                                    v-model="form.cantidad" 
                                                    type="text" name="cantidad" placeholder="cantidad"
                                                    v-mask="'###'"
                                                    class="form-control" 
                                                    :class="{ 'is-invalid': form.errors.has('cantidad') }">
                                                <has-error :form="form" field="cantidad"></has-error>
                                            </div>

                                            <div class="form-group col-4">
                                                <label>Stock Minimo</label>
                                                <input 
                                                    v-model="form.stockminimo" 
                                                    type="text" name="stockminimo" placeholder="stockminimo"
                                                    v-mask="'###'"
                                                    class="form-control" 
                                                    :class="{ 'is-invalid': form.errors.has('stockminimo') }">
                                                <has-error :form="form" field="stockminimo"></has-error>
                                            </div>


                                        <div class="col-md-4">
                                            <label>Lote</label>
                                                <input 
                                                    v-model="form.lote" 
                                                    type="text" name="lote" placeholder="lote"
                                                    v-mask="'#'"
                                                    class="form-control" 
                                                    :class="{ 'is-invalid': form.errors.has('lote') }">
                                            <has-error :form="form" field="lote"></has-error>
                                        </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Costo</label>
                                                <input 
                                                    v-model="form.preciocosto" 
                                                    type="text" name="preciocosto" placeholder="preciocosto"
                                                    
                                                    class="form-control" 
                                                    :class="{ 'is-invalid': form.errors.has('preciocosto') }">
                                                <has-error :form="form" field="preciocosto"></has-error>
                                            </div>

                                            <div class="col-md-6">
                                                <label>Precio Venta</label>
                                                <input 
                                                    v-model="form.precioventa" 
                                                    type="text" name="precioventa" placeholder="precioventa"
                                                
                                                    class="form-control" 
                                                    :class="{ 'is-invalid': form.errors.has('precioventa') }">
                                                <has-error :form="form" field="precioventa"></has-error>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="col-md-12">
                                            
                                            <label>Vencimiento</label>
                                                <input 
                                                    v-model="form.vencimiento" 
                                                    type="date" name="vencimiento" placeholder="vencimiento"
                                                
                                                    class="form-control cap" 
                                                    :class="{ 'is-invalid': form.errors.has('vencimiento') }">
                                            <has-error :form="form" field="vencimiento"></has-error>
                                        
                                            </div>
                                        </div>

                                        <div class="row">
                                        <div class="col-md-12">
                                        <div class="form-group bmd-form-group">
                                            <label>Proveedor</label>
                                                <select class="form-control" name="proveedor_id"  v-model="form.proveedor_id" >
                                                
                                                <option 
                                                    v-for="proveedor in proveedores" :key="proveedor.id"
                                                    :value="proveedor.id"
                                                    >
                                                    {{ proveedor.proveedor }}
                                                </option>
                                            
                                                </select>
                                        </div>
                                        </div>
                                        </div>

                                        <div class="row">
                                        <div class="col-md-12">
                                        <div class="form-group bmd-form-group">
                                            <label>Movimiento</label>
                                                <select 
                                                    class="form-control" name="tipomovimiento"  v-model="tipomovimiento" >
                                                
                                                    <option value="1">Alta</option>
                                                    <option value="2">Venta</option>
                                                    <option value="3">Devolucion</option>
                                                    <option value="4">Baja x Vencimiento</option>
                                            
                                                </select>
                                        </div>
                                        </div>
                                        </div>


                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                            <button  v-show="editMode" type="submit" class="btn btn-success">Actualizar</button>
                                            <button v-show="!editMode" type="submit" class="btn btn-primary">Crear</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="modal fade bd-example-modal-lg" id="movimiento" 
            tabindex="-1" role="dialog" 
            aria-labelledby="exampleModalLabel" 
            aria-hidden="true">

            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1>Movimiento de Stock</h1>
                    </div>
                    <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form   @submit.prevent="createMov()">

                            <div class="form-group col-6">
                                <label>Stock</label>
                                <input 
                                    v-model="mov.stock" 
                                    type="text" name="stock" placeholder="stock"
                                    v-mask="'###'"
                                    class="form-control" 
                                    :class="{ 'is-invalid': form.errors.has('stock') }">
                                <has-error :form="form" field="stock"></has-error>
                            </div>

                            <div class="form-group col-6">
                                <label>Unidades</label>
                                <input 
                                    v-model="mov.unidades" 
                                    type="text" name="unidades" placeholder="unidades"
                                    v-mask="'###'"
                                    class="form-control" 
                                    :class="{ 'is-invalid': form.errors.has('unidades') }">
                                <has-error :form="form" field="unidades"></has-error>
                            </div>
                             <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                <button  type="submit" class="btn btn-success">Actualizar</button>
                            </div>
                        </form>
                                
                        </div>
                    </div>
                    </div>
                    </div>
                </div>
            </div>

        </div>
        
       
       
    </div>
</div>
</template>

<script>
    export default {
        data(){
            return{
                articulo:{},
                inventarios:{},
                inv :{},
                proveedores:{},
                id:'',
                articulos:{},
                suma:0,
                editMode:false,
                art_id:0,
                tipomovimiento:'',
                

                form: new Form({
                    id:'',
                    articulo_id : '',
                    proveedor_id: '',
                    cantidad: '',
                    stockminimo:'',
                    preciocosto:'',
                    precioventa:'',
                    lote:'',
                    vencimiento: '',
                    
                }),

                mov: new Form({
                    id:'',
                    articulo_id : '',
                    stock: '',
                    unidades:'',
                    movimiento:'',
                    
                })
            }
        },
        watch:{
          tipomovimiento:function(newval, oldval){
              console.log(this.tipomovimiento);
          }

        },
        methods:{
        buscarInventario(cod){
            axios.get('/api/inventario/'+cod)
                        .then(({data})=>(
                            this.inventarios = data.inventario,
                            this.proveedores = data.proveedores,
                            this.articulos = data.articulo[0]
                            ));
           },
        updateArticle(){
              
              this.form.put('/api/inventarios/'+this.form.id)
                .then(()=>{
                  
                    swal(
                          'Actualizado!',
                          'La informacion ha sido actualizada',
                          'success'
                        );
                     $('#inventario').modal('hide');
                    this.buscarInventario(this.id);
                   
                })
                .catch(()=>{

                });


                
            },
        editArticle(inventario){
                // this.form.errors.clear();
                // this.editMode =  true;
                // this.form.reset();
                
                // $('#inventario').modal('show');
                // this.form.fill(inventario);
            if (this.tipomovimiento == 1) {

                this.form.errors.clear();
                this.editMode =  true;
                this.form.reset();
                
                $('#inventario').modal('show');
                this.form.fill(inventario);
            }

            if (this.tipomovimiento == 2) {
                     this.mov.errors.clear();
                    this.mov.reset();
                    this.mov.id = inventario.id;
                    this.mov.articulo_id = this.id;
                    this.mov.stock = inventario.cantidad;
                    this.mov.unidades = '';
                    this.mov.movimiento = 2;
                   $('#movimiento').modal('show');

            }
            if (this.tipomovimiento == 3) {
                    this.form.errors.clear();
                    this.mov.reset();
                    this.mov.id = inventario.id;
                    this.mov.articulo_id = this.id;
                    this.mov.stock = inventario.cantidad;
                    this.mov.unidades = '';
                    this.mov.movimiento = 3;
                   $('#movimiento').modal('show');

            }
            if (this.tipomovimiento == 4) {
                    this.form.errors.clear();
                    this.mov.reset();
                    this.mov.id = inventario.id;
                     this.mov.stock = inventario.cantidad;
                    
                    this.mov.unidades = inventario.cantidad;
                    this.mov.movimiento = 4;
                    this.createMov();
                  
            }
            
               
            },

        newArticle(){
            
            this.editMode = false;
            this.form.reset();
            
            $('#inventario').modal('show');

        },
        createArticle(){
        
            this.form.articulo_id = this.id;
            this.form.post('/api/inventarios').then(()=>{
                this.buscarInventario(this.id);
                $('#inventario').modal('hide');
                
                toast({
                    type: 'success',
                    title: 'Articulo creado'
                    })
                }).catch(()=>{

            });
                
            },

        createMov(){

            
            this.mov.articulo_id = this.id;

            this.mov.post('/api/moverinventario/'+ this.mov.id).then(()=>{
                
                $('#movimiento').modal('hide'),
               this.buscarInventario(this.id),
                   
            toast({
                    type: 'success',
                    title: 'Articulo modificado',
                   
                    })
                }).catch(()=>{

            });

        }
        },
        created(){
             this.id = this.$route.params.id;
           
        },
       
        mounted () {
            this.buscarInventario(this.id);
            this.articulo = this.articulo.articulo;
        
        }
        
    }
</script>
