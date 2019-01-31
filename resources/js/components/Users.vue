<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Responsive Hover Table</h3>

                <div class="card-tools">
                    <button class="btn btn-success" @click="newUser" >
                      <i class="fas fa-user-plus"></i>
                      Nuevo Usuario
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
                    <th>Tipo</th>
                    <th>Registrado</th>
                    <th>Editar</th>
                  </tr>

                  <tr v-for="user in users" :key="user.id">
                    <td >{{user.id}}</td>
                    <td >{{user.name}}</td>
                    <td >{{user.email}}</td>
                    <td><span class="tag tag-success">{{user.type|upText}}</span></td>
                    <td>{{user.created_at|myDate}}</td>
                    <td>
                        <a @click="editUser(user)" href="#">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a  @click="deleteUser(user.id)">
                            <i class="fas fa-trash-alt red"></i>
                        </a>
                        
                    </td>
                  </tr>
                
                
                  
                </tbody></table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- Modal -->
            <div class="modal fade" id="usuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 v-show="!editMode" class="modal-title" id="exampleModalLabel">Nuevo Usuario</h5>
                    <h5 v-show="editMode" class="modal-title" id="exampleModalLabel">Actualizar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editMode ? updateUser() : createUser()">
                <div class="modal-body">
                    <div class="form-group">
                    <label>Nombre</label>
                    <input v-model="form.name" type="text" name="name" placeholder="Name" 
                        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                    <has-error :form="form" field="name"></has-error>
                    </div>

                    <div class="form-group">
                    <label>Email</label>
                    <input v-model="form.email" type="text" name="email" placeholder="Email" 
                        class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                    <has-error :form="form" field="email"></has-error>
                    </div>
                    <div class="form-group">
                         <label>Password</label>
                        <input v-model="form.password" type="password" name="password" id="password"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                        <has-error :form="form" field="password"></has-error>
                    </div>
                     <div class="form-group">
                         <label>Bio</label>
                        <textarea v-model="form.bio" name="bio" id="bio"
                        placeholder="Desc. del usuario (Optional)"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                        <has-error :form="form" field="bio"></has-error>
                    </div>
                    <div class="form-group">
                         <label>Seecciona Tipo de Usuario</label>
                        <select name="type" v-model="form.type" id="type" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                            <option value="">Select User Role</option>
                            <option value="admin">Admin</option>
                            <option value="user">Standard User</option>
                            <option value="author">Author</option>
                        </select>
                        <has-error :form="form" field="type"></has-error>
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

                form: new Form({
                    id:'',
                    name : '',
                    email: '',
                    password: '',
                    type: '',
                    bio: '',
                    photo: '',
                   
                })
            }
        },
        methods:{
            updateUser(){
                this.form.put('api/user/'+this.form.id)
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
                this.editMode =  true;
                this.form.reset();
                $('#usuario').modal('show');
                this.form.fill(user);

            },
            newUser(){
                this.editMode = false;
                this.form.reset();
                $('#usuario').modal('show');

            },
            deleteUser(id){
                swal({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {

                    this.form.delete('api/user/'+id).then(()=>{
                          if (result.value) {
                            swal(
                              'Deleted!',
                              'Your file has been deleted.',
                              'success'
                            );
                            this.loadUsers();
                          }
                    }).catch(()=>{

                    });

                
                })
            },
            loadUsers(){
                axios.get('api/user').then(({data})=>(this.users = data.data));

            },
            createUser(){

                this.form.post('api/user').then(()=>{
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
            this.loadUsers();
            // setInterval(()=>this.loadUsers(),15000);


        }
    }
</script>
