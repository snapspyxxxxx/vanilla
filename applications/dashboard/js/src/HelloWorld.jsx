import React, { Component } from 'react';

class HelloWorld extends Component {
    render() {
        return (
            <h1>Rendered by React (via v8js)</h1>
        );
    }
}

export default HelloWorld;
global.HelloWorld = HelloWorld;
