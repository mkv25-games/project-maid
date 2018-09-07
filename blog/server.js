const express = require('express')
const path = require('path')
const app = express()

const phpExpress = require('php-express')({
  binPath: 'php' // assumes php is in your PATH
})

app.get('/*', render)
app.post('/*', render)

function render(req, res) {
  phpExpress.engine(path.join(__dirname, 'views/render.php'), {
    method: req.method,
    get: req.query,
    post: req.body,
    server: {
      REQUEST_URI: req.url
    }
  }, (err, body) => {
    if (err) {
      res.status(500).send(err)
    } else {
      res.send(body)
    }
  })
}

const server = app.listen(3000, function () {
  const port = server.address().port
  console.log('PHP Express server listening at http://%s:%s', 'localhost', port);
})
