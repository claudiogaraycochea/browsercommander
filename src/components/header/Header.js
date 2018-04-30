// Dependencies
import React, { Component } from 'react';

// Assets
import './header.css';

class Header extends Component {
  render() {
    return (
      <div className="Header">
        <header>
          <nav class="navbar navbar-expand-lg navbar-light bg-inverse text-white">
            Browser Commander | The Norton Commander's grandson
          </nav>
        </header>
      </div>
    );
  }
}

export default Header;