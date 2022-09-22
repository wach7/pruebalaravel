<template>
  <div class="pt-3 container">
    <h1>LISTA DE USUARIOS</h1>
    <input type="text" class="form-control" v-model="filtro" placeholder="Buscar contactos">
    <div class="div-tabla">
      <table class="table mt-3">
        <thead>
          <tr>
            <th>#</th>
            <th>Cedula</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Categoria</th>
            <th>Direccion</th>
            <th>Celular</th>
            <th>Email</th>
            <th>Actualizar</th>
            <th>Borrar</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in filterUsuarios">
            <td>{{ index+1 }}</td>
            <td>{{ item.cedula }}</td>
            <td>{{ item.nombre }}</td>
            <td>{{ item.apellidos }}</td>
            <td>{{ item.categoria }}</td>
            <td>{{ item.direccion }}</td>
            <td>{{ item.celular }}</td>
            <td>{{ item.email }}</td>
            <td>
              <router-link class="btn btn-sm btn-warning" :to="'/actualizar/' + item.id">Actualizar</router-link>
            </td>
            <td><button class="btn btn-sm btn-danger" @click="deleteUsuarios(item.id)">Eliminar</button></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="text-center">
      {{ nodata }}
    </div>
  </div>
</template>

<script>
  // @ is an alias to /src
  import axios from 'axios'
  import Swal from 'sweetalert2'

  export default {
    data() {
      return {
        Usuarios: [],
        filtro: '',
        nodata: '',
        ENDPOINT: 'http://localhost:8000/api/'
      }
    },
    beforeCreate() {
      document.title = 'Lista de Contactos'
    },
    mounted() {
      this.getUsuarios();
    },
    methods: {
      getUsuarios() {
        axios.get(this.ENDPOINT + 'getUsuarios')
          .then(response => {
            this.Usuarios = []
            if (response.data.error) {
              this.nodata = 'No hay contactos registrados'
            }
            else {
              this.Usuarios = response.data.datos
              this.nodata = '';
            }
          })
          .catch(error => {
            console.log('Ha ocurrido un error', error)
          })
      },
      deleteUsuarios(id) {
        Swal.fire({
          title: '¿Estas seguro?',
          text: "Los datos borrados no podrán ser recuperados",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, eliminar',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.isConfirmed) {
            axios.delete(this.ENDPOINT + 'deleteUsuarios/' + id)
              .then(response => {
                if (response.data.error) {
                  Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: response.data.mensaje,
                  })
                }
                else {
                  Swal.fire(
                    'Eliminado',
                    response.data.mensaje,
                    'success'
                  )
                  this.getUsuarios();
                }
              })
              .catch(error => {
                console.log('Ha ocurrido un error', error)
              })

          }
        })
      }
    },
    computed: {
      filterUsuarios: function () {
        return this.Usuarios.filter(usuarios => {
          return usuarios.nombre.match(this.filtro) || 
          usuarios.nombre.toLowerCase().match(this.filtro) || 
          usuarios.email.match(this.filtro) || 
          usuarios.email.toLowerCase().match(this.filtro) ||
          usuarios.apellidos.match(this.filtro) || 
          usuarios.apellidos.toLowerCase().match(this.filtro)
        })
      }
    }
  }
</script>

<style>
  .div-tabla{
    overflow-x: auto;
    overflow-y: auto;
  }
</style>