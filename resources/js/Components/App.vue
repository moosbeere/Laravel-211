<template>
    <div> new component vue </div>
</template>
<script>
    export default{
        data(){
            return {name:null};
        },
        created(){
            window.Echo.channel('test').listen('PublicArticleEvent', (name)=>{
                console.log(name);
            })
        }
    }
</script>