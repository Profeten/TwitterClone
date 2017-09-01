<template>
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="form-group">
              <textarea v-model="tweet" class="form-control"></textarea>
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
  </div>
</template>

<script>
  export default {
      name: 'newtweet',
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
                console.log('There was an error processing your request')
              }
            });
          } else {
            console.log('Tweets must be longer than 3 characters');
          }
        }
      },
      mounted () {
        console.log('Tweet mounted.')
      }
  }
</script>

<style scoped>
.counter {
  float: right;
}
.warning {
  color: red;
}
</style>
