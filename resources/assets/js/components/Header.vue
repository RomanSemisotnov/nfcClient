<template>
    <el-menu  v-if="$store.state.currentUser" :default-active="'client/dodo'" class="el-menu-demo" mode="horizontal" @select="handleSelect">
        <el-menu-item :key="client.id" v-for="client in clients" :index="'client/'+client.name+'/params'">{{client.name}}</el-menu-item>
        <el-menu-item  index="client/new">Новый клиент</el-menu-item>
    </el-menu>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                clients: []
            }
        },
        created() {
            this.getClients();
        },
        methods: {
            getClients() {
                axios.get('/api/client/all').then(response => {
                    this.clients = response.data;
                }).catch(reason => {
                    this.$message.error('Ошибка, не удалось получить клиентов');
                });
            },
            handleSelect(key, keyPath){
                this.$router.push('/'+key)
            }
        },
        watch: {
            '$route'( to, from ) {
                this.getClients();
            },
        },

    }
</script>
