<template>
  <NavComponent/>
  <router-view/>
</template>

<script>
import NavComponent from './components/NavComponent.vue'
export default {
  data() {
    return {
      
    }
  },
  components: {
    NavComponent
  }
}
</script>
