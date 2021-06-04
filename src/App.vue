<template>
  <div id="app">
    <v-snackbar
        :timeout="3000"
        v-model="empty"
        absolute
        color="#c90000"
        elevation="24"
        bottom
    >
      Veuillez renseigner les champs
    </v-snackbar>
    <v-snackbar
        :timeout="3000"
        v-model="valid"
        absolute
        color="#00c120"
        elevation="24"
        bottom
    >
      Benvenue {{$store.state.prenom}} {{$store.state.nom}}
    </v-snackbar>
    <div class="wrapper">
      <b-navbar class="nav" toggleable="lg" type="dark" variant="dark">
        <b-navbar-brand to="/">Portfolio 2021</b-navbar-brand>

        <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

        <b-collapse id="nav-collapse" is-nav>
          <b-navbar-nav>
            <b-nav-item to="/informations">Projets</b-nav-item>
            <b-nav-item href="#">Formation</b-nav-item>
          </b-navbar-nav>
          <!-- Right aligned nav items -->
          <b-navbar-nav class="ml-auto">
          </b-navbar-nav>
        </b-collapse>
      </b-navbar>

      <router-view></router-view>
    </div>

    <footer>
      <a href="/mentionlegales">Mentions légales</a>
    </footer>
  </div>
</template>

<script>

export default {
  name: 'App',
  components: {
  },
  data(){
    return {
      connected : false,
      nom: "",
      prenom: "",
      email: "",
      empty: false,
      valid: false
    }
  },
  methods: {
    connect(){
      if (this.prenom === "" && this.nom === "" && this.email === "") {
        this.empty = true
      }else{
        this.connected = true
        this.valid = true
        this.changeNomPrenom({prenom: this.prenom, nom: this.nom, email: this.email})
        this.$router.push('/user');
      }
    },
    disconnect(){
      this.$store.dispatch('resetUser')
      this.connected = false
      console.log(this.connected)
      this.nom = ""
      this.prenom = ""
      this.email= ""
    },
    changeNomPrenom(payload){
      this.$store.dispatch('updateUser', payload)
    }
  }
}
</script>

<style lang="css">
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

@font-face {
  font-family: "Bebas Neue";
  src: url("./assets/fonts/BebasNeue-Regular.woff2") format("woff2");
}

.nav {
  font-family: 'Bernard MT Condensed';
}

.form-inline {
  flex-flow: row !important;
}

.connexion {
  line-height: 20px !important;
  max-width: fit-content !important;
}

.btn {
  color: #fff;
  cursor: pointer;
  font-size: 1.7rem !important;
  line-height: 45px;
  margin: 0;
  max-width: 160px;
  position: relative;
  text-decoration: none;
  text-transform: uppercase;
  width: 100%;

}

.btn:hover {
  text-decoration: none;
}

.btn-1 {
  font-size: 2rem;
}

.btn-1 svg {
  height: 51px;
  left: 0;
  position: absolute;
  top: 0;
  width: 100%;
}

.btn-1 rect {
  fill: none;
  stroke: #fff;
  stroke-width: 2;
  stroke-dasharray: 422, 0;
  transition: all 0.35s linear;
}

.btn-1:hover {
  font-weight: 900;
  letter-spacing: 1px;
}

.btn-1:hover rect {
  stroke-width: 5;
  stroke-dasharray: 15, 310;
  stroke-dashoffset: 48;
  transition: all 1.35s cubic-bezier(0.19, 1, 0.22, 1);
}

.wrapper {
  height: 100vh;
  overflow-x: hidden;
  overflow-y: auto;
  perspective: 2px;
  background-color: #343A40;
}

.title {
  background-color: rgba(255, 255, 255, 0.5);
  padding: 2rem;
  border-radius: 30px;
}

.section {
  position: relative;
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-family: 'Bebas Neue';
  text-shadow: 0 0 5px #000;
}

@media screen and (min-width: 600px) {
  .section {
    flex-direction: column;
  }

  .infos {
    width: 80%;
    height: 80vh;
    margin: 0 auto;
    justify-content: space-evenly;
    flex-direction: row;
  }

  .infos div{
    width: 25%;
  }
}

@media (min-width: 0px) and (max-width: 600px) {
  .section {
    flex-direction: column;
    height: 320px;
  }

  .infos {
    width: 80%;
    height: 80vh;
    margin: 0 auto;
    justify-content: space-evenly;
    flex-direction: column;
  }

  .infos div{
    width: 80%;
    margin-bottom: 2rem;
  }
}

.infos div {
  color: black;
  text-shadow: 0 0 5px #000;
  background-color: white;
  border-radius: 30px;
  padding: 2rem;
  height: 300px;
  text-shadow: none;
}

.parallax::after {
  content: " ";
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  transform: translateZ(-1px) scale(1.5);
  background-size: 100%;
  z-index: -1;
}

.bg1::after {
  background-image: url('./assets/img/avengers.jpg');
}

h1 {
  font-size: 5rem;
  color: white;
  font-family: 'Bebas Neue';
}

a {
  font-size: 1rem;
}

em {
  margin-right: 1rem;
}

p{
  color: white;
}
</style>
