<template>

</template>
<script>
    export default {
    data() { return { msg: null } },
        created() {
            window.Echo.channel('test').listen('NewArticleEvent', (e) => {
                alert('Добавлена новая статья!');
            })
        }
    }
</script>