<template>
  <transition name="fade">
    <div v-show="getMessageStatus" class="container-fluid success">
      <div class="row">
        <div class="col-md-12">
          {{getMessage}}
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
  export default {
    computed: {
      getMessage () {
        return this.$store.getters.getSuccessMessage;
      },
      getMessageStatus () {
        return this.$store.getters.getSuccessMessageStatus;
      },
    },
    mounted() {
      console.log(this.$store.getters);
    }
  }
</script>

<style scoped>
.success {
  background-color: forestgreen;
  color: white;
  font-weight: bold;
  margin-top: -22px;
  margin-bottom: 22px;
  text-align: center;
  padding: 25px;
}
.fade-enter-active, .fade-leave-active {
  transition: all 1s ease-in
}
.fade-enter, .fade-leave-to {
  transform: translateY(-15px);
  opacity: 0
}
</style>
