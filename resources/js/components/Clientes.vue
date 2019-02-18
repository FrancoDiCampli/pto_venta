<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Lista de Clientes</h3>
              
                <div class="card-tools">
                    <button class="btn btn-success" @click="newUser" >
                      <i class="fas fa-user-plus"></i>
                      Nuevo Cliente
                    </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody>

                    <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Foto</th>
                    <th>Registrado</th>
                    <th>Editar</th>
                  </tr>

                  <tr v-for="user in users.data" :key="user.id">
                    <td >{{user.id}}</td>
                    <td >{{user.nombre}}</td>
                    <td >{{user.mail}}</td>
                    <td><img :src="user.foto" style="width:120px;"></td>
                    <td>{{user.created_at|myDate}}</td>
                    <td>
                        <a @click="editUser(user)" href="#">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a  @click="deleteCliente(user.id)">
                            <i class="fas fa-trash-alt red"></i>
                        </a>
                        
                    </td>
                  </tr>
                
                
                  
                </tbody></table>
              </div>
              <!-- /.card-body -->
              <div class="card-foote">
                  <pagination :data="users" @pagination-change-page="getResults"></pagination>
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
                    <h5 v-show="!editMode" class="modal-title" id="exampleModalLabel">Nuevo Cliente</h5>
                    <h5 v-show="editMode" class="modal-title" id="exampleModalLabel">Actualizar Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editMode ? updateUser() : createUser()">
                <div class="modal-body">
                    <div class="row">

                    <div class="form-group col-7">
                    <label>Nombre</label>
                    <input v-model="form.nombre" type="text" name="nombre" placeholder="Nombre" 
                        class="form-control cap" :class="{ 'is-invalid': form.errors.has('nombre') }">
                    <has-error :form="form" field="nombre"></has-error>
                    </div>

                    
                    <div class="form-group col-5">
                    <label>DNI</label>
                    <input
                       
                        v-model="form.doc" 
                        type="text" 
                        name="doc" placeholder="DNI" 
                        v-mask="'##.###.###'"
                        @keyup.enter="validarInputs"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('doc') }">
                    <has-error :form="form" field="doc"></has-error>
                    </div>
                </div>

                <div class="row">

                    <div class="form-group col-8">
                    <label>Direccion</label>
                    <input v-model="form.direccion" type="text" name="direccion" placeholder="Direccion" 
                        class="form-control cap" :class="{ 'is-invalid': form.errors.has('direccion') }">
                    <has-error :form="form" field="direccion"></has-error>
                    </div>
                    <div class="form-group col-4">
                    <label>CP</label>
                    <input v-model="form.cp" type="text" name="cp" placeholder="CP" 
                        class="form-control" :class="{ 'is-invalid': form.errors.has('cp') }">
                    <has-error :form="form" field="cp"></has-error>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-7">
                    <label>Email</label>
                    <input v-model="form.mail" type="email" name="email" placeholder="Email" 
                        class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                    <has-error :form="form" field="email"></has-error>
                    </div>
                    <div class="form-group col-5">
                        <label>Telefono</label>
                        <input v-model="form.telefono" 
                        v-mask="'(####)##-####'"
                        type="text" name="telefono" id="telefono"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('telefono') }">
                        <has-error :form="form" field="telefono"></has-error>
                    </div>
                </div>

                  
                        <div class="form-check">
                        <input 
                            type="checkbox" 
                            v-model="form.percibeiva" 
                            
                            name="percibeiva"
                            class="form-check-input" 
                            id="percibeiva"
                             true-value="1"
                            false-value="0"
                            :class="{ 'is-invalid': form.errors.has('percibeiva') }">
                        <label class="form-check-label" for="percibeiva">IVA</label>
                        </div>
                  
                        <div class="form-check">
                        <input 
                            type="checkbox" 
                            v-model="form.percibeiibb" 
                            name="percibeiibb"
                            class="form-check-input" 
                            id="percibeiibb"
                             true-value="1"
                            false-value="0"
                            :class="{ 'is-invalid': form.errors.has('percibeiibb') }">
                        <label class="form-check-label" for="percibeiibb">Ing.Brutos</label>
                        </div>

                        <div class="form-check">
                        <input 
                            type="checkbox" 
                            v-model="form.enviarcomprobante" 
                            name="enviarcomprobante"
                            class="form-check-input" 
                            id="enviarcomprobante"
                             true-value="1"
                            false-value="0"
                            :class="{ 'is-invalid': form.errors.has('enviarcomprobante') }">
                        <label class="form-check-label" for="enviarcomprobante">Enviar Comprobante</label>
                        </div>

                        <div class="form-check">
                        <input
                            
                            type="checkbox" 
                            v-model="form.estado" 
                            name="estado"
                            class="form-check-input" 
                            id="estado"
                            true-value="1"
                            false-value="0"
                            :class="{ 'is-invalid': form.errors.has('estado') }">
                        <label class="form-check-label" for="estado">Activo</label>
                        </div>

                   

                    

                <div class="row">
                    <div class="form-group col-7">
                        <label>Condicion de pago</label>
                        <select name="condicionpago" v-model="form.condicionpago" id="condicionpago" class="form-control" :class="{ 'is-invalid': form.errors.has('condicionpago') }">
                            <option value="">Selecciona condicion de pago</option>
                            <option value="contado">Contado</option>
                            <option value="ctacte">Cta Cte</option>
                            <option value="cheque">Cheque</option>
                            <option value="tcredito">T. Credito</option>
                        </select>
                        <has-error :form="form" field="type"></has-error>
                    </div>
                    
                    <div class="form-group col-5">
                    <label>Foto</label>
                    <img :src="image" class="profile-user-img img-responsive" style="max-width:100%">
                    <input type="file" v-on:change="onFileChange" class="form-control">
                    
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
                users:{},
                image:'',
                busqueda:{},

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

                })
            }
        },
        watch:{
            
        },
        methods:{
             deleteCliente(id){
                swal({
                  title: 'Estas Seguro?',
                  text: "Estas a punto de eliminar un cliente!",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, eliminalo!'
                }).then((result) => {

                    this.form.delete('api/clientes/'+id).then(()=>{
                          if (result.value) {
                            swal(
                              'Eliminado!',
                              'success'
                            );
                            this.loadUsers();
                          }
                    }).catch(()=>{

                    });

                
                })
            },
            getResults(page = 1) {
                        axios.get('api/clientes?page=' + page)
                            .then(response => {
                                this.users = response.data;
                            });
            },
            
             onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            updateUser(){
              
                this.form.foto = this.image;
               this.validarInputs();
                this.form.put('api/clientes/'+this.form.id)
                .then(()=>{
                    $('#usuario').modal('hide');
                    this.loadUsers();
                    swal(
                          'Updated!',
                          'La informacion ha sido actualizada',
                          'success'
                        );
                   
                })
                .catch(()=>{

                });
            },
            editUser(user){
                this.form.errors.clear();
                this.editMode =  true;
                this.form.reset();
                
                $('#usuario').modal('show');
                this.form.fill(user);
                // this.checkeando(user);
                
                this.image = user.foto;
              
            },
          
            newUser(){
               
                this.editMode = false;
                this.form.reset();
                this.image = '';
                $('#usuario').modal('show');

            },
            
            validarInputs(){
               var cad = this.form.doc;
               

               this.form.doc = cad.replace(/\./g, '');
               

              
            },
            loadUsers(){
                this.form.reset();
                axios.get('api/clientes')
                        .then(({data})=>(this.users = data));


            },
           
            createUser(){
                
                this.form.foto = this.image;
               
               this.validarInputs();
                this.form.post('api/clientes').then(()=>{
                   
                    $('#usuario').modal('hide');
                    this.loadUsers();
                    toast({
                        type: 'success',
                        title: 'Usuario creado'
                    })
                }).catch(()=>{

                });
                

            }
        },
        created() {
           
            Fire.$on('searching',()=>{
                let query = this.$parent.search;
               axios.get('api/findCliente?q='+query)
                .then((data)=>{
                    this.users = data.data;
                    console.log(this.users);
                })
                .catch(()=>{

                })
            });

            this.loadUsers();
            

        }
    }
</script>
