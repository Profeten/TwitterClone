<template>
  <transition name="fade">
    <div v-if="isLoaded" class="container">
      <div v-for="tweet in tweets" class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
            <div class="panel-heading">
              <div class="row">
                <div class="col-md-6">
                  <strong>@{{tweet.messaged_by}}</strong>
                </div>
                <div class="col-md-6">
                  <span class="posted">{{fromNow(tweet.created_at)}}</span>
                </div>
              </div>
            </div>
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
            axios.get('/api/channel/' + this.$route.params.channel)
            .then(res => {
              this.tweets = res.data;
            })
            .catch(err => {
              console.log(err);
            });
          });
        }
      },
      mounted() {
        this.listen();
        axios.get('/api/channel/' + this.$route.params.channel)
        .then(res => {
          this.tweets = res.data;
          this.isLoaded = true;
        })
        .catch(err => {
          console.log(err);
        });
        console.log(this.$route.params.channel + ' channel mounted.')
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
