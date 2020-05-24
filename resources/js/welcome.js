const app = require('./app').default;

axios.get('./api/posts')
    .then(response => {
        let posts = response.data.posts;
        app.posts = posts;
    });