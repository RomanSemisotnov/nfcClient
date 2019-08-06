<template>
    <el-container>
        <el-header></el-header>
        <el-main>
            <el-row>
                <el-col :offset=8 :span="8">
                    <el-input placeholder="Email" v-model="email"></el-input>
                </el-col>
            </el-row>
            <el-row>
                <el-col :offset=8 :span="8">
                    <el-input placeholder="Password" v-model="password" show-password></el-input>
                </el-col>
            </el-row>
            <el-row>
                <el-col :offset=8 :span="8">
                    <el-button type="primary" @click="login()" :loading="isLoading" plain>Войти</el-button>
                </el-col>
            </el-row>
        </el-main>
    </el-container>
</template>

<script>
    import {login} from './../helpers/auth';
    export default {
        data() {
            return {
                email: '',
                password: '',
                isLoading: false
            }
        },
        methods:{
            login(){
                this.$store.dispatch('login');
                this.isLoading=true;
                login({email:this.email, password:this.password})
                    .then((res) => {
                        this.isLoading=false;
                        this.$store.commit("loginSuccess", res);
                        this.$router.push({path: '/'});
                    })
                    .catch((error) => {
                        this.isLoading=false;
                        this.$store.commit("loginFailed", {error});
                        this.$message.error('Неправильный логин или пароль');
                    });
            }
        }
    }
</script>

<style scoped>

</style>