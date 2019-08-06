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
            <el-col :offset="3" :span="19">
                <el-table
                        :loading="isTableLoading"
                        :data="data"
                        style="width: 100%">
                    <el-table-column
                            prop="id"
                            label="#"
                            width="100">
                    </el-table-column>
                    <el-table-column
                            prop="uri"
                            label="URL"
                            width="550">
                    </el-table-column>
                    <el-table-column
                            prop="created_at"
                            label="Дата"
                            width="200">
                    </el-table-column>
                </el-table>
            </el-col>
        </el-row>

        <el-row>
            <el-col :offset="3" :span="20">
                <el-pagination
                        background
                        layout="prev, pager, next"
                        page-size="20"
                        current-change
                        @current-change="changePage"
                        :total="totalLinks">
                </el-pagination>
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
                data: [],
                isTableLoading: true,
                totalLinks: 0,
                currentPage: 1
            }
        },
        created() {
            this.getClient();
        },
        methods: {
            getClient() {
                axios.get('/api/client/' + this.$route.params.name).then(response => {
                    this.client = response.data;
                    this.getLinks();
                }).catch(reason => {
                    this.$message.error('Не удалось получить клиента ' + this.$route.params.name);
                })
            },
            getLinks() {
                this.isTableLoading = true;
                axios.get('/api/links/' + this.client.id + '?page=' + this.currentPage + '&uid=without').then(response => {
                    this.data = response.data.data;
                    this.totalLinks = response.data.total;
                    this.isTableLoading = false;
                }).catch(reason => {
                    this.isTableLoading = false;
                    this.$message.error('Не удалось получить ссылки');
                });
            },
            changePage(newPage) {
                this.currentPage = newPage;
                this.getLinks();
            }
        }
    }
</script>

<style scoped>

</style>