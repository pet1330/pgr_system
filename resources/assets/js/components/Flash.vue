<template>
    <transition name="slide-fade">
        <div class="alert alert-flash alert-success" role="alert" v-show="show">
          <strong>SUCCESS!</strong><br> {{ body }}
        </div>
  </transition>
</template>

<script>
    export default {
        props: ['message'],
        data() {
            return {
                body: this.message,
                show: false
            }
        },
        created() {
            if(this.message) {
                this.flash(this.message)
            }

            window.events.$on('flash', message => {
                this.flash(message); 
            });
        },
        methods: {
            flash (message) {
                this.body = message;
                this.show = true;
                this.hide();
            },
            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 3000);
            }
        }
    }
</script>

<style>
    .alert-flash
    {
        position: fixed;
        right: 25px;
        bottom: 25px;
        z-index: 99999;
    }
    .slide-fade-enter-active {
        transition: all 1.0s ease;
    }
    .slide-fade-leave-active {
        transition: all 1.0s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .slide-fade-enter, .slide-fade-leave-to{
        transform: translateX(30px);
        opacity: 0;
    }
</style>