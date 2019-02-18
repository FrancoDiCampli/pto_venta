<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Categorias</h3>
                
                <div class="card-tools">
                    <button class="btn btn-success" @click="newCategory" >
                      <i class="fas fa-user-plus"></i>
                      Nueva Categoria
                    </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody>

                    <tr>
                    <th>ID</th>
                    <th>Categoria</th>
                   
                    <th>Editar</th>
                  </tr>

                  <tr v-for="categoria in categorias.data" :key="categoria.id">
                    <td >{{categoria.id}}</td>
                    <td >{{categoria.categoria}}</td>
                  
                    <td>
                        <a @click="editCategory(categoria)" href="#">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a  @click="deleteCategory(categoria.id)">
                            <i class="fas fa-trash-alt red"></i>
                        </a>
                        
                    </td>
                  </tr>
                
                
                  
                </tbody></table>
              </div>
              <!-- /.card-body -->
              <div class="card-foote">
                  <pagination :data="categorias" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- Modal -->
            <div class="modal fade" id="usuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 v-show="!editMode" class="modal-title" id="exampleModalLabel">Nueva Categoria</h5>
                    <h5 v-show="editMode" class="modal-title" id="exampleModalLabel">Actualizar Categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editMode ? updateCategory() : createCategory()">
                <div class="modal-body">
                    <div class="row">

                    <div class="form-group col-7">
                    <label>Categoria</label>
                    <input v-model="form.categoria" type="text" name="categoria" placeholder="categoria" 
                        class="form-control cap" :class="{ 'is-invalid': form.errors.has('categoria') }">
                    <has-error :form="form" field="categoria"></has-error>
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
                categorias:{},
               
                busqueda:{},

                form: new Form({
                    id:'',
                    categoria : '',
                   
                })
            }
        },
        methods:{
             deleteCategory(id){
                swal({
                  title: 'Estas Seguro?',
                  text: "Estas a punto de eliminar una categoria!",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, eliminalo!'
                }).then((result) => {

                    this.form.delete('api/categorias/'+id).then(()=>{
                          if (result.value) {
                            swal(
                              'Eliminado!',
                              'success'
                            );
                            this.loadCategorias();
                          }
                    }).catch(()=>{

                    });

                
                })
            },
            getResults(page = 1) {
                        axios.get('api/categorias?page=' + page)
                            .then(response => {
                                this.categorias = response.data;
                            });
            },
            
           
            updateCategory(){
              
                this.form.put('api/categorias/'+this.form.id)
                .then(()=>{
                    $('#usuario').modal('hide');
                    this.loadCategorias();
                    swal(
                          'Actualizado!',
                          'La informacion ha sido actualizada',
                          'success'
                        );
                   
                })
                .catch(()=>{

                });
            },
            editCategory(categoria){
                this.form.errors.clear();
                this.editMode =  true;
                this.form.reset();
                
                $('#usuario').modal('show');
                this.form.fill(categoria);
               
            },
          
            newCategory(){
                this.editMode = false;
                this.form.reset();
                $('#usuario').modal('show');

            },
            loadCategorias(){
                this.form.reset();
                axios.get('api/categorias')
                        .then(({data})=>(this.categorias = data));


            },
           
            createCategory(){
               
                this.form.post('api/categorias').then(()=>{
                   
                    $('#usuario').modal('hide');
                    this.loadCategorias();
                    toast({
                        type: 'success',
                        title: 'Categoria creada'
                    })
                }).catch(()=>{

                });
                

            }
        },
        created() {
           
            Fire.$on('searching',()=>{
                let query = this.$parent.search;
               axios.get('api/findCategoria?q='+query)
                .then((data)=>{
                    this.categorias = data.data;
                  
                })
                .catch(()=>{

                })
            });

            this.loadCategorias();
            

        }
    }
</script>
