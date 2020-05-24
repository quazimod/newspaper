const app = require('./app').default;

const author_id = app.$refs['post_author_id'].value;

axios.get('/public/api/author?author_id=' + author_id)
    .then(response => {
        let author = response.data.authors;
        app.posts = author.posts;
        app.author = author;
    });