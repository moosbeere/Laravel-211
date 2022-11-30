<template>
    <div>
        new component
    </div>
</template>
<script>
    export default {
        mounted() {
            console.log('Component mounted.')
            window.Echo.channel('tesT').listen('NewArticleEvent', (e) => {
                alert('Добавлена новая статья!');
            })
        }
    }
</script>