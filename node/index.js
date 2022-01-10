const express = require('express'),
    cors = require('cors'),
    compression = require('compression'),
    morgan = require('morgan'),
    bodyParser = require('body-parser'),
    tatum = require('./tatum');
require('dotenv').config();
const app = express();

// app.use(cors());
// app.use(compression());
app.use(morgan('dev'));
app.use(bodyParser.json({limit: '150mb'}));
app.use(bodyParser.urlencoded({limit: '50mb', extended: true}));

app.use('/tatum', tatum);

app.listen(9999, () => {
    console.log('Example app listening at http://localhost:9999')
  });
