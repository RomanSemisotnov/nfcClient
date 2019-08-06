<template>
    <div id="main">
        <Header/>
        <div class="content">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    import Header from './Header.vue';
    import axios from 'axios';

    export default {
        name: 'main-app',
        components: {Header},
        created() {
        }
    }
</script>
