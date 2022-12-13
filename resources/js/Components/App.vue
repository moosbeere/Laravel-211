<template>
    <div v-show="this.name != null" class="alert alert-primary" role="alert">
        Добавлена новая статья: <strong>{{this.name}}</strong>
    </div>
</template>
<script>
    export default{
        data(){
            return {name:null};
        },
        created(){
            window.Echo.channel('test').listen('PublicArticleEvent', (name)=>{
                this.name = name;
                console.log(name['name']);
            })
        }
    }
</script>