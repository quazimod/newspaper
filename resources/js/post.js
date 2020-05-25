const app = require('./app').default;

const post_id = app.$refs['post_id'].value;
const author_id = app.$refs['post_author_id'].value;

axios.get('/public/api/author?author_id=' + author_id)
    .then(response => {
        let author = response.data.authors;
        _.remove(author.posts, (post) => {
            console.log(post_id,post.id,post.id == post_id);
            return post.id == post_id;
        });
        app.posts = author.posts;
        app.author = author;
    });