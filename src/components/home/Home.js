// DEPENDENCIES
import React, { Component } from "react";
import Request from "superagent";
import "./home.css";
import _ from "lodash";

import * as config from "../../config";

/* LABELS */
const LABEL_CREATE_FOLDER = 'Create';
const LABEL_DELETE = 'Delete';
const LABEL_RENAME = 'Rename';
const LABEL_FILE_OR_FOLDER = 'File or Folder Name';
const LABEL_PATH = 'PATH: .';

class Home extends Component {
  constructor() {
    super();

    this.state = {
      items: [],
      value: '',
      type: 'file'
    };

    /* ROOT FOLDER */
    this.path = '';

    /* FOLDER EVENTS */
    this.handleListFolderClick = this.handleListFolderClick.bind(this);
    this.handleRemoveClick = this.handleRemoveClick.bind(this);
    this.handleCreateClick = this.handleCreateClick.bind(this);
    this.handleRenameClick = this.handleRenameClick.bind(this);

    /* CHANGES EVENTS */
    this.handleNewValueChange = this.handleNewValueChange.bind(this);
    this.handleTypeChange = this.handleTypeChange.bind(this);
  }

  componentDidMount() {
    this.listFolder();
  }

  /* LIST FOLDER */
  listFolder(){
    const url = `${config.LIST_FOLDER_URL}/?path=`+this.path;
    Request.get(url).then(response => {
      this.setState({
        items: response.body
      });
    });
  }

  /* HANDLE */
  handleListFolderClick(e) {
    if (e.target.id === '..') {
      this.path = this.path.substr(0, this.path.lastIndexOf("/"));
    } else if (e.target.id === '.'){
      this.path = '';
    } else if(e.target.value === 'FOLDER') {
      this.path = this.path + "/" + e.target.id;
    } else if(e.target.value === 'FILE') {
      alert('I\'m sorry. I can\'t open a file!');
    }
    this.listFolder();
  }

  handleCreateClick(e) {
    e.preventDefault();
    const url = `${config.CREATE_URL}/?path=${this.path}&new=${this.state.value}&type=${this.state.type}`;
    Request.get(url).then(response => {
      this.listFolder();
    });
  }

  handleRemoveClick(e) {
    const url = `${config.REMOVE_URL}/?path=${this.path}&remove=${e.target.id}`;
    Request.get(url).then(response => {
      this.listFolder();
    });
  }
  
  handleRenameClick(e) {
    const url = `${config.RENAME_URL}/?path=${this.path}&name=${e.target.id}&rename=${this.state.value}`;
    Request.get(url).then(response => {
      this.listFolder();
    });
  }

  /* INPUT CHANGES */
  handleNewValueChange(e) {
    this.setState({value: e.target.value});
  }

  handleTypeChange(e) {
    this.setState({type: e.target.value});
  }

  render() {
    /* BUILD ITEMS */
    const items = _.map(this.state.items, item => {
      let iconItem = `icon-${item.type}`;
      return (
        <li>
          <button id={item.name} value={item.type} className="item" onClick={this.handleListFolderClick}>
            <i className={iconItem}/> {item.name}
          </button>
          <div className="option">
            <button id={item.name} className="btn btn-danger btn-sm mr-2" onClick={this.handleRemoveClick}>
              {LABEL_DELETE}
            </button>
            <button id={item.name} className="btn btn-primary btn-sm" onClick={this.handleRenameClick}>
              {LABEL_RENAME}
            </button>
          </div>
        </li>
      );
    });

    return (
      <div className="console mt-4 col-md-6 mx-auto">
        <div>{LABEL_PATH}{this.path}</div>
        <ul className="list-folder">{items}</ul>
        <form onSubmit={this.handleCreateClick}>
          <div className="form-group">
            <input type="text" value={this.state.value} onChange={this.handleNewValueChange} className="form-control form-control-lg rounded-0" required="" placeholder={LABEL_FILE_OR_FOLDER}/>
          </div>
          <div className="form-group">
            <select value={this.state.type} onChange={this.handleTypeChange} className="form-control form-control-lg rounded-0">
              <option value="file">File</option>
              <option value="folder">Folder</option>
            </select>
          </div>
          <div className="form-group">
            <input type="submit" value={LABEL_CREATE_FOLDER} className="btn btn-success btn-lg" />
          </div>
        </form>
      </div>
    );
  }
}

export default Home;
