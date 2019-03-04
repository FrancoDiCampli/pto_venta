<template>
    <div class="contaner">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        
                        <h3 class="card-title">Proveedores</h3>

                        <div class="card-tools">
                            <button class="btn btn-success" @click="newSupplier" >
                                <i class="fas fa-user-plus"></i>
                                Nuevo Proveedor
                            </button>
                        </div>

                        <div class="card-body table-responsive p-0">                            
                            <table class="table table-hover">                            
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <th>Proveedor</th>
                                        <th>CUIT</th>
                                        <th>Direccion</th>
                                        <th>Telefono</th>

                                        <th>Acciones</th>
                                    </tr>
                                    <tr v-for="supplier in suppliers.data" :key="supplier.id">
                                        <td>{{supplier.id}}</td>
                                        <td>{{supplier.proveedor}}</td>
                                        <td>{{supplier.cuit}}</td>
                                        <td>{{supplier.direccion}}</td>
                                        <td>{{supplier.telefono}}</td>
                                        <td>
                                            <a @click="editSupplier(supplier)">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a @click="deleteSupplier(supplier.id)">
                                                <i class="fas fa-trash-alt red"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>                        
                            </table>
                        </div>

                        <div class="card-foote">
                            <pagination :data="suppliers" @pagination-change-page="getResults"></pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="supplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-show="!editMode" class="modal-title" id="exampleModalLabel">Nuevo Proveedor</h5>
                        <h5 v-show="editMode" class="modal-title" id="exampleModalLabel">Actualizar Proveedor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? updateSupplier() : createSupplier()">
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-7">
                                    <label>Proveedor</label>
                                    <input v-model="form.proveedor" type="text" name="proveedor" placeholder="proveedor" 
                                    class="form-control cap" :class="{ 'is-invalid': form.errors.has('proveedor') }">
                                    <has-error :form="form" field="proveedor"></has-error>

                                    <label >CUIT</label>
                                    <input v-model="form.cuit" type="text" name="cuit" placeholder="cuit" 
                                    class="form-control cap" :class="{ 'is-invalid': form.errors.has('cuit') }">
                                    <has-error :form="form" field="cuit"></has-error>

                                    <label >Direccion</label>
                                    <input v-model="form.direccion" type="text" name="direccion" placeholder="direccion" 
                                    class="form-control cap" :class="{ 'is-invalid': form.errors.has('direccion') }">
                                    <has-error :form="form" field="direccion"></has-error>

                                    <label >Telefono</label>
                                    <input v-model="form.telefono" type="text" name="telefono" placeholder="telefono" 
                                    class="form-control cap" :class="{ 'is-invalid': form.errors.has('telefono') }">
                                    <has-error :form="form" field="telefono"></has-error>
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
        <!-- end Modal -->
    </div>
</template>

<script>
    export default {
        data(){
            return{
                editMode: false,
                suppliers:{},
               
                busqueda:{},

                form: new Form({
                    id:'',
                    proveedor : '',
                    cuit : '',
                    direccion : '',
                    telefono : '',
                   
                })
            }
        },
        methods:{
             deleteSupplier(id){
                swal({
                  title: 'Estas Seguro?',
                  text: "Estas a punto de eliminar un proveedor!",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, eliminalo!'
                }).then((result) => {

                    this.form.delete('api/suppliers/'+id).then(()=>{
                          if (result.value) {
                            swal(
                              'Eliminado!',
                              'success'
                            );
                            this.loadSuppliers();
                          }
                    }).catch(()=>{

                    });

                
                })
            },
            getResults(page = 1) {
                        axios.get('api/suppliers?page=' + page)
                            .then(response => {
                                this.suppliers = response.data;
                            });
            },
            
           
            updateSupplier(){
              
                this.form.put('api/suppliers/'+this.form.id)
                .then(()=>{
                    $('#supplier').modal('hide');
                    this.loadSuppliers();
                    swal(
                          'Actualizado!',
                          'La informacion ha sido actualizada',
                          'success'
                        );
                   
                })
                .catch(()=>{

                });
            },
            editSupplier(supplier){
                this.form.errors.clear();
                this.editMode =  true;
                this.form.reset();
                
                $('#supplier').modal('show');
                this.form.fill(supplier);
               
            },
          
            newSupplier(){
                this.editMode = false;
                this.form.reset();
                $('#supplier').modal('show');

            },
            loadSuppliers(){
                this.form.reset();
                axios.get('api/suppliers')
                        .then(({data})=>(this.suppliers = data));


            },
           
            createSupplier(){
               
                this.form.post('api/suppliers').then(()=>{
                   
                    $('#supplier').modal('hide');
                    this.loadSuppliers();
                    toast({
                        type: 'success',
                        title: 'Proveedor creado'
                    })
                }).catch(()=>{

                });
                

            }
        },
        created() {
           
            Fire.$on('searching',()=>{
                let query = this.$parent.search;
               axios.get('api/findSupplier?q='+query)
                .then((data)=>{
                    this.suppliers = data.data;
                  
                })
                .catch(()=>{

                })
            });

            this.loadSuppliers();
            

        }
    }
</script>

