<template>
    <div class="own-modal-dialog">
      <div class="own-modal-content">
        <div class="own-modal-header">
          <h5 class="title">
            {{ title }}
          </h5>
          <button class="btn-close" aria-label="close" @click="closeModal()"><i class="bi bi-x-lg"></i></button>
        </div>
      </div>
    </div>
  </template>
  
<script lang="ts">
  import { popModal } from 'jenesius-vue-modal'
  
  export default {
    name: 'ModalHeader',
    props: {
      title: {
        required: false,
        type: String
      }
    },
    methods: {
      closeModal() {
        popModal()
      }
    }
  }
</script>
  
<style scoped>
  .own-modal-dialog {
    min-width: var(--min-width);
    max-width: var(--max-width);
    background-color: #fff;
    border-radius: 10px;
  }
  
  .own-modal-content {
    min-height: var(--min-height);
    max-height: var(--max-height);
  }
  .own-modal-header {
    display: flex;
    flex-shrink: 0;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1rem;
    border-bottom: 1px solid #dee2e6;
    border-top-left-radius: calc(0.3rem - 1px);
    border-top-right-radius: calc(0.3rem - 1px);
  }
</style>
  