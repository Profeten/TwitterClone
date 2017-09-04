<template>
  <div v-on:keyup.esc="closeMentionBox" class="container-fluid">
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            Search for a user
            <button v-on:click="closeMentionBox" type="button" class="close" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="panel-body">
            <div class="form-group">
              <input v-model="searchQuery" focus="true" v-on:keyup="search" class="form-control">
            </div>
            <div v-show="foundResult" v-for="result in results" class="row">
              <div class="col-md-12">
                <span v-on:click="chooseName" v-bind:id="result.name">{{ result.name }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    export default {
      data () {
        return {
          searchQuery: [],
          results: [],
          foundResult: false,
        }
      },
      methods: {
        closeMentionBox () {
          this.$store.dispatch('hideMentionBox');
        },
        search () {
          axios.get('/api/find/user/' + this.searchQuery)
          .then((res) => {
            this.results = res.data;
            this.foundResult = true;
          })
          .catch((err) => {
            console.log(err);
          })
        },
        chooseName (e) {
          let name = e.target.id || e.srcElement.id;
          this.$store.dispatch('setTweet', this.$store.getters.getTweet + name);
          this.$store.dispatch('hideMentionBox');
          this.results = [];
        }
      },
      mounted() {
          console.log('Component mounted.')
      }
    }
</script>

<style scoped>
.container-fluid {
  position: absolute;
  margin-left: auto;
  margin-right: auto;
  top: 20%;
  left: 0;
  right: 0;
  z-index: 4;
}
.panel {
  -webkit-box-shadow: 10px 10px 38px -11px rgba(0,0,0,0.75);
  -moz-box-shadow: 10px 10px 38px -11px rgba(0,0,0,0.75);
  box-shadow: 10px 10px 38px -11px rgba(0,0,0,0.75);
}
</style>
