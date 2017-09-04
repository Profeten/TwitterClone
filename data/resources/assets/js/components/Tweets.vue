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
            axios.get('/api/tweets')
            .then(res => {
              if (!_.isEqual(this.tweets, res.data)) {
                this.tweets = res.data;
              }
            })
            .catch(err => {
              console.log(err);
            });
          });
        },
      },
      beforeCreate () {
        axios.get('/api/tweets')
        .then(res => {
          this.tweets = res.data;
          this.isLoaded = true;
        })
        .catch(err => {
          console.log(err);
        });
      },
      mounted() {
        this.listen();
        console.log('Tweets mounted ')
      }
  }
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: all .5s ease-in
}
.fade-enter, .fade-leave-to {
  transform: translateY(15px);
  opacity: 0
}
.posted {
  float: right;
}
.panel {
  padding: 15px;
  background-color: #E2E4E6;
}
.panel-body {
  position: relative;
  background-color: whitesmoke;
  padding-top: 25px;
}
.author {
  position: absolute;
  top: 22px;
  left: 45px;
  z-index: 3;
  font-weight: bold;
  font-size: 10px;
}
.timestamp {
  position: absolute;
  top: 22px;
  right: 45px;
  z-index: 3;
  font-weight: bold;
  font-size: 10px;
}
</style>
