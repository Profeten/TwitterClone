<template>
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="form-group">
              <textarea
                v-model="tweet"
                v-on:keydown.alt.50="mention"
                class="form-control">
              </textarea>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-10">
                  <button v-if="tweet.length <= 160" v-on:click="submitTweet" class="btn btn-success">Submit</button>
                  <button v-if="tweet.length > 160" v-on:click="submitTweet" class="btn btn-success" disabled>Submit</button>
                </div>
                <div class="col-md-2">
                  <span v-if="tweet.length <= 160" class="counter">{{ tweet.length }} / 160</span>
                  <span v-if="tweet.length > 160" class="counter warning">{{ tweet.length }} / 160</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <transition name="fade">
      <MentionList v-show="displayMentionBox"></MentionList>
    </transition>
  </div>
</template>

<script>
  import MentionList from './Modals/MentionList.vue';
  export default {
      name: 'newtweet',
      components: {
        MentionList
      },
      computed: {
        displayMentionBox () {
          return this.$store.getters.getMentionBoxStatus;
        }
      },
      data () {
        return {
          tweet: [],
        }
      },
      methods: {
        submitTweet () {
          if (this.tweet.length > 3) {
            axios.post('/home', { data: this.tweet })
            .then((res) => {
              if (res.status === 200) {
                this.tweet = [];
                this.$store.dispatch('setSuccessMessage', 'Success!');
              } else {
                console.log('There was an error processing your request please try again later')
              }
            });
          } else {
            console.log('Tweets must be longer than 3 characters');
          }
        },
        mention (e) {
          this.$store.dispatch('showMentionBox');
        }
      },
      mounted () {
        console.log('Tweet mounted.')
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
.counter {
  float: right;
  color: whitesmoke;
}
.warning {
  color: red;
}
</style>
