<template>
    <div class="pt-3 container">
        <div style="width: 600px;">
            <h1>Correo administrador actual:</h1>
            {{ correoActual }}
            <br>
            <br>
            <h2>Cambiar correo de administrador</h2>
            <input type="text" class="form-control mb-3" v-model="correoNuevo" placeholder="Nuevo correo">
            <button class="btn btn-sm btn-danger float-end" @click="cambiarCorreoAdministrador()">Cambiar correo</button>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import Swal from 'sweetalert2'
import toastr from 'toastr'

export default {
    data() {
        return {
            correoActual: "",
            correoNuevo: "",
            ENDPOINT: 'http://localhost:8000/api/'
            
        }
    },
    beforeCreate() {
      document.title = 'Configuración Correo Administrador'
    },
    mounted() {
        this.getCorreoAdministrador();
    },
    methods: {
        getCorreoAdministrador(){
            axios.get(this.ENDPOINT + 'getCorreoAdministrador')
            .then(response => {
                if (!response.data.error){
                    this.correoActual = response.data.datos.correo
                }else{
                    this.correoActual = response.data.mensaje
                }
            })
            .catch( err => {
                console.log("error", err)
            })
        },
        cambiarCorreoAdministrador(){
            if (!this.validEmail(this.correoNuevo)) {
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
                    axios.put(this.ENDPOINT + 'cambiarCorreoAdministrador', { correo: this.correoNuevo})
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
                        this.getCorreoAdministrador()
                        this.correoNuevo = ""
                        }
                    })
                    .catch( err => {
                        console.log("error", err)
                    })
                }
            })
        },
        validEmail: function (email) {
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }
    },
}
</script>