<template>
    <div class="post-item col-md-3">
        <div class="post-item-container">
            <div class="post-item-content">
                <a :href="[page_url] + 'post/'+[post.id]">
                    <p v-if="post.image_url" class="post-item-image">
                        <img :src="[post.image_url]">
                    </p>
                    <p class="post-item-title">{{ post.title }}</p>
                </a>
            </div>
            <p class="post-item-author">
                <a :href="[post.author.url]">{{ post.author.name }}</a>
            </p>
            <div class="post-item-activities">
                <div class="post-item-activity like-activity">
                    {{ post.likes.length }}
                </div>
                <div class="post-item-activity comment-activity">
                    {{ post.comments.length }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                page_url: window.location.href,
            }
        },
        props: ['post'],
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

<style scoped>

</style>
