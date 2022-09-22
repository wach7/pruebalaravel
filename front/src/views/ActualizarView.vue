<template>
  <div class="pt-3 container">
    <h1>ACTUALIZAR USUARIO</h1>
    <div class="form">
      <div class="mb-2">
        <label for="cedula" class="form-label">Cédula</label>
        <input type="text" class="form-control" maxlength="11" name="cedula" id="cedula" @keydown="solo_numeros()" v-model="usuario.cedula" placeholder="Cedula">
      </div>
      <div class="mb-2">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" maxlength="100" minlength="5" name="nombre" id="nombre" @keydown="solo_letras()" v-model="usuario.nombre" placeholder="Nombre">
      </div>
      <div class="mb-2">
        <label for="apellidos" class="form-label">Apellidos</label>
        <input type="text" class="form-control" maxlength="100" name="apellidos" id="apellidos" @keydown="solo_letras()" v-model="usuario.apellidos" placeholder="Apellidos">
      </div>
      <div class="mb-2">
        <label for="categoria" class="form-label">Categoria</label>
        <select class="form-control" name="categoria" id="categoria" v-model="usuario.categoria">
          <option value="">Seleccione una opción</option>
          <option v-for="item in Categorias" :value="item.id">{{ item.categoria }}</option>
        </select>
      </div>
      <div class="mb-2">
        <label for="direccion" class="form-label">Dirección</label>
        <input type="text" class="form-control" maxlength="180" name="direccion" id="direccion" v-model="usuario.direccion" placeholder="Dirección">
      </div>
      <div class="mb-2">
        <label for="celular" class="form-label">Celular</label>
        <input type="text" class="form-control" maxlength="10" name="celular" id="celular" @keydown="solo_numeros()" v-model="usuario.celular" placeholder="Celular">
      </div>
      <div class="mb-2">
        <label for="email" class="form-label">Email</label>
        <input type="text" class="form-control" maxlength="150" name="email" id="email" v-model="usuario.email" placeholder="Email">
      </div>
      <div class="float-end mt-3">
        <button class="btn btn-sm btn-warning me-2" @click="updateContacts()">Actualizar</button>
        <router-link class="btn btn-sm btn-danger" to="/">Cancelar</router-link>
      </div>
    </div>
  </div>
</template>

<script>
  import axios from 'axios';
  import Swal from 'sweetalert2'
  import toastr from 'toastr'

  export default {
    data() {
      return {
        usuario: {},
        Categorias: [],
        ENDPOINT: 'http://localhost:8000/api/'
      }
    },
    beforeCreate() {
      document.title = 'Actualizar Usuario'
    },
    mounted() {
      this.getCategorias();
      if (this.$route.params.id != undefined) {
        this.llenar_lista();
      }
    },
    methods: {
      llenar_lista() {
        axios.get(this.ENDPOINT + 'getUsuario/' + this.$route.params.id)
          .then(response => {
            if (response.data.error) {
              alert(response.data.mensaje)
            }
            else {
              this.usuario = response.data.datos
              this.usuario.categoria = this.usuario.categoria_id
            }
          })
          .catch(error => {
            console.log('Ha ocurrido un error', error)
          })
      },
      getCategorias(){
        axios.get(this.ENDPOINT + 'getCategorias')
        .then(response => {
          if (response.data.error) {
            
          }
          else {
            this.Categorias = response.data.datos
          }
        })
        .catch(err => {
          console.log('ha ocurrido un error', err)
        })
      },
      updateContacts() {
        var validar = this.validar_campos();
        if (validar.error){
          toastr.error(validar.mensaje, 'Error!')
          return 
        }
        if (!this.validEmail(this.usuario.email)) {
          toastr.error('El email electrónico debe ser válido.', 'Error!');
          return
        }
        Swal.fire({
          title: '¿Estas seguro?',
          text: "¿Desea actualizar este usuario?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Sí, actualizar',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.isConfirmed) {

            axios.put(this.ENDPOINT + 'updateUsuarios', this.usuario)
              .then(response => {
                if (response.data.error) {
                  Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: response.data.mensaje
                  })
                }
                else {
                  Swal.fire({
                    icon: 'success',
                    title: '¡Bien!',
                    text: response.data.mensaje
                  })
                  this.usuario = {}
                  this.$router.push('/')
                }
              })
              .catch(error => {
                console.log('Ha ocurrido un error', error)
              })

          }

        })
      },
      validar_campos() {
        var result = {
          mensaje: "Listo",
          error: false
        };
        if (this.usuario.cedula == "") {
          result.error = true;
          result.mensaje = "En campo cédula es requerido";
          return result;
        }
        if (this.usuario.nombre == "") {
          result.error = true;
          result.mensaje = "En campo nombre es requerido";
          return result;
        }
        if (this.usuario.nombre.length < 5 || this.usuario.nombre.length > 100) {
          result.error = true;
          result.mensaje = "El campo nombre acepta desde 5 hasta 100 caracteres";
          return result;
        }
        if (this.usuario.apellidos == "") {
          result.error = true;
          result.mensaje = "En campo apellido es requerido";
          return result;
        }
        if (this.usuario.categoria == "") {
          result.error = true;
          result.mensaje = "En campo categoria es requerido";
          return result;
        }
        if (this.usuario.direccion == "") {
          result.error = true;
          result.mensaje = "En campo dirección es requerido";
          return result;
        }
        if (this.usuario.celular == "") {
          result.error = true;
          result.mensaje = "En campo celular es requerido";
          return result;
        }
        if (this.usuario.celular.length > 10) {
          result.error = true;
          result.mensaje = "En campo celular solo acepta 10 caracteres";
          return result;
        }
        if (this.usuario.email == "") {
          result.error = true;
          result.mensaje = "En campo email es requerido";
          return result;
        }
        if (this.usuario.email.length > 150) {
          result.error = true;
          result.mensaje = "El campo email solo acepta 150 caracteres";
          return result;
        }
        return result;
      },
      solo_numeros() {
        // Si el código es menor que 48 (0) o mayor que 57 (9)
        if((event.keyCode < 48 || event.keyCode > 57) && event.keyCode != 8) {
          // No se agrega
          event.preventDefault();
        }
      },
      solo_letras() {
        // Si el código es menor que 48 (0) o mayor que 57 (9)
        if(event.keyCode >= 48 && event.keyCode <= 57) {
          event.preventDefault();
        }
      },
      validEmail: function (email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
      }
    }
  }
</script>