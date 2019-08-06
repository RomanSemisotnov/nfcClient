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
            <el-col :span="23">
                <el-table
                        v-loading="isTableLoading"
                        :data="client.params"
                        style="width: 100%">
                    <el-table-column
                            width="40"
                            label="id">
                        <template slot-scope="scope">
                            {{scope.row.id}}
                        </template>
                    </el-table-column>
                    <el-table-column
                            width="140"
                            label="Тип">
                        <template slot-scope="scope">
                            <el-select v-model="scope.row.type" placeholder="Select">
                                <el-option
                                        v-for="item in options"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                </el-option>
                            </el-select>
                        </template>
                    </el-table-column>

                    <el-table-column type="expand">
                        <template slot-scope="scope" v-if="scope.row.type !== 'token'">
                            <el-button-group :key="index" v-for="(varialbe, index) in scope.row.variables">
                                <el-button type="primary" plain>{{varialbe.name}}</el-button>
                                <el-button type="primary" :loading="isDeleting"
                                           @click="deleteVariable(varialbe.id, scope.$index)"
                                           icon="el-icon-delete"></el-button>
                            </el-button-group>


                            <el-row>
                                <el-col :span="12">
                                    <el-input width="70%" placeholder="Please input" v-model="newVariable"></el-input>
                                </el-col>
                                <el-col :span="8">
                                    <el-button :loading="isAdding" @click="addNewVariable(scope.row.id, scope.$index)">
                                        Добавить
                                    </el-button>
                                </el-col>
                            </el-row>
                        </template>
                    </el-table-column>

                    <el-table-column
                            width="120"
                            label="Номер"
                            prop="index_number">
                    </el-table-column>
                    <el-table-column
                            width="200"
                            label="Название параметра"
                            prop="name">
                    </el-table-column>
                    <el-table-column
                            width="180"
                            label="">
                        <template slot-scope="scope">
                            <el-input placeholder="Please input" v-model="scope.row.name"></el-input>
                        </template>
                    </el-table-column>
                    <el-table-column
                            width="200"
                            label="">
                        <template slot-scope="scope">
                            <el-button :loading="isUpdate" @click="updateParamName(scope.row)"
                                       type="primary" size="mini" plain round>Сохранить
                            </el-button>
                        </template>
                    </el-table-column>
                    <el-table-column
                            width="200"
                            label="">
                        <template slot-scope="scope">
                            <el-button :loading="isFullDeleting" @click="deleteFullParam(scope.row, scope.$index)"
                                       type="danger" size="mini" plain round>Удалить
                            </el-button>
                        </template>
                    </el-table-column>
                </el-table>

            </el-col>
        </el-row>


    </div>
</template>

<script>
    import axios from 'axios';
    import clientNavBar from './../components/clientNavBar';

    export default {
        components:{
            clientNavBar
        },
        data() {
            return {
                client: {},
                isTableLoading : false,
                isUpdate: false,
                isDeleting: false,
                isAdding: false,
                newVariable: '',
                isFullDeleting: false,
                itTrue : true,
                options: [
                    {
                        value: 'token',
                        label: 'token'
                    }, {
                        value: 'param',
                        label: 'param'
                    }],
            }
        },
        created() {
            this.getClient();
        },
        methods: {
            deleteFullParam(row, index) {
                this.isFullDeleting = true;
                axios.post('/api/params/delete/'+row.id).then(response => {
                    this.isFullDeleting = false;
                    this.getClient();
                }).catch(reason => {
                    this.$message.error('Не удалось удалить параметр');
                    this.isFullDeleting = false
                })
            },
            addNewVariable(id, index) {
                this.isAdding = true;
                axios.post('/api/variable/create', {param_id: id, name: this.newVariable}).then(response => {
                    this.newVariable = '';
                    this.client.params[index].variables.push(response.data);
                    this.isAdding = false;
                }).catch(reason => {
                    this.isAdding = false;
                    this.$message.error('Ошибка добавления');
                });
            },
            deleteVariable(id, index) {
                this.isDeleting = true;
                axios.post('/api/variable/delete/' + id).then(response => {
                    let mass = this.client.params[index].variables;
                    for (let index in mass) {
                        console.log(index);
                        if (mass[index].id == id) {
                            mass.splice(index, 1);
                        }
                    }
                    this.isDeleting = false;
                }).catch(reason => {
                    this.$message.error('Не удалось удалить параметр');
                    this.isDeleting = false;
                });
            },
            getClient() {
                this.isTableLoading=true;
                axios.get('/api/client/' + this.$route.params.name).then(response => {
                    this.client = response.data;
                    this.isTableLoading=false;
                }).catch(reason => {
                    this.$message.error('Не удалось получить клиента ' + this.$route.params.name);
                    this.isTableLoading=false;
                })
            },
            updateParamName(row) {
                this.isUpdate = true;
                axios.post('/api/params/update/' + row.id, row).then(response => {
                    this.$message.success('Успешно обновленно');
                    this.isUpdate = false;
                }).catch(reason => {
                    this.$message.error('Не удалось обновить имя параметра');
                    this.isUpdate = false;
                })
            }
        },
        watch: {
            '$route'(to, from) {
                this.getClient();
            },
        },
    }
</script>

<style scoped>

</style>