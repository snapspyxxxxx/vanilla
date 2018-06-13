import React, { Component } from 'react';

class HelloWorldSnapshot extends Component {
    render() {
        return (
            <h1>Rendered by React (via v8js with snapshot)</h1>
        );
    }
}

export default HelloWorldSnapshot;

// need to export globally for SSR purposes
global.SsrComponent = HelloWorldSnapshot;
