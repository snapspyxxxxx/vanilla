import React from 'react';
import ReactDOM from 'react-dom';
import ReactDOMServer from 'react-dom/server'

// we need to put these objects on global scope so things can server-side render
global.React = React;
global.ReactdDOM = ReactDOM;
global.ReactDOMServer = ReactDOMServer;
