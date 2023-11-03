<script >
import { router } from '@inertiajs/vue3';
import axios from 'axios';
import { ref } from 'vue'
export default {
    props: {
      totalUsers: Number
    },
    setup(props) {
        
        const pageData = ref({
            totalUsers: 0,
            added: 0,
            updated: 0
        });

        const showLoader = ref(false)

        const importUsers = async () => {
            showLoader.value = true
            
            await axios.get(route('import')).then(({ data }) => {
                pageData.value.totalUsers = data.total
                pageData.value.added = data.added
                pageData.value.updated = data.updated
            }).catch(() => {
                alert(error)
            }).finally(() => {
                showLoader.value = false
            });
        }


        return{
            props,
            importUsers,
            pageData,
            showLoader
        }
    }
}

</script>

<template>
    <div class="d-flex align-items-center">
        <button @click="importUsers()" type="button" class="btn btn-primary mr-2" :disabled="showLoader">
            {{ showLoader ? 'Загрузка...' : 'Импортировать пользователей' }}
        </button>
        <div class="mr-2">
            <span>
                Всего:
            </span>
            <span class="fw-bold">
                {{ pageData.totalUsers != 0 ? pageData.totalUsers : props.totalUsers }},
            </span>
        </div>
        <div class="mr-2">
            <span>
                Добавлено:  
            </span>
            <span class="fw-bold">
                {{ pageData.added }},
            </span>
        </div>
        <div>
            <span>
                Обновлено: 
            </span>
            <span class="fw-bold">
                {{ pageData.updated }}
            </span>
        </div>
    </div>
</template>

<style>

</style>
