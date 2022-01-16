<template>
  <cities-view></cities-view>
</template>

<script>
import CitiesView from './components/CitiesView'

export default {
  name: 'App',
  components: {    
    CitiesView
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
