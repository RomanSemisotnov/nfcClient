<template>
    <el-form ref="form" :model="form" label-width="200px">

        <el-row  :gutter="24">
            <el-col :offset="3" :span="14">
                <el-form-item label="Имя Клиента">
                    <el-input v-model="form.name"></el-input>
                </el-form-item>
            </el-col>
        </el-row>

        <el-row  :gutter="24">
            <el-col :offset="3" :span="14">
                <el-form-item label="Страница редиректа">
                    <el-input v-model="form.redirectTo"></el-input>
                </el-form-item>
            </el-col>
        </el-row>

        <el-row  :gutter="24">
            <el-col :offset="9" :span="8">
                <el-button :loading="isLoading" @click="create()" type="primary" round>Добавить</el-button>
            </el-col>
        </el-row>

    </el-form>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                isLoading: false,
                form: {
                    name: '',
                    redirectTo: ''
                }
            }
        },
        methods: {
            create() {
                this.isLoading = true;
                axios.post('/api/client/create', this.form).then(response => {
                    this.isLoading = false;
                    this.$router.push({path: '/client/' + this.form.name + '/params'});
                }).catch(reason => {
                    this.isLoading = false;
                    this.$message.error('Не удалось добавить клиента');
                });
            }
        }
    }
</script>

<style scoped>

</style>