import React, { Component } from 'react';
import '../styles/App.css';
import Header from './header/Header';
import Home from './home/Home';

class App extends Component {
  render() {
    return (
      <div className="App">
        <Header/>
        <div className="container fill">
          <Home/>
        </div>
      </div>
    );
  }
}

export default App;
