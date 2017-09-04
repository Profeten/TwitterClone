<template>
  <transition name="fade">
    <div v-if="isLoaded" class="container">
      <div v-for="tweet in tweets" class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
            <label class="author">@{{tweet.messaged_by}} wrote...</label>
            <label class="timestamp">{{fromNow(tweet.created_at)}}</label>
            <div class="panel-body" v-html="tweet.message">
            </div>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
  import moment from 'moment';
  export default {
      data () {
        return {
          isLoaded: false,
          tweets: []
        }
      },
      methods: {
        fromNow (date) {
          return moment(date, 'YYYY-MM-DD hh:mm:ss').fromNow();
        },
        listen () {
          Echo.channel('tweets')
          .listen('newTweet', event => {
            axios.get('/api/mentioned/' + this.$route.params.user)
            .then(res => {
              if (!_.isEqual(this.tweets, res.data)) {
                this.tweets = res.data;
              }
            })
            .catch(err => {
              console.log(err);
            });
          });
        }
      },
      mounted() {
        this.listen();
        axios.get('/api/mentioned/' + this.$route.params.user)
        .then(res => {
          this.tweets = res.data;
          this.isLoaded = true;
        })
        .catch(err => {
          console.log(err);
        });
        console.log(this.$route.params.user + '\'s mentions mounted.')
      }
  }
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: all .5s ease-in
}
.fade-enter, .fade-leave-to  {
  transform: translateY(15px);
  opacity: 0
}
.posted {
  float: right;
}
</style>
