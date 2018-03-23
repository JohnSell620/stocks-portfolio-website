import "../data/data.json";
import "../data/stocks.json";
import React from 'react';
import ReactDOM from 'react-dom';
import $ from 'jquery';
import 'materialize-css/dist/css/materialize.min.css';
import 'materialize-css/dist/js/materialize.min.js';
import 'toastr/build/toastr.css';
import 'react-vis/dist/style.css';
import App from './App.js';
import './index.css';

$(document).ready(function() {
	$('.collapsible').collapsible();
});

ReactDOM.render(
  <App />,
  document.getElementById('root')
);
