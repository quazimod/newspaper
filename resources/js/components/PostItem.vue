<template>
    <div class="post-item card flex-md-row box-shadow mr-4 mb-4">
        <div class="card-body d-flex flex-column align-items-start">
            <strong class="d-inline-block mb-2 text-primary">
                <a :href="author.url">{{ author.name }}</a>
            </strong>
            <div class="mb-1 text-muted">{{ post.created_at }}</div>
            <p class="card-text">{{ post.title }}</p>
            <a :href="post.id">Read more...</a>
        </div>
        <div class="p-3">
            <img class="card-img-right w-100" :src="post.image_url">
        </div>
    </div>
</template>

<script>
    export default {
        props: ['post', 'author'],
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

<style scoped>

</style>