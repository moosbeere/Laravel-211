<template>
    <div>gfghdsfkgfj</div>
</template>
<script>
    export default{
        created(){
            window.Echo.channel('test').listen('PublicArticle', (name)=>{
                alert('Добавлена статья');
                console.log('name');
            })
        }
    }
</script>