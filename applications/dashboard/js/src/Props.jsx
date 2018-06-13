import React, { Component } from 'react';

class Props extends Component {
    render() {
        return (
            <main>
                <h1>Rendered by React (via v8js with snapshot and props)</h1>
                <ul>
                    {this.props.items.map(item => (
                        <li key={item.id}><strong>{item.name}</strong><br />{item.description}</li>
                    ))}
                </ul>
            </main>
        );
    }
}

export default Props;

// need to export globally for SSR purposes
global.SsrComponent = Props;
