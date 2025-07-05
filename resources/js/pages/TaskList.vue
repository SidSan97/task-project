<template>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3 menu-nav">
            <h4 class="fw-bold">Tarefas</h4>
            <button class="btn btn-success rounded-pill px-3" @click="OpenCreateTaskModal()">
                <i class="bi bi-plus-lg"></i>
            </button>
        </div>

        <h4 v-if="tasks.length === 0">Nenhuma tarefa criada</h4>

        <ul class="list-unstyled" v-else>
            <li 
                v-for="(task, index) in tasks" :key="index" 
                class="d-flex justify-content-between align-items-start mb-3 item-list"
                @click="openEditTaskModal(task)"
            >
                <div class="form-check">
                    <input 
                        class="form-check-input" 
                        type="checkbox" 
                        v-model="task.finish" 
                        :checked="task.finish === 1"
                        @change="finishTask(task.id, task.finish)
                    "/>
                </div>

                <div class="flex-grow-1 ms-2">
                    <div :class="{ 'text-decoration-line-through text-muted': task.finish }">
                        <strong>{{ task.title }}</strong>
                    </div>

                    <div>
                        <span class="badge rounded-pill bg-light text-dark">
                            {{ formatDate(task.limit_date) }}
                        </span>
                    </div>
                    <div v-if="task.description" class="text-muted small mt-1">{{ task.description }}</div>
                </div>

                <button class="btn btn-outline-danger rounded-circle" @click="deleteTask(index, task.id)">
                    <i class="bi bi-trash"></i>
                </button>
            </li>
        </ul>
    </div>
    <!--COMPONENT PRO MODAL FUNCIONAR-->
    <widget-container-modal />
</template>

<script lang="ts">
import {container, popModal} from "jenesius-vue-modal";
import axios from 'axios';
import {pushModal, openModal} from 'jenesius-vue-modal';
import ModalHeaderVue from '@/components/ModalHeader.vue';
import CreateTaskModal from '@/components/modal/CreateTaskModal.vue';
import EditTaskModalVue from '@/components/modal/EditTaskModal.vue';
import {swalError} from '../utils/alerts.ts'

export default {
    name: 'TaskList',
    components: {
        WidgetContainerModal: container,
        CreateTaskModal,
        EditTaskModalVue,
        ModalHeaderVue
    },
    data() {
        return {
            tasks: []
        };
    },
    created() {
        this.load();
    },
    methods: {
        async load() {
            this.$loading.show();
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/task');
                this.tasks = response.data.data.map(task => ({
                    ...task,
                    finish: task.finish == 1
                }));
            }catch(error: any) {
                console.error(error);
                swalError(error.response.data.error)
            }finally{
                this.$loading.hide();
            }
        },

        async finishTask(id: number, finish: boolean) {
            this.$loading.show();
            const data = {
                status: finish ? 1 : 0,
            }

            try {
                const response = await axios.put('http://127.0.0.1:8000/api/task-status/' + id, data);
                console.log(response.data.message)
            }catch(error: any) {
                console.error(error);
                swalError(error.response.data.error)
            }finally{
                this.$loading.hide();
                this.load();
            }
        },

        formatDate(date: string|Date) {
            const today = new Date();
            const tomorrow = new Date();
            tomorrow.setDate(today.getDate() + 1);

            //const data = new Date(date);
            //date = data.toLocaleDateString("pt-BR");
            
            const input = new Date(date);
            input.setHours(0, 0, 0, 0);

            if (input.getTime() === today.setHours(0, 0, 0, 0)) {
                return 'Hoje';
            } else if (input.getTime() === tomorrow.setHours(0, 0, 0, 0)) {
                return 'Amanhã';
            } else {
                return input.toLocaleDateString('pt-BR', {
                    weekday: 'long',
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                });
            }
        },

        async deleteTask(index: number, id: number) {
            try {
                const response = await axios.delete('http://127.0.0.1:8000/api/task/' + id);
                console.log(response.data.message)
            }catch(error: any) {
                console.error(error);
                swalError(error.response.data.error)
            }finally{
                this.tasks.splice(index, 1);
                popModal();
                this.load();
            }
        },

        OpenCreateTaskModal() {
            pushModal(CreateTaskModal, {onFinish: this.load});
        },

        openEditTaskModal(task: object) {
            pushModal(EditTaskModalVue, {taskData: task, onFinish: this.load})
        }
    }
};
</script>

<style scoped>
    .badge {
        font-weight: normal;
        border: 1px solid;
        padding: 5px;
    }
    .item-list {
        cursor: pointer;
        padding: 10px;
        border-radius: 6px;
    }
    .item-list:hover {
        background-color: rgb(248, 248, 247);
    }
    .menu-nav {
        padding-bottom: 5px;
        border-bottom: 2px solid #c0c0c02e;
    }
</style>