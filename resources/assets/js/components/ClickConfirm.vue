<template>
  <div>
    <button class="btn btn-danger" v-if="!confirm" @click.prevent="confirm=!confirm">
        <slot></slot>
    </button>
      <span v-if="confirm" class='btn btn--nohover btn--transparent'>
        Are you sure?
      </span>
      <br>
    <button class="btn btn-danger" v-if="confirm">
      Yes
    </button>
    <button class="btn btn-warning" v-if="confirm" @click.prevent="confirm=!confirm">
      No
    </button>
  </div>
</template>

<script>
export default {

  data() {  
    return {
      confirm: false
    }
  }
};

</script>
