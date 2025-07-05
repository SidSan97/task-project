<template>
    <div>
        <ModalHeader
            :title="'Nova task'"
            @close="$emit('close')"
        />

        <div class="container mt-2">
            <div class="mb-3">
                <label for="title" class="form-label">Título</label>
                <input type="text" id="title" class="form-control" v-model="task.title"> 
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Descrição</label>
                <textarea class="form-control" id="description" rows="3" v-model="task.description"></textarea>
            </div>

            <div class="mb-3">
                <label for="limitDate" class="form-label">Data Limite</label>
                <input type="datetime-local" id="limitDate" class="form-control" v-model="task.limit_date">
            </div>
        </div>

        <div class="p-3 footerModal d-flex justify-content-end">
            <button class="btn btn-success" @click="send()">Enviar</button>
        </div>
    </div>
</template>

<script lang="ts">
    import axios from 'axios';
    import ModalHeader from '../ModalHeader.vue';
    import { popModal } from 'jenesius-vue-modal';
    import {swalSuccess, swalError} from '../../utils/alerts.ts'

    export default {
        name: 'CreateTaskModal',
        components: {
            ModalHeader,
        },
        props: {
            onFinish: { //props que dispara evento pro pai ler load() ao terminar requisição
                type: Function,
                required: false
            }
        },
        data() {
            return {
                task: {
                    title: '',
                    description: '',
                    limit_date: ''
                },
                responseMessage: '',
            }
        },
        methods: {
            async send() {
                this.$loading.show();
                try {
                    const response = await axios.post('http://127.0.0.1:8000/api/task', this.task);
                    console.log(response.data.message)
                } catch (error: any) {
                    console.error(error)
                    swalError(error.response.data.message)
                } finally {
                    this.$loading.hide();

                    if (this.onFinish) 
                        this.onFinish();

                    popModal();
                }
            },
        },
    }
</script>

<style scoped>
    .footerModal {
        border-top: 1px solid silver;
    }
</style>