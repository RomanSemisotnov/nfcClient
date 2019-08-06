<template>
    <div>
        <client-nav-bar></client-nav-bar>

        <el-row>
            <el-col :offset="3" :span="21">
                <h2 style="display: inline-block;">{{client.name}}</h2>
                <h2 style="display: inline-block;">-----</h2>
                <h2 style="display: inline-block;">{{client.uri}}</h2>
            </el-col>
        </el-row>


        <el-row>
            <el-col :offset="1" :span="22">

                <el-card class="box-card">
                    <el-row>
                        <el-col :offset="1" :span="22">
                            <div style="display: inline-block"><h4>https://{{client.name}}.nfc-u.ru/</h4></div>
                            <div :key="index" v-for="(value, index) in client.params" style="display: inline-block">
                                <el-select v-if="value.variables.length && value.type !== 'token'"
                                           v-model="params[index].value"
                                           placeholder="Select">
                                    <el-option
                                            v-for="(varialbe, indexVar) in value.variables"
                                            :key="indexVar"
                                            :label="varialbe.name"
                                            :value="varialbe.name">
                                    </el-option>
                                </el-select>
                                <span v-else-if="value.type === 'token'">ТОКЕН</span>
                                <span v-else>Параметры отсутствуют</span>
                                <span>/</span>
                            </div>
                        </el-col>
                    </el-row>


                    <el-row>
                        <el-col :offset="1" :span="6">
                            <el-input placeholder="Количество ссылок" v-model="countLinks"></el-input>
                        </el-col>
                        <el-col :span="9">
                            <el-button :loading="isAdding" type="primary" @click="addLinks()" plain>Добавить</el-button>
                        </el-col>
                    </el-row>
                </el-card>

            </el-col>
        </el-row>


    </div>
</template>

<script>
    import axios from 'axios';
    import clientNavBar from './../components/clientNavBar';

    export default {
        components: {
            clientNavBar
        },
        data() {
            return {
                client: {},
                params: [{value: ''}, {value: ''}, {value: ''}, {value: ''}, {value: ''}],
                countLinks: '',
                isAdding: false
            }
        },
        created() {
            this.getClient();
        },
        methods: {
            addLinks() {
                let myParams=[];
                for (let index = 0; index < this.client.params.length; index++) {
                    if (this.params[index].value.trim() && this.client.params[index].type !== 'token' ) {
                        myParams.push(this.params[index].value.trim());
                    } else if(this.client.params[index].type === 'token'){
                        myParams.push('token');
                    }else{
                        this.$message.error('Параметр ' + (index+1) + ' не назначен');
                        return;
                    }
                }

                this.isAdding = true;
                axios.post('/api/links', {
                    count: this.countLinks,
                    client_id: this.client.id,
                    params: myParams
                }).then(response => {
                    this.isAdding = false;
                    this.$message.success('Успешно добавленно '+this.countLinks+' ссылки');
                }).catch(reason => {
                    this.isAdding = false;
                    this.$message.error('Не удалось добавить ссылки');
                });
            },
            getClient() {
                axios.get('/api/client/' + this.$route.params.name).then(response => {
                    this.client = response.data;
                }).catch(reason => {
                    this.$message.error('Не удалось получить клиента ' + this.$route.params.name);
                })
            },
        },
        watch: {
            '$route'(to, from) {

            },
        }
    }
</script>

<style scoped>

</style>