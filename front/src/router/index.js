import { createRouter, createWebHistory } from 'vue-router'
import ListaView from '../views/ListaView.vue'
import RegistroView from '../views/RegistroView.vue'
import ActualizarView from '../views/ActualizarView.vue'
import ConfigurarMail from '../views/ConfiguracionMail.vue'

const routes = [
  {
    path: '/',
    name: 'Lista',
    component: ListaView
  },
  {
    path: '/registrar',
    name: 'Registro',
    component: RegistroView
  },
  {
    path: '/actualizar/:id',
    name: 'Actualizar',
    component: ActualizarView
  },
  {
    path: '/configurarMail',
    name: 'configurarMail',
    component: ConfigurarMail
  },
  {
    path: '/:pathMatch(.*)*',
    redirect: '/'
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
